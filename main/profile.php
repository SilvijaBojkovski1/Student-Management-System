<?php 
             require_once 'conf.php';
             require_once 'functions.php';


if(isset($_SESSION['username'])){
       if(isset($_POST['submit-pass-change'])){
              global $user_id;
              global $data;
              $newPass = $_POST['pass-change'];
                     try{
                            $sql = "UPDATE users SET userPassword = '$newPass' WHERE userID = '$user_id'";
                            $data->exec($sql);
                            echo "<span style='color:green; background-color: rgba(255,255,255,0.8);padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."You successfully updated your password!"."</span>";    
                     }catch(PDOException $e){
                            echo "<span style='color:red; background-color: rgba(255,255,255,0.8);padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."Password update fail! Please try again!"."</span>";    
                     }
       }
?>


<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="../style/style.css">
       <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700&display=swap" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">  <!--light 300, regular 400, medium 500-->
       <title>Profile</title>
</head>
<body>

       <?php           
      sidebar();
       ?>

       <main>
              <div class="profile-info-container">
                     <img src="../img/app/girl_placeholder.png" alt="">
                     <div class="profile-info-text">
                            <p class="profile-info-name"><?php echo $first_name." ".$last_name;?></p>
                            <?php 
                                   if($user_role == 4){ echo " <p class='profile-info-extra'>Course: ".$course_name."</p>";}
                            ?>
                           
                     </div>
                     
              </div>
       <div class="profile-info-table">
              <table>
                     <tr>
                            <th>First Name & Last Name</th>
                            <td><?php echo $first_name." ".$last_name;?></td>
                     </tr>
                     
                            <?php 
                            if ($user_role == 4){
                                 echo "<tr>
                                          <th>Index number</th>
                                          <td>".$index_num."</td> </tr>"  ;
                            }
                            ?>
                     <tr>
                            <th>Date of birth</th>
                            <td><?php echo $date_of_birth;?></td>
                     </tr>
                     <tr>
                            <th>City of birth</th>
                            <td><?php echo $city_of_birth;?></td>
                     </tr>
                     <tr>
                            <th>Personal id</th>
                            <td><?php echo $personal_id;?></td>
                     </tr>
                     <tr id="email">
                            <th>E-mail</th>
                            <td id="clone-email"><?php echo $mail;?></td>
                     </tr>
                     <tr>
                            <th>Contact number</th>
                            <td id="clone"><?php echo $contact_number;?></td>
                     </tr>
              </table>
       </div>


       <div class="change-login-table" >
              <p id="login-change" style="cursor:pointer;" onclick="displayF()">Change username and password</p>
              <div class="login-change">
                     <table id="table" class="hide">
                            <tr>
                                   <form action="" method="POST">
                                          <th>New password</th>
                                          <td><input type="text" name="pass-change"></td>
                                          <td><input type="submit" name="submit-pass-change"></td>
                                   </form>
                                   
                            </tr>
                            
                     </table>
                     
                     <div id="table-login" >
                            <form action="profile.php" method="post" class="hide" id="table-login-form">
                            <label for="">Password</label>
                            <input type="password" name="pass" id="password">
                            <input type="submit" value="Submit" class="table-login-bttn" name="submit-pass">
                            </form>
                            
                     </div>
              </div>
              
              
       </div>

</main>





<!--js funcion that displays login field on click-->
<script>
        function displayF() {
              var login = document.getElementById("table-login-form");
              login.style.display = "table";
       }
</script>





<!--php+js function that allows changing username and password when we type correct password-->
<?php 
       if(isset($_POST['submit-pass'])){
              if($_POST['pass'] == $userPassword){                    
?>
                     <script>
                            function displayF() {
                                   var table = document.getElementById("table");
                                   var login = document.getElementById("table-login");
                     
                                          table.style.display = "table";
                                          login.style.display = "none";
                            }
                            displayF();
                     </script>
<?php
              }else{
?>
                     <script>
                            function displayF() {
                                   var again = document.getElementById("password");
                                   again.value='';
                            }
                            displayF();
                     </script>
<?php
                     }
       }     
?>
<!--here ends php+js function----------------------------------------------------------------------->



</body>
</html>

<?php
}else{
       relocate('login');
}
?>