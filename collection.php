<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);
if($conn->error){
    trigger_error($conn->error);
}
$options_query = "select distinct m.exam_id, c.material_id from collection c, exam_material m where c.material_id = m.material_id";
$result_options = $conn->query($options_query);

$query = "select c.quantity,c.date,o.name,o.department,m.material_id,m.material_type,m.exam_id from collection c, exam_official o, exam_material m where c.official_id = o.official_id and c.material_id = m.material_id";
$result = $conn->query($query);

?>
<div class="container" style="margin-top:2%">
    <a class="btn btn-success" href="new_collection.php" role="button">Add Record</a>
    <br>
    <br>
    <div class="row">
        Choose Examination:
        <select id="exam">
        <option selected>Choose...</option>
        <option value="all">All Exams</options>
        <?php while($oprow = $result_options->fetch_assoc()){
                $id = $oprow['material_id'];
                echo "<option value='$id'";
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
            <th scope="col">Examination Material</th>
            <th scope="col">Quantity Collected</th>
            <th scope="col">Collected By</th>
            <th scope="col">Date and Time Collected</th>
            </tr>
        </thead>
        <tbody id="list">
        <?php while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['exam_id'] . " " .  $row['material_type'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['name'] . " (" . $row['department'] . ")" . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "</tr>";
            }?>
        </tbody>
    </table>
    </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#exam').on('change',function(){
      var requestData = {material_id:$(this).val()};
      $.post('ajax/ajax_exams_in_collection.php',requestData,function(data){
        $('#list').html(data);
      })
    })
  })

</script>