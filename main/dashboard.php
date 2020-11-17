<?php require_once 'conf.php'; 
require_once 'functions.php';
if(isset($_SESSION['username'])){
       
/*GENERAL-------------------------------------------------*/
$gen_teachers = $data->query( "SELECT * FROM users WHERE user_role=3");  
$gen_teachers->setFetchMode(PDO::FETCH_OBJ);
$gen_teachers = $gen_teachers->fetchAll();
$total_teachers = count($gen_teachers);

$gen_students = $data->query( "SELECT * FROM users WHERE user_role=4");  
$gen_students->setFetchMode(PDO::FETCH_OBJ);
$gen_students = $gen_students->fetchAll();
$total_students = count($gen_students);

$total_users=$total_teachers+$total_students;    //teachers+students

/*NEWS--------------------------------------------------*/
$recent_news = $data->query( "SELECT * FROM all_news WHERE news_type=1");  
$recent_news->setFetchMode(PDO::FETCH_OBJ);
$recent_news = $recent_news->fetchAll();


$activities = $data->query( "SELECT * FROM all_news WHERE news_type=2");  
$activities->setFetchMode(PDO::FETCH_OBJ);
$activities = $activities->fetchAll();
       ?>

<!DOCTYPE html>
<html>
<head>
       <?php include 'head.html';?>
       <title>Dashboard</title>

</head>
<body style="overflow: hidden;">
              
       <?php 
             sidebar();
       ?>  
              <main >
                     <div class="numbers-container">
                            <div class="numbers-section-container color-blue">
                                   <div class="numbers-section-info">
                                          <p class="number"><?php echo $total_students;?></p>
                                          <p class="status">Students</p>
                                          <p class="def">Total students</p>
                                   </div>
       
                                   <div class="numbers-section-picture">
                                          <img src="../img/app/students.png" alt="">
                                   </div>
                            </div>
       
                            <div class="numbers-section-container color-dark">
                                   <div class="numbers-section-info">
                                          <p class="number"><?php echo $total_teachers;?></p>
                                          <p class="status">Teachers</p>
                                          <p class="def">Total teachers</p>
                                   </div>
       
                                   <div class="numbers-section-picture">
                                          <img src="../img/app/teachers.png" alt="">
                                   </div>
                            </div>
       
                     </div>
              
                     <div class="news-container">
       
                     
                     
                     <!--Recent notice news-->
                     <div class="news-sub-container width30">
                            <h4>Recent Notice</h3>
                            <hr>
       
                            <?php 
                                   if (empty($recent_news[0])){
                                          echo "";
                                   }else {
                                          for($i=0;$i<count($recent_news);$i++){
                                          $month = explode(" ", $recent_news[$i]->event_day);
                                          echo "
                                                 <div class='news-section'>             
                                                        <div class='news-text'>
                                                               <h3>".$recent_news[$i]->event_title."</h3>
                                                               <p>".$recent_news[$i]->event_text."</p>
                                                        </div>
                                                 </div>"."<br>"."<br>";
                                          }
                                   }
                            ?>
                            
                     </div>
       
       
       
                     <!--Activities news-->
                            <div class="news-sub-container width60">
                                   <h4>Activities</h4>
                                   <hr>

                                   <?php                        
                                          if (!empty($activities)){
                                                 for($i=0;$i<count($activities);$i++){
                                                        $month = explode(" ", $activities[$i]->event_day);
                                                        echo "
                                                        <div class='news-section'>
                                                               <div class='date'>
                                                                      <p class='date-month'>".$month[1]."</p>
                                                                      <p class='date-num'>".$month[0]."</p>
                                                               </div>
                                          
                                                               <div class='news-text'>
                                                                      <h3>".$activities[$i]->event_title."</h3>
                                                                      <p>".$activities[$i]->event_text."</p>
                                                               </div>
                                                        </div>"."<br>"."<br>";
                                                 }
                                          }
                                   ?>

                            </div>
                     </div>
              </main>
       </body>
       </html>    
<?php

}else{
       relocate('login');
}

