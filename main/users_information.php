<?php 
       require_once 'conf.php';
       require_once 'functions.php';


if(isset($_SESSION['username'])){
       if(isset($_POST['deleteBttn']) && isset($_POST['del-req'])){
              $req = $_POST['del-req'];
              $del = $data->query("SELECT * FROM users WHERE userID='$req'");
              $del->setFetchMode(PDO::FETCH_OBJ);
              $del = $del->fetchAll();
              if(empty($del)){
                     echo "<span style='color:green; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                     '>"."Record with that ID does not exists! Check input and try again!"."</span>";
              }else{
                     $request = $data->exec("DELETE FROM `users` WHERE userID='$req'");
                     echo "<span style='color:green; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                     '>"."Record deleted successfully!"."</span>";
              }
       }
?>

<!DOCTYPE html>
<html lang="en">
<head>
       <title>Users</title>
       <link rel="stylesheet" href="../style/jquery-ui.css">
      <?php require_once 'head.html';?>
      
      <link rel="stylesheet" href="../style/admin.css">

</head>
<body style="background-image: unset;">
       
     <?php sidebar();?>
<div class="ee-container">
              <div class="main-title" id="ee-title">
                     <?php if($user_role == 2){echo "<p>Users</p>";
                     }elseif($user_role == 3){echo "<p>Students</p>";}
                     ?>
                     
              </div>
       
<div class="content-container">
<div class="events-f" style="margin-left:30px;" id="events-f">
                     <div class="events-f-sort" ">
                            <form action="" method="POST">
                                   <label for=""> Sort by</label>
                                   <select name="sort" id="">
                                          <?php if($user_role == 2){echo " <option value='role'>Role</option>";}?>
                                          <?php if($user_role == 2){echo " <option value='id'>ID</option>";}?>
                                          <option value="name">Name</option>
                                          <?php if($user_role == 3){echo " <option value='index'>Index number</option>";}?>
                                          <?php if($user_role == 3){echo " <option value='course'>Course</option>";}?>
                                   </select>
                                   <input type="submit" name="go-sort" value="Sort">
                            </form>
                           
                     </div>
              
                     <div class="events-f-show">
                            <form action="" method="POST">
                                   <label for="">Search</label>
                                   <?php if($user_role == 2){
                                     ?>     
                                          <select name="search">
                                                 <?php if($user_role == 2){echo " <option value='role'>Role</option>";}?>
                                                 <?php if($user_role == 3){echo " <option value='index'>Index number</option>";}?>
                                                 <?php if($user_role == 2){echo " <option value='id'>ID</option>";}?>
                                                 <?php if($user_role == 2){echo " <option value='persid'>Personal ID</option>";}?>
                                          </select>
                                          <input type="text" name="user-search-req" placeholder="Request">
                                   <?php
                                   }elseif($user_role == 3){echo "<input type='text' name='user-search-req' placeholder='Index Number'>";}
                                   ?>
                                   
                                   
                                   <input type="submit" value="Search" name="user-search">
                            </form>
                     </div>
                     <?php if($user_role == 2){
                     ?>
                     <div class="events-f-delete">
                            <form action="" method="POST">
                                   <label for="">Delete</label>
                                   <input type="text" name="del-req" placeholder="User ID">
                                   <input type="submit" value="Delete" name="deleteBttn">
                            </form>
                     </div>
              </div>

              <div class="make-note-bttn admin-add-event flex-add" id="button-div">
                     <button id="add" onclick="showAdds()">Add User<img src="../img/app/plus.png" alt="" style="display:block;"></button>
                     <button id="add-stud" onclick="redirectToAddStud()" style="font-size: 14px; height: 23px;" class="hide">Student</button>
                     <button id="add-else" onclick="redirectToAddElse()" style="font-size: 14px; height: 23px;" class="hide">Teacher or Admin </button>
              </div>
                     <?php
                     }
                     ?>
       </div>

       <div class="ee-table-container" id="table">
       <table id="events_id">
              <tr style="background-color:#91BEE9;">
                     <?php if($user_role == 2){echo "<th>User ID</th>  ";} ?>
                     <?php if($user_role == 2){echo "<th>Role</th> ";} ?>
                     <?php if($user_role == 2){echo "<th style='width:400px;max-width:300px'>First Name/Last Name</th>";
                            }else{echo "<th style='width:300px;max-width:300px'>First Name/Last Name</th>";}
                      ?>    
                    <?php if($user_role == 2){echo "<th style='width:300px;'>Personal Id</th>";} ?>
                    <?php if($user_role == 2){echo "<th style='width:200px'>Date added</th>";} ?>
                    <?php if($user_role == 3){echo "<th style='width:fit-content;'>Index Number</th>";} ?>
                    <?php if($user_role == 3){echo "<th style='width:200px; max-width:200px;'>Course</th>";} ?>
                    <?php if($user_role == 3){echo "<th style='width:300px;'>Mail</th>";} ?>
              </tr>

            <?php 
            if($user_role == 2){
                     if(isset($_POST['go-sort'])){   
                            $sort_by=$_POST['sort'];
                            showUsers($sort_by);  
                     }elseif(isset($_POST['user-search'])){
                            $req = isset($_POST['user-search-req']) ? $_POST['user-search-req'] : "";
                            //print_r($req);
                            $by = $_POST['search'];
                            searchUsersBy($by,$req);
                     }else{
                            showUsers();  
              }
            }elseif($user_role == 3){
                     if(isset($_POST['go-sort'])){   
                            $sort_by=$_POST['sort'];
                            showUsersForTeacher($sort_by);  
                     }elseif(isset($_POST['user-search'])){
                            $req = $_POST['user-search-req'];
                            searchUsersForTeachers($req);
                     }else{
                            showUsersForTeacher();  
       }
            }
                     
              ?> 
       </table>
       </div>
</div>             

       
       
<?php 



?>

<script>

       function showAdds(){
              $( "#add-stud" ).toggle();
              $( "#add-else" ).toggle();

       }
       function redirectToAddStud(){
              window.location.href = "../main/add_student.php";
       }

       function redirectToAddElse(){
              window.location.href = "../main/add_teacher_and_admin.php";
       }

</script>
</body>
</html>

<?php
}else{
       relocate('login');
}
?>