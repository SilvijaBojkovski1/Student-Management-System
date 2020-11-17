<?php

require_once 'conf.php';
require_once 'functions.php';

if(isset($_SESSION['username'])){
if(isset($_POST['deleteBttn']) && isset($_POST['del-req'])){

       $req = $_POST['del-req'];
       $del = $data->query("SELECT * FROM payments WHERE payment_id='$req'");
       $del->setFetchMode(PDO::FETCH_OBJ);
       $del = $del->fetch();
       if(empty($del)){
              echo "<span style='color:green; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
              '>"."Record with that ID does not exists! Check input and try again!"."</span>";
       }else{
              $request = $data->exec("DELETE FROM payments WHERE payment_id='$req'");
              echo "<span style='color:green; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
              '>"."Record deleted successfully!"."</span>";
       }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
       <title>Payments</title>
       <?php include 'head.html';?> 
       <link rel="stylesheet" href="../style/admin.css">
</head>
<body style="background-image: unset;">
       
       <?php 
       
       sidebar();
       ?>
       <main>
<div class="payments-container">
              <div class="main-title">
                     <p>Payments</p>
              </div>
<?php if($user_role == 2){
?>
<div class="events-f" style="margin-left:30px;" id="events-f">
              
              <div class="events-f-show">
                     <form action="" method="POST">
                            <label for="">Search</label>
                            <select name="search">
                                   <option value="id">Id</option>
                                   <option value="date">Date</option>
                                   <option value="student">Student</option>
                            </select>
                            <input type="text" name="pay-search-req" placeholder="Request">
                            <input type="submit" value="Search" name="pay-search">
                     </form>
              </div>

              <div class="events-f-delete">
                     <form action="" method="POST">
                            <label for="">Delete</label>
                            <input type="text" name="del-req" placeholder="Payment ID">
                            <input type="submit" value="Delete" name="deleteBttn">
                     </form>
              </div>
       </div>
       <div class="make-note-bttn admin-add-event" id="button-div">
              <button id="add" onclick="redirect()">Add Payment<img src="../img/app/plus.png" alt=""></button>
       </div>
<?php
}
       ?>       
       <div class="table-container">
       <table>
              <tr style="background-color:#91BEE9;">
                     <?php if($user_role == 2){echo "<th style='width:30px;'>Pay. Id</th>";} ?>
                     <th style="width:70px;">Date</th>
                     <?php if($user_role == 2){echo "<th style='width:200px;'>Student</th>";} ?>
                     <?php if($user_role == 2){echo "<th style='width:fit-content'>Index number</th>";} ?>
                     <th style="width:300px;">Purpose</th>
                     <th style="width:100px;">Amount</th>
              </tr>

              <?php 

              if($user_role == 2){
                     if(isset($_POST['pay-search'])){
                            $req = $_POST['pay-search-req'];
                            $by = $_POST['search'];
                            searchPaymentsBy($by,$req);
                     }else{
                            showPayments();  
                     }
              }else{
                     showPayments(); 
              }
              
              ?>

              
              
       </table>
       </div>
       </div>
       </main>  
       <script>
       function redirect(){
              window.location.href = "../main/add_payment.php";
       }

</script>
</body>
</html>

<?php
}else{
       relocate('login');
}
?>