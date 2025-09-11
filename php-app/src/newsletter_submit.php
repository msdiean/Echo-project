<?php
include "./admin/db.php";

if(isset($_POST['mail'])){
    $email = $conn->real_escape_string($_POST['mail']);

    $check = $conn->query("SELECT * FROM newsletter WHERE email='$email'");
    if($check->num_rows == 0){
        $conn->query("INSERT INTO newsletter (email) VALUES ('$email')");
        echo "Subscribed successfully!";
    } else {
        echo "You are already subscribed.";
    }
}
?>