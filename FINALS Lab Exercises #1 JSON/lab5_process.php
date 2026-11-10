<?php
header('Content-Type: application/json');

// Read raw JSON POST input stream[cite: 13]
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

$name = !empty($data['name']) ? htmlspecialchars($data['name']) : "Rene";

// Output JSON response payload[cite: 13]
echo json_encode(array(
    "status" => "success",
    "message" => "Welcome, " . $name . "!"
));
?>