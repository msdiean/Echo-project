<?php
include 'db.php';
$response = ['status'=>'error','message'=>'Something went wrong'];

if(isset($_POST['serviceName']) && isset($_GET['id'])){
    $id = $_GET['id'];
    $serviceName = $_POST['serviceName'];
    $tagline = $_POST['serviceTagline'];

  
    if(isset($_FILES['serviceIcon']) && $_FILES['serviceIcon']['name']){
        $iconName = $_FILES['serviceIcon']['name'];
        $iconTmp = $_FILES['serviceIcon']['tmp_name'];
        move_uploaded_file($iconTmp, 'img/service/'.$iconName);
        $iconSQL = ", icon='$iconName'";
    } else $iconSQL = "";

  
    if(isset($_FILES['serviceImage']) && $_FILES['serviceImage']['name']){
        $imageName = $_FILES['serviceImage']['name'];
        $imageTmp = $_FILES['serviceImage']['tmp_name'];
        move_uploaded_file($imageTmp, 'images/'.$imageName);
        $imageSQL = ", service_image='$imageName'";
    } else $imageSQL = "";

    $sql = "UPDATE services SET service_name='$serviceName', tagline='$tagline' $iconSQL $imageSQL WHERE id='$id'";
    if($conn->query($sql)){
        $response = ['status'=>'success','message'=>'Service updated successfully!'];
    } else {
        $response = ['status'=>'error','message'=>'DB update failed!'];
    }
}

echo json_encode($response);
