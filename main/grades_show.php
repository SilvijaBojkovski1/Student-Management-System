<?php 
require_once 'conf.php'; 
require_once 'functions.php';

if(isset($_SESSION['username'])){
if(isset($_POST['grade-submit'])){
       $class = $_POST['classes'];
       $index = $_POST['student-info'];
       $points = $_POST['points'];
       $grade = $_POST['grade'];
       $date = $_POST['date'];
       
       $index_check = $data->query("SELECT * FROM users WHERE index_number = '$index'");
       $index_check->setFetchMode(PDO::FETCH_OBJ);
       $index_check = $index_check->fetch();
       if(empty($index_check)){
              echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;'>".
              "There is no student with index number ".$index." in database! Please check index number and try again!"."</span>";
       }else{
              if(!empty($date)){
                     $date = $_POST['date'];
              }else{
                     $dateArr = getdate();
                     $month = str_split($dateArr['month'],3);
                     $date = $dateArr['mday']." ".$month[0]." ".$dateArr['year'];
              }
              
       
              if(!empty($index) and !empty($points) and !empty($grade)){
                     $sql = "INSERT INTO `grades`(`grade_id`, `student`, `teacher`, `class`, `grade`, `points`, `date_added`) 
                            VALUES (null,'$index','$user_id','$class','$grade','$points','$date')";
                     $data->exec($sql);
                     echo "<span style='color:green; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;'>".
                     "Grade added successfully!"."</span>";
              }else{
                     echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;'>".
                     "Please fill all the input fields and try again!"."</span>";
              }
       }   
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
       <title>Grades</title>
       <?php require_once 'head.html';?> 
       

</head>
<body>
<?php sidebar();?>
<div class="main-content-container">
<div class="main-title" id="au-title" >
                     <p style="margin-top: 20px;">Grades</p>
              </div>
<div class="table-container">

<p style="margin-top: 20px;" class="sub-title">Add Grade</p>
<div class="add-grades-container">
                     <form action="" method="POST">
                            <label for="">Select class</label>
                            <br>
                            <select name="classes">
                                   <?php 
                                          $classes = $data->query("SELECT * FROM classes");
                                          $classes->setFetchMode(PDO::FETCH_OBJ);
                                          $classes=$classes->fetchAll();

                                          for($i=0;$i<count($classes);$i++){
                                                 echo "<option value='".$classes[$i]->class_id."'>".$classes[$i]->class_name."</option>";
                                          }
                                   ?>
                            </select>
                            <br>
                            <input type="text" name="student-info" placeholder="Index number">
                            <input type="text" name="points" style="width:50px" placeholder="Points">
                            <input type="text" name="grade" style="width:50px" placeholder="Grade">
                            <input type="text" name="date" style="width:50px" placeholder="Date">
                            <input type="submit" value="Submit grade" name="grade-submit">
                     </form>
              </div>
              <p style="margin-top: 20px;" class="sub-title">Grades list</p>
       <table>
              <tr style="background-color:#91BEE9;">
                     <th style="width:300px;">Name</th>
                     <th style="width:150px;">Index number</th>
                     <th style="width:300px;">Class</th>
                     <th style="width:fit-content;">Grade</th>
                     <th style="width:fit-content;">Points</th>
                     <th style="width:fit-content;">Date</th>
              </tr>

              <?php 
              
              if(!empty($grades)){
                     showGrades(); 
              }
                     

                            
                     
       ?>     
</div>

</body>
</html>


<?php
}else{
       relocate('login');
}
?>