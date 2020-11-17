<?php 
       require_once 'conf.php';
       require_once 'functions.php';

if(isset($_SESSION['username'])){
       $courses = $data->query("SELECT * FROM course");
       $courses->setFetchMode(PDO::FETCH_OBJ);
       $courses = $courses->fetchAll();


       if(isset($_POST['submit-add-user'])){
              $fn = isset($_POST['fn']) ? $_POST['fn'] : "";
              $ln = isset($_POST['ln']) ? $_POST['ln'] : "";
              $per_id = isset($_POST['per-id']) ? $_POST['per-id'] : "";
              $dob = $_POST['dob'];
              $cob = $_POST['cob'];
              $adress = $_POST['adress'];
              $number = $_POST['number'];
              $mail = $_POST['mail'];
              $course = isset($_POST['course']) ? $_POST['course'] : "/";
              $index = isset($_POST['index']) ? $_POST['index'] : null;
              $status = isset($_POST['status']) ? $_POST['status'] : "/";
              $un = $index;
              $pass = $index;
              $role_name = $_POST['role'];
              $dateArr = getdate();
              $month = str_split($dateArr['month'],3);
              $date = $dateArr['mday']." ".$month[0]." ".$dateArr['year'];

              if ($role_name == 'admin' or $role_name == 'Admin' or $role_name == 2){
                     $role = 2;
              }elseif($role_name == 'teacher' or $role_name == 'Teacher' or $role_name == 3){
                     $role = 3;
              }elseif($role_name == 'student' or $role_name == 'Student' or $role_name == 4){
                     $role = 4;
              }

              try{
                     $sql = "INSERT INTO `users`(`userID`, `first_name`, `last_name`, `personal_id`, 
                     `status`, `adress`, `city_of_birth`, `contact_number`, `mail`, `date_of_birth`, 
                     `username`, `userPassword`,`index_number`, `course`, `user_role`,`date_added`) 
                    VALUES (null,'$fn','$ln','$per_id',
                    '1','$adress','$cob','$number','$mail','$dob',
                    '$un','$pass','$index','$course','$role','$date')";
                    $data->exec($sql);
                  
                    echo "<span style='color:green; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                     '>"."Adding new user is successfull!"."</span>";
              }catch(PDOException $e){
                     echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                     '>"."Error has occured while adding new user. Check if all boxes are filed and try again!"."</span>".$e;
              }

              
       }
?>

<!DOCTYPE html>
<html lang="en">
<head>  
       <title>User</title>
       <link rel="stylesheet" href="../style/jquery-ui.css">
      <?php require_once 'head.html';?>  
      <link rel="stylesheet" href="../style/admin.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
       
</head>
<body>

<?php sidebar();?>
<div id="add-user" class="hide">
              <div class="main-title" id="au-title" >
                     <p style="margin-top: 20px;">Add User</p>
              </div>
       <div class="add-user-container" style="margin-left:25px;">
              <form action="" method="POST">
                     <div class="form-content-container">
                            <div class="add-form-container-1">
                                   <fieldset class="add-user-fieldset flex-fieldset">
                                          <legend>Personal</legend>
                                          <label>First name</label>
                                          <input type="text" name="fn">
                                          <label >Last Name</label>
                                          <input type="text" name="ln">
                                          <label >Role</label>
                                          <select name="role" id="" onchange="getval(this);">
                                                 <option value="student"><button onclick="showStudentPart()">Student</button></option>
                                                 <option value="teacher">Teacher</option>
                                                 <option value="admin">Admin</option>
                                          </select>
                                         
                                          <label >Personal ID</label>
                                          <input type="text" name="per-id">
                                          <label >Date of Birth</label>
                                          <input type="text" name="dob">
                                          <label >City of Birth</label>
                                          <input type="text" name="cob">
                                          <label >Adress</label>
                                          <input type="text" name="adress">
                                   </fieldset>
                                   
                            </div>
                            
                            <div class="add-form-container-2">
                                   
                                   <fieldset class="add-user-fieldset fieldset-width" id="stud">
                                          <legend>Study</legend>
                                          <label >Course</label>
                                          <select name="course">
                                                 <?php 
                                                        for($i=0;$i<count($courses);$i++){
                                                               echo "<option value='".$courses[$i]->course_id."'>".$courses[$i]->courseName."</option>";
                                                        }
                                                 ?>
                                          </select>
                                          <label >Index Number</label>
                                          <input type="text" name="index">
                                          <label >Status</label>
                                          <input type="text" name="status">
                                   </fieldset>

                                   <fieldset class="add-user-fieldset fieldset-width flex-fieldset" >
                                          <legend>Contact</legend>
                                          <label >Contact Number</label>
                                          <input type="text" name="number">
                                          <label >E-mail</label>
                                          <input type="text" name="mail">
                                   </fieldset>
                                   
                                   
                            </div>
                            
                     </div>
                      
                     <div class="add-user-bttns">
                            <input type="submit" value="<-List Users" class="add-user-bttn" style="margin-left:5px;">
                            <input type="submit" name="submit-add-user" value="Submit" class="add-user-bttn" style="margin-right:5px;">      
                     </div>
                     
              </form>     

       </div>
       </div>

</body>
</html>

<?php
}else{
       relocate('login');
}
?>