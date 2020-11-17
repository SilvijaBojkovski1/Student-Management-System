<?php 
require_once 'conf.php';
require_once 'functions.php';

if(isset($_SESSION['username'])){
?>



<!DOCTYPE html>
<html lang="en">
<head>
       <title>Grades</title>
       <?php include 'head.html';?> 
</head>
<body style="background-image: unset;">
       
       <?php 
       
       sidebar();?>
<main>
<div class="classes-container">
              <div class="main-title">
                     <p>Grades</p>
              </div>
       
       <div class="table-container">
       <table>
              <tr style="background-color:#91BEE9;">
                    <th style="width:30vw;">Class</th> 
                    <th style="width:15vw;">Teacher</th>  
                    <th style="width:fit-content;">Points</th>  
                    <th style="width:fit-content;">Grade</th>  
                    <th style="width:fit-content;">Date</th>                    
              </tr>
              <?php 
                     showGrades();
              ?>

              
       </table>
       </div>
       </div>
      
</main>    
</body>
</html>

<?php
}else{
       relocate('login');
}
?>