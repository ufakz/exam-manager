<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

$message = "";

if($conn->error){
    trigger_error($conn->error);
}

if(isset($_POST['submit'])){
  $name = sanitizeInput($_POST['official-name']);
  $gender = sanitizeInput($_POST['official-gender']);
  $dept = sanitizeInput($_POST['official-dept']);
  $email = sanitizeInput($_POST['official-email']);
  $phone = sanitizeInput($_POST['official-phone']);
  $course = sanitizeInput($_POST['course-taught']);

  $generated_id = generateId($dept);

		
		while(!confirmId($generated_id)){
			$generated_id = generateId($dept);
		}

  $query = "insert into exam_official values ('$generated_id','$name','$gender','$dept','$email','$phone','$course')";
  $result = $conn->query($query);

  if($result){
    $message = "<p class='lead text-success text-center'>Successfully added</p>";
  } else {
    $message = "<p class='lead text-success text-center'>There was an error adding official</p>";
  }
  
}
function generateId($admin_department){
  switch($admin_department){
    case "Computer Science": return "cs".rand(0,1000); break;
    case "Statistics": return "st".rand(0,1000); break;
    case "Mathematics": return "mt".rand(0,1000); break;
    case "Physics": return "py".rand(0,1000); break;
    case "Chemistry": return "ch".rand(0,1000); break;
    case "Geography": return "ge".rand(0,1000); break;
    case "Geology": return "gl".rand(0,1000); break;
  }
}

function confirmId($generated_id){
  global $conn;
  $query = "select official_id from exam_official where official_id='$generated_id'";

  $result = $conn->query($query);
  $row = $result->fetch_assoc();

  $current_id = $row['offcial_id'];

  return $generated_id == $current_id ? false : true;
}
?>
<?php echo $message?>
<div class="card container" style="margin-top: 2%">
      <div class="card-header text-center lead">
        Add a new Official
      </div>
      <div class="card-body">
      <form class="needs-validation" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" novalidate>
      <div class="form-group">
    <label for="official-name">Name</label>
    <input type="text" class="form-control" id="official-name" name="official-name" required>
    <div class="invalid-feedback">
           Please provide a name. 
      </div>

  </div>
  
  <div class="form-row">
  <div class="form-group col-md-4">
    <label for="official-gender">Gender</label>
    <select id="official-gender" class="form-control" name="official-gender" required>
        <option>Choose...</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>
      <div class="invalid-feedback">
           Please choose gender. 
      </div>
</div>
      <div class="form-group col-md-8">
    <label for="official-dept">Department</label>
    <select id="official-dept" class="form-control" name="official-dept" required>
        <option >Choose...</option>
        <option value="Mathematics">Mathematics</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Statistics">Statistics</option>
        <option value="Physics">Physics</option>
        <option value="Chemistry">Chemistry</option>
        <option value="Geography">Geography</option>
        <option value="Geology">Geology</option>
    </select>
    <div class="invalid-feedback">
           Please choose a department.  
      </div>
</div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="offcial-email">Email</label>
      <input type="email" class="form-control" id="official-email" placeholder="E.g example@example.com" name="official-email">
    </div>
    <div class="form-group col-md-6">
      <label for="offcial-phone">Phone</label>
      <input type="text" class="form-control" id="official-phone" name="official-phone" required>
      <div class="invalid-feedback">
           Please provide a phone number. 
      </div>
    </div>
  </div>
    <div class="form-group">
      <label for="course-taught">Course Taught</label>
      <select id="course-taught" class="form-control" name="course-taught">
        
        
      </select>
    </div>
  <input type="submit" class="btn btn-primary" value="Add Official" name="submit"></input>
</form>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#official-dept').on('change',function(){
      var requestData = {dept:$(this).val()};
      $.post('ajax/ajax_dept_to_course.php',requestData,function(data){
        $('#course-taught').html(data);
      })
    })
  })

</script>