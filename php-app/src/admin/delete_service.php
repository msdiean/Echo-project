<?php
include 'db.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);

 
    $service = $conn->query("SELECT icon, service_image FROM services WHERE id=$id")->fetch_assoc();
    if($service){
        $iconPath = "img/service/" . $service['icon'];
        $imagePath = "images/" . $service['service_image'];

     
        if(file_exists($iconPath)) unlink($iconPath);
        if(file_exists($imagePath)) unlink($imagePath);

       
        $delete = $conn->query("DELETE FROM services WHERE id=$id");
        if($delete){
            echo json_encode(['status'=>'success', 'message'=>'Service deleted successfully']);
        } else {
            echo json_encode(['status'=>'error', 'message'=>'Failed to delete service']);
        }
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Service not found']);
    }
} else {
    echo json_encode(['status'=>'error', 'message'=>'Invalid ID']);
}
?>
