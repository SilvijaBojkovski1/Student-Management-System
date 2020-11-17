<?php
       require_once 'conf.php';
       require_once 'functions.php';

if(isset($_SESSION['username'])){
       if(isset($_POST['payment-submit'])){
              $student = $_POST['student'];
              $refNmb = $_POST['index'];
              $purpose = $_POST['purpose'];
              $amount = $_POST['amount'];
              $date = $_POST['date'];
              if (!empty($date)){
                     $date = $_POST['date'];
              }else{
                     $dateArr = getdate();
                     $month = str_split($dateArr['month'],3);
                     $date = $dateArr['mday']." ".$month[0]." ".$dateArr['year'];
              }

              if(!empty($student) and !empty($refNmb) and !empty($purpose) and !empty($amount)){
                     $user = $data->query("SELECT * FROM users WHERE index_number = '$refNmb'");
                     $user->setFetchMode(PDO::FETCH_OBJ);
                     $user= $user->fetch();
                     
                     if(!empty($user)){
                            try{
                                    $prevBalance = $user->balance;
                                    $newBalance = $prevBalance + $amount;
               
                                    $sql = "INSERT INTO `payments`(`payment_id`, `date_added`, `student`,`index_number`, `purpose`, `amount`,`balance`) 
                                                  VALUES (null,'$date','$student','$refNmb','$purpose','$amount','$newBalance')";
                                    $data->exec($sql);    
                                   echo "<span style='color:green; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."Adding new payment is successfull!"."</span>";    
                             }catch(PDOException $e){
                                    echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."The error has occured while adding payment. Please check all the inputs and try again!".$refNmb."!"."</span>";
                             }  
                     }else {
                            echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."There is no match for student with index number ".$refNmb."!"."</span>";
                     }
              }else{
                     echo "<span style='color:red; padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                    '>"."All input fields are reqired (except date)!"."</span>";
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
       require_once 'conf.php';
       require_once 'functions.php';
       sidebar();
       ?> 

       <div class="main-content-container">
              <div class="main-title" id="au-title" >
                     <p style="margin-top: 20px;">Add Payment</p>
              </div>

              <div class="add-pay-container">
                     <form action="" method="POST">
                            
                            <label >Name</label>
                            <input type="text" name="student">
                            <br>
                            <label >Reference number</label>
                            <input type="text" name="index">
                            <br>
                            <label>Purpose of payment</label>
                            <textarea name="purpose" id="" cols="30" rows="5"></textarea>
                            <br>
                            <div class="am-dt-container">
                                   <div class="am-dt">
                                          <label >Amount</label>
                                          <input type="text" name="amount" style="width:150px">
                                   </div>

                                   <div class="am-dt">
                                          <label>Date</label>
                                          <input type="text" name="date" style="width:150px">
                                   </div>
                                   
                            </div>
                            
                            <div class="pay-submit-bttn">
                                   <input type="submit" name="payment-submit" value="Submit Payment">
                            </div>  
                     </form>
              </div>
              <br>
              <input type="submit" value="<- List Payments" onclick="listPayments()" class="add-user-bttn" style="margin-left:30px; width:150px;">
       </div>
       

<script>
       function listPayments(){
              window.location.href = "../main/payments.php";
       }
</script>
       
</body>
</html>


<?php
}else{
       relocate('login');
}
?>