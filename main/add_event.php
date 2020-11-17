<?php
require_once 'conf.php';
require_once 'functions.php';

if(isset($_SESSION)){

if(isset($_POST['event-submit'])){
$event_title = $_POST['event-title'];
$event_date = $_POST['event-date'];
$event_type = $_POST['event-type'];
$event_text = $_POST['event-text'];
$event_date = explode(",",$event_date);
$event_day = $event_date[0];
$event_year = $event_date[1];
$user_name = $first_name." ".$last_name;
       try{
              if($user_role == 3){
                     $event_insert = "INSERT INTO `all_news`(`news_id`, `news_type`,`posted_by`,`user_name`,`event_title`, `event_day`,`event_year`, `event_type`, `event_text`) 
                                          VALUES (null,2,'$user_id','$user_name','$event_title','$event_day','$event_year','$event_type','$event_text')";
              $data->exec($event_insert);
              echo "<script>alert('Event published successful!');</script>";
              }
              
       }catch(PDOException $e){
              echo "<script>alert('Error has occured while publishing event!');</script>".$e;
       }
         
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
       <title>Add Event</title>
       <link rel="stylesheet" href="../style/jquery-ui.css">
       <?php include 'head.html';?> 
       
       <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <?php include 'datepicker.html'?>
       
</head>
<body>
<?php sidebar();?>
<div class="main-content-container">
<div class="main-title" id="au-title" >
                     <p style="margin-top: 20px;">Add Event</p>
              </div>

       <div class="event-container">
              <form action="" method="POST">
                     <div class="event-title">
                            <label class="border-left">Title</label>
                            <input type="text" class="border-right" name="event-title">
                     </div >
                     <div class="event-date-type-container">
                            <div class="event-date">
                                   <label for="" class="border-left">Date </label>
                                   <input type="text" class="datepicker" class="border-right" name="event-date">
                            </div>
                            
                            <div class="event-type">
                                   <label for="" class="border-left">Type</label>
                                   <select name="event-type" id="" class="border-right" name="event-type">
                                          <option value="exam">Exam</option>
                                          <option value="test">Test</option>
                                   </select>
                            </div>
                     </div>
                     
                     <br>
                     <div class="event-details">
                            <label for="">Event details</label>
                     <br>
                            <textarea name="event-text" id="" cols="67" rows="20" ></textarea>
                     </div>

                     <div class="event-submit-bttn">
                            <input type="submit" name="event-submit">
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