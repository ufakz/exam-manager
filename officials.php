<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);
if($conn->error){
    trigger_error($conn->error);
}

$display_query = "select e.name,e.department,c.course_code,c.course_name from exam_official e, course c where e.course_code = c.course_code";
$display_result = $conn->query($display_query);

?>
<div class="container" style="margin-top:2%">
    <a class="btn btn-success" href="add_official.php" role="button">Add Official</a>
    <br>
    <br>
    <div class="row">
        View By: 
        <select>
            <option value="department">Department</option>
        </select>
        Choose Department:
        <select id="dept">
            <option selected>Choose...</option>
            <option value="all">All</option>
            <option value="Mathematics">Mathematics</option>
            <option value="Computer Science">Computer Science</option>
            <option value="Statistics">Statistics</option>
            <option value="Physics">Physics</option>
            <option value="Chemistry">Chemistry</option>
            <option value="Geography">Geography</option>
            <option value="Geology">Geology</option>
      </select>
    </div>
    <div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Name</th>
            <th scope="col">Department</th>
            <th scope="col">Course Taught</th>
            </tr>
        </thead>
        <tbody id="list">
            <?php while($row = $display_result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['course_code'] . " " . $row['course_name'] . "</td>";
                echo "</tr>";
            }?>
        </tbody>
        </table>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#dept').on('change',function(){
      var requestData = {dept:$(this).val()};
      $.post('ajax/ajax_depts_in_officials.php',requestData,function(data){
        $('#list').html(data);
      })
    })
  })

</script>