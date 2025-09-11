<?php
include 'db.php';
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? 0;

$response = ['status'=>'error','message'=>'Something went wrong'];

if($id){
   
    $res = $conn->query("SELECT image FROM projects WHERE id=$id");
    $row = $res->fetch_assoc();
    $img = $row['image'] ?? '';

 
    if($conn->query("DELETE FROM projects WHERE id=$id")){
      
        if($img && file_exists('project-img/'.$img)){
            unlink('project-img/'.$img);
        }
        $response = ['status'=>'success','message'=>'Project deleted'];
    }
}

echo json_encode($response);
?>
