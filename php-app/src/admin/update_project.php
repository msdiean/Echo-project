<?php
include 'db.php';

$id = $_POST['projectId'] ?? '';
$title = $_POST['projectTitle'];
$tagline = $_POST['projectTagline'];
$link = $_POST['projectLink'];
$existingImage = $_POST['existingImage'] ?? '';

$imageName = $existingImage;

if(isset($_FILES['projectImage']) && $_FILES['projectImage']['name'] != ''){
    $imageName = time().'_'.$_FILES['projectImage']['name'];
    $target = 'project-img/'.$imageName;
    if(move_uploaded_file($_FILES['projectImage']['tmp_name'], $target)){
    
        if($existingImage && file_exists('project-img/'.$existingImage)){
            unlink('project-img/'.$existingImage);
        }
    }
}

if($id){
    $stmt = $conn->prepare("UPDATE projects SET title=?, tagline=?, link=?, image=? WHERE id=?");
    $stmt->bind_param("ssssi", $title, $tagline, $link, $imageName, $id);
}else{
    $stmt = $conn->prepare("INSERT INTO projects(title, tagline, image, link) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $title, $tagline, $imageName, $link);
}

if($stmt->execute()){
    echo 'success';
}else{
    echo 'error';
}
?>
