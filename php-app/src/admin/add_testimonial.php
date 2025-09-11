<?php
include 'db.php';
$response = ['status'=>'error','message'=>'Something went wrong'];

$id = $_POST['id'] ?? '';
$name = $_POST['name'];
$testimonial = $_POST['testimonial'];
$rating = $_POST['rating'];

if($id){
    $stmt = $conn->prepare("UPDATE testimonials SET name=?, testimonial=?, rating=? WHERE id=?");
    $stmt->bind_param("ssii", $name, $testimonial, $rating, $id);
    if($stmt->execute()) $response = ['status'=>'success','message'=>'Updated successfully'];
}else{
    $stmt = $conn->prepare("INSERT INTO testimonials(name,testimonial,rating) VALUES(?,?,?)");
    $stmt->bind_param("ssi",$name,$testimonial,$rating);
    if($stmt->execute()) $response = ['status'=>'success','message'=>'Added successfully'];
}

echo json_encode($response);
