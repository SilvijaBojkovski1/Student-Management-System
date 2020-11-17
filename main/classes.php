<?php 
require_once 'conf.php';
require_once 'functions.php';

if(isset($_SESSION['username'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
       <title>Classes List</title>
       <?php include 'head.html';?> 

       <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script>
$('html,body').bind('mousewheel',function(ev, delta) {
var scrollTop = $(this).scrollTop();
$(this).scrollTop(scrollTop-Math.round(delta * 1));
});
</script>
</head>
<body style="background-image: unset;">
       
       <?php 
       
       sidebar();?>
<div class="classes-container">
              <div class="main-title">
                     <p>Classes List</p>
              </div>
<main>
       <div class="table-container">
       <table >
              <tr style="background-color:#91BEE9;">
                    <th></th> 
                    <th style="width:30vw;">Class</th>               
              </tr>
              <?php 
                     showClasses();
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