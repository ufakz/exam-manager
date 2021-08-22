<?php
require 'db_credentials.php';
$password = "?admin@ems#";
$hashed = password_hash($password,PASSWORD_DEFAULT);

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);
$query = "insert into exam_officer values ('admin','$hashed')";

$result = $conn->query($query);

if($conn->error){
    trigger_error($conn->error);
} else {
    echo "Successfully created admin";
}


?>