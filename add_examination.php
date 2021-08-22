<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';
$message = "";

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

$courses_query = "select course_code,course_name from course order by department";
$result_courses = $conn->query($courses_query);

$invigils_query = "select official_id, name , department from exam_official order by department";
$result_invigils = $conn->query($invigils_query);

if(isset($_POST['submit'])){
  $course = sanitizeInput($_POST['course-code']);
  $date = sanitizeInput($_POST['exam-date']);
  $start_time = sanitizeInput($_POST['exam-start-time']);
  $end_time = sanitizeInput($_POST['exam-end-time']);
  $invigilator = sanitizeInput($_POST['invigilator']);
  $exam_id = "$course/$date";

  $query = "insert into examination values ('$exam_id','$course','$date','$start_time','$end_time','$invigilator')";

  $result = $conn->query($query);

  if($result){
    $message = "<p class='lead text-success text-center'>Successfully added</p>";
  } else {
    $message = "<p class='lead text-danger text-center'>There was an error scheduling the examination</p>";
  }
}
?>
<?php echo $message ?>
<div class="card container" style="margin-top: 2%">
      <div class="card-header text-center lead">
        Schedule an examination
      </div>
      <div class="card-body">
      <form class="needs-validation" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" novalidate>
      <div class="form-group">
    <label for="course-code">Course Code</label>
    <select id="course-code" name="course-code" class="form-control">
        <option selected>Choose...</option>
        <?php while($row = $result_courses->fetch_assoc()){
          echo "<option value=" . $row['course_code'] . ">" . $row['course_code'] . " " . $row['course_name'] . "</option>";
        }  ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exam-date">Date</label>
    <input type="date" class="form-control" id="exam-date" name="exam-date">
</div>
  
  <div class="form-row">
  <div class="form-group col-md-6">
    <label for="exam-start-time">Start time</label>
    <input type="time" class="form-control" id="exam-start-time" name="exam-start-time">
</div>
      <div class="form-group col-md-6">
    <label for="exam-end-time">End time</label>
    <input type="time" class="form-control" id="exam-end-time" name="exam-end-time">
</div>
  </div>
    <div class="form-group">
      <label for="invigilator">Invigilator</label>
      <select id="invigilator" class="form-control" name="invigilator">
      <option selected>Choose...</option>
      <?php while($row = $result_invigils->fetch_assoc()){
          echo "<option value=" . $row['official_id'] . ">" . $row['name'] . " " . "(" . $row['department'] . ")" . "</option>";
        }  ?>
        
      </select>
    </div>
    <input type="submit" class="btn btn-primary" value="Add Examination" name="submit"></input>
</form>
</div>
