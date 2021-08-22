<?php
require '../db_credentials.php';
require '../utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

$return_data="";
if(isset($_POST['exam_id'])){
    $exam_id = sanitizeInput($_POST['exam_id']);

    if($exam_id == "all"){
        $query = "SELECT m.exam_id,m.material_type,m.quantity,e.course_code from exam_material m,examination e where m.exam_id = e.exam_id";

    } else {
        $query = "SELECT m.exam_id,m.material_type,m.quantity,e.course_code from exam_material m,examination e where m.exam_id = '$exam_id' and  m.exam_id = e.exam_id";
        
    }
    $res = $conn->query($query);

    while($row = $res->fetch_assoc()){
        $return_data .= "<tr>";
        $return_data .= "<td>" . $row['exam_id'] .  "</td>";
        $return_data .= "<td>" . $row['course_code'] . "</td>";
        $return_data .= "<td>" . $row['material_type'] . "</td>";
        $return_data .= "<td>" . $row['quantity'] . "</td>";
        $return_data .= "</tr>";
    }
}
echo $return_data;

?>