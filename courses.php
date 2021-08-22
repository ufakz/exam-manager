<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);
if($conn->error){
    trigger_error($conn->error);
}

$query = "select * from course";
$result = $conn->query($query);


?>
<div class="container" style="margin-top:2%">
    <a class="btn btn-success" href="add_course.php" role="button">Add Course</a>
    <br>
    <br>
    <div class="row">
        View By: 
        <select id="view-filter">
            <option selected>Choose...</option>
            <option value="department">Department</option>
            <option value="level">Level</option>
        </select>
        <span id="dept-chooser" style="display:none">
        Choose Department:
        <select id="dept">
        <option >Choose...</option>
        <option value="all">All</option>
        <option value="Mathematics">Mathematics</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Statistics">Statistics</option>
        <option value="Physics">Physics</option>
        <option value="Chemistry">Chemistry</option>
        <option value="Geography">Geography</option>
        <option value="Geology">Geology</option>
        </select>
        </span>
        <span id="level-chooser" style="display:none">
        Choose level:
        <select id="level">
        <option selected>Choose...</option>
        <option value="all">All</option>
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="300">300</option>
        <option value="400">400</option>
        </select>
        </span>
    </div>
    <div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Course</th>
            <th scope="col">Department</th>
            <th scope="col">Level</th>
            </tr>
        </thead>
        <tbody id="list">
        <?php while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['course_code'] . " " . $row['course_name'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['level'] . "</td>";
                echo "</tr>";
            }?>
        </tbody>
    </table>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#view-filter').on('change',function(){
        if($(this).val() === "department"){
            $('#level-chooser').hide();
            $('#dept-chooser').show();
        } else if($(this).val() === "level"){
            $('#level-chooser').show();
            $('#dept-chooser').hide();
        }
    })
    
    $('#dept').on('change',function(){
      var requestData = {dept:$(this).val()};
      $.post('ajax/ajax_depts_in_courses.php',requestData,function(data){
        $('#list').html(data);
      })
    })

    $('#level').on('change',function(){
      var requestData = {level:$(this).val()};
      $.post('ajax/ajax_levels_in_courses.php',requestData,function(data){
        $('#list').html(data);
      })
    })

  })

</script>