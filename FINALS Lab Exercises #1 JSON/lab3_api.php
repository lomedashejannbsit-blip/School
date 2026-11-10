<?php
// Declare API profile array
$user_profile = array(
    "id" => 1,
    "name" => "Rene",
    "email" => "rene@butterbollin.com",
    "status" => "Active"
);

// Encode payload to JSON string
$json_output = json_encode($user_profile);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3 - JSON Response API Simulation</title>
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
            padding: 12px 20px;
            border-radius: 8px;
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 15px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <div class="card">
        <h3>Lab Exercise 3: JSON Response API Simulation</h3>
        <div class="code-box"><?php echo $json_output; ?></div>
    </div>

</body>
</html>