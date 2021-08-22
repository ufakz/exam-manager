<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';
$message = "";

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

if($conn->error){
    trigger_error($conn->error);
}

if(isset($_POST['course-code'])){
  $ccode = sanitizeInput($_POST['course-code']);
  $cname = sanitizeInput($_POST['course-name']);
  $cdept = sanitizeInput($_POST['dept']);
  $ccu = sanitizeInput($_POST['course-cu']);
  $clevel = sanitizeInput($_POST['course-level']);

  $query = "INSERT INTO COURSE VALUES ('$ccode','$cname','$ccu','$cdept','$clevel')";

  $result = $conn->query($query);
  if($result){
    $message = "<p class='lead text-success text-center'>$ccode $cname was successfully added</p>";
  } else {
    $message = "<p class='lead text-danger text-center'>There was an error in adding $ccode</p>";
  }
}

?>
<?php echo $message ?>
<div class="card container" style="margin-top: 2%">
      <div class="card-header text-center lead">
        Add a new Course
      </div>
      <div class="card-body">
      <form class="needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="course-code">Course Code</label>
      <input type="text" class="form-control" id="course-code" name="course-code"placeholder="E.g COSC101" required>
      <div class="invalid-feedback">
           Please provide a valid course code.   
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="course-name">Course Name</label>
      <input type="text" class="form-control" id="course-name" name="course-name" required>
      <div class="invalid-feedback">
              Please provide a course name.
            </div>
    </div>
  </div>
  <div class="form-group">
    <label for="dept">Department</label>
    <select id="dept" name="dept" class="form-control">
        <option selected>Choose...</option>
        <option value="Mathematics">Mathematics</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Statistics">Statistics</option>
        <option value="Physics">Physics</option>
        <option value="Chemistry">Chemistry</option>
        <option value="Geography">Geography</option>
        <option value="Geology">Geology</option>
      </select>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="course-cu">Credit Unit</label>
      <input type="text" class="form-control" id="course-cu" name="course-cu" required>
      <div class="invalid-feedback">
              Please provide the course's credit unit.
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="course-level">Level</label>
      <select id="course-level" name="course-level" class="form-control" >
        <option selected>Choose...</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="300">300</option>
        <option value="400">400</option>
      </select>
    </div>
  <input type="submit" class="btn btn-primary" value="Add Course" name="submit"></input>
</form>
</div>