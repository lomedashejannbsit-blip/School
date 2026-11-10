<?php
// 1. Declare the associative array with required keys
$student = array(
    "name" => "Rene Butterbollin",
    "age" => 22,
    "course" => "IT"
);

// 2. Encode to JSON string
$json_output = json_encode($student);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 1 - JSON Encoding</title>
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
            padding: 24px 32px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        h3 {
            margin-top: 0;
            margin-bottom: 14px;
            color: #1e293b;
            font-size: 16px;
        }
        code {
            background-color: #0f172a;
            color: #38bdf8;
            padding: 10px 16px;
            border-radius: 6px;
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 15px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="card">
        <h3>Lab Exercise 1: Basic JSON Output</h3>
        <code><?php echo $json_output; ?></code>
    </div>

</body>
</html>