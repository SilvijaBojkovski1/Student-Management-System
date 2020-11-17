<?php 
require_once 'conf.php';
require_once 'functions.php';


if(isset($_SESSION['username'])){
?>


<!DOCTYPE html>
<html lang="en">
<head>
       <?php include 'head.html';?>
</head>

<body > 

<div class="sidebar" id="sidebar" style="min-width: 300px;">
              <div class="sidebar-profile" style="cursor: pointer;" onclick="redirect()" >
                     <div class="sidebar-profile-pic">
                            <img src="../img/app/profile_picture.png" alt="">
                     </div>

                     <div class="sidebar-profile-info" title="Edit profile">
                            <p class="welcome">Welcome,</p>
                            <p id="sidebar-name"><?php echo "Admin ".$first_name;?></p>
                     </div>
              </div>

              <div class="sidebar-activities">
                     <ul>
                            <li><img src="../img/app/dashboard.png" alt=""><a href="../main/dashboard.php">Dashboard</a></li>
                            <li><img src="../img/app/add_event.png" alt=""><a href="../main/edit_events.php">Events</a></li>
                            <li><img src="../img/app/students_info.png" alt=""><a href="../main/users_information.php">Users</a></li>
                            <li><img src="../img/app/payments.png" alt=""><a href="../main/payments.php">Payments</a></li>
                            <!--<li><img src="../img/app/messages.png" alt=""><a href="../main/notes.php">Messages</a></li>-->
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
</body>
</html>

<?php
}else{
       relocate('login');
}
?>