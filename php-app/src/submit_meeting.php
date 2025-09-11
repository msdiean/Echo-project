<?php
include './admin/db.php';

$response = ['status'=>'error'];

$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$date = $_POST['date'] ?? '';
$message = $_POST['message'] ?? '';

if($name && $phone && $email && $date){
    $stmt = $conn->prepare("INSERT INTO schedules (name, phone, email, scheduled_date, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phone, $email, $date, $message);
    if($stmt->execute()){
        $response['status'] = 'success';
        $response['name'] = $name;
        $response['scheduled_date'] = $date;
    }
}

echo json_encode($response);