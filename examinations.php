<?php
require_once 'utils/header.php';
require 'db_credentials.php';
require 'utils/functions.php';

$conn = new mysqli($db_host,$db_username,$db_password,$db_name);
if($conn->error){
    trigger_error($conn->error);
}

$query = "select e.course_code, e.date, e.start_time, e.end_time, o.name from examination e, exam_official o where e.official_id = o.official_id";
$result = $conn->query($query);
?>
<div class="container" style="margin-top:2%">
    <a class="btn btn-success" href="add_examination.php" role="button">New Examination</a>
    <br>
    <br>
    <div class="row">
        View By: 
        <select id="view-filter">
            <option value="completion" selected>Completion</option>
        </select>
        <span id="completion-chooser">
        Choose completion:
        <select id="completion">
        <option selected>Choose...</option>
        <option value="all">All</option>
        <option value="completed">Completed</option>
        <option value="pending">Pending</option>
        </select>
        </span>
    </div>
    <div>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Course Code</th>
            <th scope="col">Date</th>
            <th scope="col">Start Time</th>
            <th scope="col">End Time</th>
            <th scope="col">Invigilator</th>
            </tr>
        </thead>
        <tbody id="list">
        <?php while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $row['course_code'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['start_time'] . "</td>";
                echo "<td>" . $row['end_time'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "</tr>";
            }?>
        </tbody>
        </table>
        </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    $('#completion').on('change',function(){
      var requestData = {completion:$(this).val()};
      $.post('ajax/ajax_completion_in_exams.php',requestData,function(data){
        $('#list').html(data);
      })
    })

  })
</script>