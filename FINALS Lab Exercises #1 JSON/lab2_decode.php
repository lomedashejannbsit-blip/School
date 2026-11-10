<?php
// 1. Declare JSON string
$json_string = '{"name":"Rene","age":22,"email":"rene@butterbollin.com"}';

// 2. Decode into PHP Object and Associative Array
$user_obj = json_decode($json_string);
$user_arr = json_decode($json_string, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 2 - Decoding JSON</title>
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
        <h3>Lab Exercise 2: Decoding JSON</h3>
        <div class="code-box">
            Object: <?php echo $user_obj->name; ?><br>
            Array: <?php echo $user_arr['email']; ?>
        </div>
    </div>

</body>
</html>