<?php
include 'db.php';


header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=contacts.csv");
header("Pragma: no-cache");
header("Expires: 0");


$output = fopen('php://output', 'w');


fputcsv($output, ['First Name', 'Last Name', 'Mobile', 'E-Mail', 'Message']);


$result = $conn->query("SELECT fname, lname, phone, email, message FROM contacts");
while($row = $result->fetch_assoc()){
    fputcsv($output, [$row['fname'], $row['lname'], $row['phone'], $row['email'], $row['message']]);
}

fclose($output);
exit;
