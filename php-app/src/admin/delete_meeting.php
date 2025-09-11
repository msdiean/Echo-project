<?php
include 'db.php';
$id = $_GET['id'] ?? 0;
if($id){
    $stmt = $conn->prepare("DELETE FROM schedules WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        echo 'success';
    }
}
