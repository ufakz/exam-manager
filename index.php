<?php
require_once 'utils/header_wrapper.php';
require 'db_credentials.php';
require 'utils/functions.php';
$incorrect_display = "";

if(isset($_POST['admin_username']) && isset($_POST['admin_password'])){
  $id = sanitizeInput($_POST['admin_username']);
  $password = sanitizeInput($_POST['admin_password']);

  $conn = new mysqli($db_host,$db_username,$db_password,$db_name);

  if($conn->error){
    trigger_error($conn->error);
  }

  $query = "select username,password from exam_officer where username='$id'";
  $result = $conn->query($query);

  $row = $result->fetch_assoc();

  $fetched_id = $row['username'];
  $fetched_password = $row['password'];

  if($fetched_id == $id && password_verify($password,$fetched_password)){
    header('Location: dashboard.php');
  }else{
    $incorrect_display = "<p class='lead text-danger'>Incorrect Username/Password</p>";
  }
}
  

?>
<main class="container">
    <div class="card" style="margin-top: 5%">
      <div class="card-header text-center lead">
        Log In
      </div>
      <div class="card-body">
        <form class="needs-validation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>
          <div class="form-group">
            <label for="admin_username">Admin Username</label>
            <input type="text" class="form-control" id="admin_username" name="admin_username" aria-describedby="emailHelp"
              placeholder="Username" required>
            <div class="invalid-feedback">
              Please provide a valid username.
            </div>
            <small id="emailHelp" class="form-text text-muted">Only the examination officer can log in.</small>
          </div>
          <div class="form-group">
            <label for="admin_password">Admin Password</label>
            <input type="password" class="form-control" id="admin_password" name="admin_password" placeholder="Password" required>
            <div class="invalid-feedback">
              Please provide a valid password.
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success ">Submit</button>
            <?php echo $incorrect_display ?>
          </div>
        </form>
      </div>
    </div>
</main>
<?php require_once 'utils/footer.php'?>