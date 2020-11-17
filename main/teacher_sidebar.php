<?php 
      require_once 'conf.php';
      require_once 'functions.php';

if(isset($_SESSION['username'])){
?>


<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title></title>
       <link rel="stylesheet" href="../style/style.css">
       <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">  <!--light 300, regular 400, medium 500-->
</head>
<body> 

<div class="sidebar" id="sidebar" style="min-width: 300px;">
              <div class="sidebar-profile" style="cursor: pointer;" onclick="redirect()" >
                     <div class="sidebar-profile-pic">
                            <img src="../img/app/profile_picture.png" alt="">
                     </div>

                     <div class="sidebar-profile-info">
                            <p class="welcome">Welcome</p>
                            <p id="sidebar-name"><?php echo $first_name;?></p>
                     </div>
              </div>

              <div class="sidebar-activities">
                     <ul>
                            <li><img src="../img/app/dashboard.png" alt=""><a href="../main/dashboard.php">Dashboard</a></li>
                            <!--<li><img src="../img/app/classes.png" alt=""><a href="../main/classes.php">Classes</a></li>-->
                            <li><img src="../img/app/students_info.png" alt=""><a href="../main/users_information.php">Students information</a></li>
                            <li><img src="../img/app/add_event.png" alt=""><a href="../main/add_event.php">Add Event</a></li>
                            <li><img src="../img/app/grades.png" alt=""><a href="../main/grades_show.php">Add Grades</a></li>
                            <!--<li><img src="../img/app/messages.png" alt=""><a href="../main/messages.php">Messages</a></li>-->
                            <li><img src="../img/app/notes.png" alt=""><a href="../main/notes.php">Notes</a></li>
                     </ul>
              </div>

              <div class="sidebar-options">
                     <ul>
                            <li ><img src="../img/app/log_off.png" alt="" style="cursor:pointer;" id="logout-bttn" onclick="logoutFunction()" title="log out"></li>
                     </ul>
              </div>
       </div>
       
       <div class="logout-popup" id="logout-popup">
              <p>Are you sure you want to logout?</p>
              <form action="" method="POST">
                     <button name="yes-bttn">Yes</button>
                     <button name="no-bttn">No</button>
              </form>
       </div>
<script>
       function redirect(){
              window.location.href = "../main/profile.php";
       }
       var logout = document.getElementById("logout-popup");
              var div = document.createElement('div');
        function logoutFunction() {
              
              div.id = 'logout-bg';
              document.body.appendChild(div);
              div.style.position = "absolute";
              div.style.width = "100vw";
              div.style.height = "100vh";
              div.style.background = "rgba(217,217,217,0.7)";
              div.style.backgroundSize = "cover";
              div.style.zIndex = "1";
              logout.style.display = "initial";
              logout.style.position = "fixed";
              logout.style.zIndex = "2";
       }

</script>

<?php 
if(isset($_POST['yes-bttn']) or isset($_POST['no-bttn'])){
       if(isset($_POST['yes-bttn'])){
              session_destroy();
              ?>
                     <script>
                           window.location.assign("../main/index.php");
                     </script>
              <?php
       }else{
              ?>
                     <script>
                            logout.style.display = "none";
                            div.style.display = "none";
                     </script>
              <?php
       }
}

?>
</script>
</body>
</html>

<?php
}else{
       relocate('login');
}
?>