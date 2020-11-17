
<?php
include 'conf.php';
include 'functions.php';
include 'index.html';
ini_set('display_errors', false);

class LogIn{

       function logInCheck(){
              if ( isset( $_POST['submit'] )) { 
                     if(!empty($_POST['un']) and !empty($_POST['pass'])){
                            $username=isset($_POST['un']) ? $_POST['un'] : " ";
                            $password=isset($_POST['pass']) ? $_POST['pass'] : " ";
                            
                                   global $data;
                                   $stmt = $data->query( "SELECT * FROM users WHERE username='$username' AND userPassword='$password'");  
                                   $stmt->execute();
                                   $stmt->setFetchMode(PDO::FETCH_OBJ);
                                   $stmt = $stmt->fetch(); 

                                   try{
                                          if(($username == $stmt->username) && ($password == $stmt->userPassword)){
                                                 $_SESSION['username']=$stmt->username;
                                                 relocate('dashboard');
                                          }else{
                                                 echo "<span style='color:red; background-color:rgba(255,255,255,0.7); padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                          '>"."User does not exists.Please try again!"."</span>";
                                          }
                                   }catch(PDOException $e){
                                          echo "<span style='color:red; background-color:rgba(255,255,255,0.7); padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                                          '>"."User does not exists.Please try again!"."</span>".$e;
                                   }
                     }else{
                            echo "<span style='color:red; background-color:rgba(255,255,255,0.7); padding: 2px; height: fit-content;  text-align: center;width:100%;position:absolute;
                            '>"."User does not exists.Please try again!"."</span>";
                            session_destroy();
                     }
                            
              }
              }  
       }

$in=new LogIn();
$in->logInCheck();



?>