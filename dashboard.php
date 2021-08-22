<?php
require_once 'utils/header.php';
require_once 'db_credentials.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

$options_query = "SELECT distinct exam_id from exam_material";
$result_options = $conn->query($options_query);

$query = "select m.exam_id,m.material_type,m.quantity,e.course_code from exam_material m,examination e where m.exam_id = e.exam_id";
$result = $conn->query($query);

?>
<div class="container-fluid" style="margin-top:2%">
    <div class="row">
        <div class="col-md-3 ">
            <ul class="list-group ">
                <a href="add_course.php" class="bg-primary"><li class="list-group-item lead text-center bg-success text-white">Add a Course</li></a>
                <a href="add_official.php" class="bg-primary"><li class="list-group-item lead text-center bg-success text-white">Add an Official</li></a>
                <a href="add_examination.php" class="bg-primary"><li class="list-group-item lead text-center bg-success text-white">Schedule an examination</li></a>
                <a href="add_material.php" class="bg-primary"><li class="list-group-item lead text-center bg-success text-white">Register exam materials</li></a>
                <a href="new_collection.php" class="bg-primary"><li class="list-group-item lead text-center bg-success text-white">Record collection of materials</li></a>
                <a href="new_return.php" class="bg-primary"><li class="list-group-item lead text-center bg-success text-white">Record return of materials</li></a>
            </ul>
        </div>    
        <div class="col-md-9">
        <h1 class="lead">Inventory </h1>
        
        Choose Course:
        <select id="exam">
        <option selected>Choose...</option>
        <option value="all">All Exams</options>
        <?php while($oprow = $result_options->fetch_assoc()){
                echo "<option value=";
                echo $oprow['exam_id'];
                echo ">";
                echo $oprow['exam_id'];
                echo "</option>";
            }?>
        </select>
    
    <div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Examination</th>
            <th scope="col">Course</th>
            <th scope="col">Material Type</th>
            <th scope="col">Quantity</th>
            </tr>
        </thead>
        <tbody id="list">
        <?php while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['exam_id'] .  "</td>";
                echo "<td>" . $row['course_code'] . "</td>";
                echo "<td>" . $row['material_type'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "</tr>";
            }?>
        </tbody>
    </table>
    </div>
        </div>
    </div>
</div>