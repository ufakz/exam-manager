<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';
$message = "";

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

$query_exam = "select exam_id,course_code from examination";
$result_exam = $conn->query($query_exam);

if(isset($_POST['submit'])){
  $exam_id = sanitizeInput($_POST['exam']);
  $type = sanitizeInput($_POST['material-type']);
  $quantity = sanitizeInput($_POST['material-quantity']);
  $material_id = "$exam_id-$type";

  $query = "insert into exam_material values ('$material_id','$type','$quantity','$exam_id')";
  $result = $conn->query($query);

  if($result){
    $message = "<p class='lead text-success text-center'>Successfully added</p>";
  } else {
    $message = "<p class='lead text-danger text-center'>There was an error adding the material</p>";
  }
}


?>
<?php echo $message ?>
<div class="card container" style="margin-top: 2%">
  <div class="card-header text-center lead">
        Add Materials for an Examination
  </div>
 <div class="card-body">
  <form class="needs-validation" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" novalidate>
      <div class="form-group">
      <label for="exam">Examination</label>
      <select id="exam" class="form-control" name="exam">
        <option selected>Choose...</option>
        <?php while($row = $result_exam->fetch_assoc()){
          echo "<option value=" . $row['exam_id'] . ">" . $row['course_code'] . "</option>";
        }?>
      </select>
    </div>
  <div class="form-group">
    <label for="material-type">Type of Material</label>
    <select id="material-type" class="form-control" name="material-type">
        <option selected>Choose...</option>
        <option value="Question Paper">Question Paper</option>
        <option value="Answer Script">Answer Script</option>
        <option value ="Attendance Slip">Attendance Slip</option>
      </select>
</div>
      <div class="form-group">
    <label for="material-quantity">Quantity</label>
    <input type="text" class="form-control" id="material-quantity" name="material-quantity">
</div>
  <input type="submit" class="btn btn-primary" value="Add Material" name="submit"></input>
</form>
</div>