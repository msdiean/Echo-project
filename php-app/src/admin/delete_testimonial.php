<?php
include 'db.php';
$data = json_decode(file_get_contents("php://input"), true);
$response = ['status'=>'error','message'=>'Something went wrong'];

if(isset($data['id'])){
    $stmt = $conn->prepare("DELETE FROM testimonials WHERE id=?");
    $stmt->bind_param("i", $data['id']);
    if($stmt->execute()) $response = ['status'=>'success','message'=>'Deleted successfully'];
}

echo json_encode($response);
