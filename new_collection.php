<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);

$message = "";

if($conn->error){
    trigger_error($conn->error);
}

$material_query = "SELECT material_id,material_type,exam_id from exam_material";
$result_material = $conn->query($material_query);

$official_query = "select official_id,name,department from exam_official";
$result_official = $conn->query($official_query);

if(isset($_POST['submit'])){
    $mat = sanitizeInput($_POST['material-collected']);
    $off = sanitizeInput($_POST['coll-off']);
    $quantity = sanitizeInput($_POST['quantity-coll']);
    $date = new DateTime(); 
    $timestamp =  $date->getTimestamp();


    $test_query = "select quantity from exam_material where material_id='$mat'";
    $result_test = $conn->query($test_query);

    $test_row = $result_test->fetch_assoc();
    echo $test_row['quantity'];
    
    if($test_row['quantity'] >= $quantity){
        $query = "insert into collection (quantity,official_id,material_id) values ('$quantity','$off','$mat')";
        $update_mat = "update exam_material set quantity = quantity - '$quantity' where material_id='$mat'";
        $res = $conn->query($query);
        $update_res = $conn->query($update_mat);
    
        if($res){
            $message = "<p class='lead text-success text-center'>Successfully added</p>";
        } else {
            $message = "<p class='lead text-danger text-center'>There was an error adding record</p>";
        }

    } else {
        $message = "<p class='lead text-danger text-center'>Insufficient materials for collection</p>";
    }

}


?>
<?php echo $message ?>
<div class="card container" style="margin-top: 2%">
  <div class="card-header text-center lead">
        New Collection Record
  </div>
 <div class="card-body">
  <form class="needs-validation" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" novalidate>
    <div class="form-group">
        <label for="material-collected">Material Collected</label>
        <select id="material-collected" class="form-control" name="material-collected">
            <option selected>Choose...</option>
            <?php while($rowmat = $result_material->fetch_assoc()){
                $id = $rowmat['material_id'];
                echo "<option value= '$id'";
                echo ">";
                echo $rowmat['exam_id'] . " (" . $rowmat['material_type'] . ") ";
                echo "</option>";
            }?>
        </select>
    </div>
      <div class="form-group">
      <label for="coll-off">Collecting Official</label>
      <select id="coll-off" class="form-control" name="coll-off">
        <option selected>Choose...</option>
        <?php while($rowoff = $result_official->fetch_assoc()){
                echo "<option value=";
                echo $rowoff['official_id'];
                echo ">";
                echo $rowoff['name'] . " (" . $rowoff['department'] . ") ";
                echo "</option>";
            }?>
      </select>
    </div>
    <div class="form-group">
    <label for="quantity-coll">Quantity</label>
    <input type="text" class="form-control" id="quantity-coll" name="quantity-coll">
    </div>  
  <input type="submit" class="btn btn-primary" value="Add Record" name="submit"></input>
</form>
</div>