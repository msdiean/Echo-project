<?php
session_start();
include 'db.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: contact.php");
exit;
