<?php
session_start();

class DBConnection{
       private $sn='localhost';
       private $db = 'student_management';
       private $usname='root';
       private $pass='root';

       function connect(){
      
              try{
                     $database = new PDO("mysql:host=$this->sn;dbname=$this->db",$this->usname,$this->pass);
                     $database->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
 
                     return $database;
              }catch(PDOException $e){
                  echo "Connection failed: ".$e->getMessage();
              }
       }  
}

$data = new DBConnection();
$data=$data->connect();

if(isset($_SESSION['username'])){
       $username = $_SESSION['username'];
       try{
              $us_info = $data->query( "SELECT * FROM users WHERE username='$username'");  
              $us_info->execute();
              $us_info->setFetchMode(PDO::FETCH_OBJ);
              $us_info = $us_info->fetch();
              
              $user_id = $us_info->userID;
              $first_name = $us_info->first_name;
              $last_name = $us_info->last_name;
              $personal_id = $us_info->personal_id;
              $adress = $us_info->adress;
              
              $contact_number = $us_info->contact_number;
              $mail = $us_info->mail;
              $userPassword = $us_info->userPassword;
              $user_role = $us_info->user_role;
              $date_of_birth = $us_info->date_of_birth;
              $city_of_birth = $us_info->city_of_birth;
              
              if($user_role == 4){
                     $index_num = $us_info->index_number;
                     $course = $us_info->course;
                     $course_name_get = $data->query( "SELECT courseName FROM course WHERE course_id='$course'"); 
                     $course_name_get->execute();
                     $course_name_get->setFetchMode(PDO::FETCH_OBJ);
                     $course_name_get = $course_name_get->fetch();
                     $course_name = $course_name_get->courseName;
              }
       }catch(PDOException $e){
              echo $e;
       }
}



