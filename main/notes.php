<?php 

require_once 'conf.php';
require_once 'functions.php';

if(isset($_SESSION['username'])){
if(isset($_POST['note-submit'])){
       $noteTitle = $_POST['note-title'];
       $noteText = $_POST['note-text'];

       try{
              $note_insert = "INSERT INTO `notes`(`notes_id`, `user`, `note_title`, `note_text`) VALUES (null,'$user_id','$noteTitle','$noteText')";
              $data->exec($note_insert);
              echo "<script>alert('Note is saved!');</script>";
       }catch(PDOException $e){
              echo "<script>alert('Error has occured while trying to save note. Try again!');</script>".$e;
       }

       
}

$show_notes = $data->query("SELECT * FROM notes WHERE $user_id");
$show_notes->setFetchMode(PDO::FETCH_OBJ);
$show_notes = $show_notes->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
       <title>Notes</title>
       <?php include 'head.html';?> 
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>
<body>
       <?php 
       
       sidebar();
       ?>
       <main>
       <div class="notes-page">
              <div class="make-note-bttn">
                     <button id="add" onclick="createNote()" >New note <img src="../img/app/plus.png" alt=""></button>
              </div>
       
              <div class="notes-container" id="notes-container">
                     <?php 
                            for($i=0;$i<count($show_notes);$i++){
                                   echo '
                                   <div class="note" id="note">
                                   <div class="sticky-note-title">
                                          <h4>'.$show_notes[$i]->note_title.'</h4>
                                          <hr>
                                   </div>
       
                                   <div class="sticky-note-text">
                                          <p>'.$show_notes[$i]->note_text.'</p>
                                   </div>
       
                                   <div class="note-change">
                                          <img src="../img/edit_note.png" alt="" id="save-note" style="cursor:pointer;"  name="change-note">
                                   </div>
                            </div>
                                   ';   
                            }
                     ?>
                     
              </div>
       </div>

       <div class="note-creator" id="note-creator">
              <h3>Create a note</h3>
              <form action="" method="POST">
                            <div class="note-title">
                                   <input type="text" class="border-right" name="note-title" placeholder="Title">
                            </div>

                     <br>
                     <div class="note-text">
                            <textarea name="note-text" id="" cols="44" rows="30" placeholder="Here goes text"></textarea>
                     </div>

                     <div class="note-save-cancel">
                            <input type="submit" value="Cancel" name="cancel-note" onclick="hideCreator()">
                            <input type="submit" value="Save" name="note-submit">
                     </div>
              </form>
       </div>
       </main>
<script>       
              
       var note = document.getElementById("note-creator");
       var div = document.createElement('div');  

       function createNote() {
              div.id = 'create-note-bg';
              document.body.appendChild(div);
              div.style.position = "absolute";
              div.style.width = "100vw";
              div.style.height = "100vh";
              div.style.background = "rgba(217,217,217,0.7)";
              div.style.backgroundSize = "cover";
              div.style.zIndex = "1";

              note.style.display = "initial";
              note.style.position = "fixed";
              note.style.zIndex = "2";
       }

       function hideCreator(){
              note.style.display = "none";
              div.style.display = "none";
       }
     </script>
</body>
</html>

<?php
}else{
       relocate('login');
}
?>