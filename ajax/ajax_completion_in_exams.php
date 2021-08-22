<?php
require '../db_credentials.php';
require '../utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

$return_data="";
if(isset($_POST['completion'])){
    $comp = sanitizeInput($_POST['completion']);
    $today = new DateTime();
    $today_date = $today->format('Y-m-d');
    if($comp == "completed"){
        $query = "select e.course_code, e.date, e.start_time, e.end_time, o.name from examination e, exam_official o where e.official_id = o.official_id and e.date < '$today_date'  ";
    } else if($comp == "pending"){
        $query = "select e.course_code, e.date, e.start_time, e.end_time, o.name from examination e, exam_official o where e.official_id = o.official_id and e.date >= '$today_date' ";
    } else if($comp == "all"){
        $query = "select e.course_code, e.date, e.start_time, e.end_time, o.name from examination e, exam_official o where e.official_id = o.official_id";
    }

    $result = $conn->query($query);
    while($row = $result->fetch_assoc()){
        $return_data .= "<tr>";
        $return_data .= "<td>" . $row['course_code'] . "</td>";
        $return_data .= "<td>" . $row['date'] . "</td>";
        $return_data .= "<td>" . $row['start_time'] . "</td>";
        $return_data .= "<td>" . $row['end_time'] . "</td>";
        $return_data .= "<td>" . $row['name'] . "</td>";
        $return_data .= "</tr>";
    }
}
echo $return_data;



?>