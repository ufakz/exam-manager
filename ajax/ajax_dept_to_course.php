<?php
require '../db_credentials.php';
require '../utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}
$return_data = "<option selected>Choose Course</option>";

if(isset($_POST['dept'])){
    $dept = sanitizeInput($_POST['dept']);
    $query = "SELECT course_code,course_name from course where department = '$dept'";
    $result = $conn->query($query);

    if($result){
        while($row = $result->fetch_assoc()){
            $return_data = $return_data . "<option value=" . $row['course_code']. ">" . $row['course_code'] ." " . $row['course_name'] . "</option>";
        }

    }

}

echo $return_data;

?>