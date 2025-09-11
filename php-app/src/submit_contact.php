<?php
session_start();
include './admin/db.php';

$fname = $_POST['fname'] ?? '';
$lname = $_POST['lname'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if($fname && $lname && $phone && $email){
    $stmt = $conn->prepare("INSERT INTO contacts (fname, lname, phone, email, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $phone, $email, $message);
    $stmt->execute();
    $stmt->close();

    $_SESSION['contact_success'] = ['name' => $fname];
}

header("Location: index.php");
exit;
