<?php 
       require_once 'conf.php';
       require_once 'functions.php';
       include 'simple_html_dom.php';
if(isset($_SESSION['username'])){
       if(isset($_POST['event-submit'])){
              $event_title = $_POST['event-title'];
              $event_text = $_POST['event-text'];
              $posted_by = $user_id;
              $user_name = $first_name." ".$last_name;

                     try{
                            if($user_role == 2){
                                   $event_insert = "INSERT INTO `all_news`(`news_id`, `news_type`,`posted_by`,`user_name`, `event_title`, `event_text`) 
                                                        VALUES (null,1,'$posted_by','$user_name','$event_title','$event_text')";
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
       <title>Events</title>
       <link rel="stylesheet" href="../style/jquery-ui.css">
      <?php require_once 'head.html';?>
      
      <link rel="stylesheet" href="../style/admin.css">

      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body style="background-image: unset;">
       
     <?php sidebar();?>
<div class="ee-container">
              <div class="main-title" id="ee-title">
                     <p>Events</p>
              </div>
       
              <div class="events-f" style="margin-left:30px;" id="events-f">
                     <div class="events-f-sort" ">
                            <form action="" method="POST">
                                   <label for=""> Sort by</label>
                                   <select name="sort" id="">
                                          <option value="type">Type</option>
                                          <option value="date">Date</option>
                                   </select>
                                   <input type="submit" name="go-sort" value="Sort">
                            </form>
                           
                     </div>
              
                     <div class="events-f-show">
                            <form action="" method="POST">
                                   <label for="">Search</label>
                                   <select name="search">
                                          <option value="type">Type</option>
                                          <option value="date">Date</option>
                                          <option value="id">Id</option>
                                   </select>
                                   <input type="text" name="search-req" placeholder="Request">
                                   <input type="submit" value="Search" name="go-search">
                            </form>
                     </div>

                     <div class="events-f-delete">
                            <form action="" method="POST">
                                   <label for="">Delete</label>
                                   <input type="text" name="del-req" placeholder="Record ID">
                                   <input type="submit" value="Delete" name="deleteBttn">
                            </form>
                     </div>
              </div>

              <div class="make-note-bttn admin-add-event" id="button-div">
                     <button id="add" onclick="hideTable()">Add Event<img src="../img/app/plus.png" alt="" style="display:block;"></button>
              </div>
              
       <div class="ee-table-container" style="margin-left:30px;" id="table">
       <table id="events_id">
              <tr style="background-color:#91BEE9;">
                    <th>Type</th> 
                    <th style="width:30vw;">Event</th>
                    <th style="width:15vw;">Event_id</th>
                    <th>Posted By</th>
                    <th>Date</th>  
              </tr>

            <?php 
                     if(isset($_POST['go-sort'])){   
                            $sort_by=$_POST['sort'];
                            showEvents($sort_by);  
                     }elseif(isset($_POST['go-search'])){
                            $req = $_POST['search-req'];
                            $by = $_POST['search'];
                            searchEventsBy($by,$req);
                     }else{
                            showEvents();  
                     }
              ?> 
       </table>
       </div>
       </div>
       
       <div id="add-event" class="hide">
       <div class="main-title hide" id="ae-title" >
                     <p style="margin-top: 20px;">Add Event</p>
              </div>
       <div class="event-container" style="margin-left:0px;">
       
              <form action="" method="POST">
                     <div class="event-title">
                            <label class="border-left">Title</label>
                            <input type="text" class="border-right" name="event-title">
                     </div>
                     
                     <br>
                     <div class="event-details">
                            <label for="">Event details</label>
                     <br>
                            <textarea name="event-text" id="" cols="67" rows="20" ></textarea>
                     </div>

                     <div class="event-submit-bttn">
                            <input type="submit" value="<- List Events" onclick="listEvents()">
                            <input type="submit" name="event-submit" value="Publish Event" >
                     </div>
              </form>     

       </div>
       </div>
<?php 

/*DELETE RECORD -------------------------------*/
if(isset($_POST['deleteBttn']) && isset($_POST['del-req'])){
       $req = $_POST['del-req'];
       $del = $data->query("SELECT * FROM all_news WHERE news_id='$req'");
       $del->setFetchMode(PDO::FETCH_OBJ);
       $del = $del->fetchAll();
       if(empty($del)){
              echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."Record with that ID does not exists! Check input and try again!"."</span>";
       }else{
              $request = $data->exec("DELETE FROM `all_news` WHERE news_id='$req'"); //ovo radi, nastaviti dalje
              echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."Record deleted successfully!"."</span>";
       }
}

?>

<script>
       function hideTable(){
              document.getElementById("table").style.display ="none";
              document.getElementById("events-f").style.display ="none";
              document.getElementById("ee-title").style.display ="none";
              document.getElementById("add-event").style.display ="initial";
              document.getElementById("add").style.display ="none";
              document.getElementById("ae-title").style.display ="initial";


              

       }

       function listEvents(){
              document.getElementById("table").style.display ="inherit";
              document.getElementById("events-f").style.display ="flex";
              document.getElementById("ee-title").style.display ="inherit";
              document.getElementById("add-event").style.display ="none";
              document.getElementById("add").style.display ="inline-block";
              document.getElementById("ae-title").style.display ="none";
       }
</script>
</body>
</html>


<?php
}else{
       relocate('login');
}
?>