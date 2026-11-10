<?php
// Read raw POST stream
$raw_input = file_get_contents('php://input');
$data = json_decode($raw_input, true);

// Extract values or use default fallback for browser preview
$username = isset($data['username']) ? $data['username'] : 'ReneBullin';
$password = isset($data['password']) ? $data['password'] : '143Rene';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 4 - Handling JSON Input</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: #ffffff;
            padding: 28px 36px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        h3 {
            margin-top: 0;
            margin-bottom: 16px;
            color: #1e293b;
            font-size: 17px;
            font-weight: 600;
        }
        .code-box {
            background-color: #0f172a;
            color: #38bdf8;
            padding: 14px 24px;
            border-radius: 8px;
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 15px;
            display: inline-block;
            text-align: left;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <div class="card">
        <h3>Lab Exercise 4: Handling JSON Input</h3>
        <div class="code-box">
            Username: <?php echo htmlspecialchars($username); ?><br>
            Password: <?php echo htmlspecialchars($password); ?>
        </div>
    </div>

</body>
</html>