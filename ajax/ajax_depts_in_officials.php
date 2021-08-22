<?php
require '../db_credentials.php';
require '../utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

$return_data="";
if(isset($_POST['dept'])){
    $dept = sanitizeInput($_POST['dept']);
    if($dept == "all"){
        $query = "select e.name,e.department,c.course_code,c.course_name from exam_official e, course c where e.course_code = c.course_code";
    } else{
        $query = "select e.name,e.department,c.course_code,c.course_name from exam_official e, course c where e.department = '$dept' and e.course_code = c.course_code";

    }
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
        $return_data .= "<tr>";
        $return_data .= "<td>" . $row['name'] . "</td>";
        $return_data .= "<td>" . $row['department'] . "</td>";
        $return_data .= "<td>" . $row['course_code'] . " " . $row['course_name'] . "</td>";
        $return_data .= "</tr>";
    }
}
echo $return_data;
?>