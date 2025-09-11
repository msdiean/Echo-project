<?php
include 'db.php';
$response = [];

$id = $_POST['id'] ?? '';
$serviceName = $_POST['serviceName'];
$tagline = $_POST['serviceTagline'];


$iconName = $_POST['existingIcon'] ?? '';
if(isset($_FILES['serviceIcon']) && $_FILES['serviceIcon']['error'] == 0){
    $iconName = time().'_'.$_FILES['serviceIcon']['name'];
    $targetIcon = 'img/service/'.$iconName;
    if(move_uploaded_file($_FILES['serviceIcon']['tmp_name'], $targetIcon)){
       
        if(!empty($_POST['existingIcon']) && file_exists('img/service/'.$_POST['existingIcon'])){
            unlink('img/service/'.$_POST['existingIcon']);
        }
    }
}



$imageName = $_POST['existingImage'] ?? '';
if(isset($_FILES['serviceImage']) && $_FILES['serviceImage']['error'] == 0){
    $imageName = time().'_'.$_FILES['serviceImage']['name'];
    $target = 'images/'.$imageName;
    if(move_uploaded_file($_FILES['serviceImage']['tmp_name'], $target)){
       
        if(!empty($_POST['existingImage']) && file_exists('images/'.$_POST['existingImage'])){
            unlink('images/'.$_POST['existingImage']);
        }
    }
}

if(!empty($id)){
   
    $fields = "service_name=?, tagline=?";
    $params = [$serviceName, $tagline];

    if($iconName != $_POST['existingIcon']) { $fields .= ", icon=?"; $params[] = $iconName; }
    if($imageName != $_POST['existingImage']) { $fields .= ", service_image=?"; $params[] = $imageName; }

    $params[] = $id;
    $types = str_repeat("s", count($params)-1)."i";
    $stmt = $conn->prepare("UPDATE services SET $fields WHERE id=?");
    if($stmt->bind_param($types, ...$params) && $stmt->execute()){
        $response['status'] = 'success';
        $response['message'] = 'Service updated successfully!';
        $response['data'] = [
            'id'=>$id,
            'service_name'=>$serviceName,
            'tagline'=>$tagline,
            'icon'=>$iconName,
            'service_image'=>$imageName
        ];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to update service.';
    }
} else {
    
    $stmt = $conn->prepare("INSERT INTO services (service_name, tagline, icon, service_image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $serviceName, $tagline, $iconName, $imageName);
    if($stmt->execute()){
        $response['status'] = 'success';
        $response['message'] = 'Service added successfully!';
        $response['data'] = [
            'id'=>$stmt->insert_id,
            'service_name'=>$serviceName,
            'tagline'=>$tagline,
            'icon'=>$iconName,
            'service_image'=>$imageName
        ];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to add service.';
    }
}

echo json_encode($response);
?>
