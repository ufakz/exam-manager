<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);
if($conn->error){
    trigger_error($conn->error);
}

$options_query = "SELECT distinct exam_id from exam_material";
$result_options = $conn->query($options_query);

$query = "select m.exam_id,m.material_type,m.quantity,e.course_code from exam_material m,examination e where m.exam_id = e.exam_id";
$result = $conn->query($query);

?>
<div class="container" style="margin-top:2%">
    <a class="btn btn-success" href="add_material.php" role="button">Add Examination Material</a>
    <br>
    <br>
    <div class="row">
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
    </div>
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
<script type="text/javascript">
  $(document).ready(function(){
    $('#exam').on('change',function(){
      var requestData = {exam_id:$(this).val()};
      $.post('ajax/ajax_exams_in_materials.php',requestData,function(data){
        $('#list').html(data);
      })
    })
  })

</script>