<?php
require_once 'conf.php';
require_once 'head.html';
ini_set('display_errors', false);





              function relocate($location){
                     switch($location){
                            case 'dashboard':  echo "<script>window.location.href = 'http://localhost/student_management_system/main/dashboard.php';</script>";  //header("Location: http://localhost/student_management_system/main/dashboard.php"); exit();
                                   break;
                            case 'login': echo "<script>window.location.href = 'http://localhost/student_management_system/main/index.php';</script>";              //header("Location: http://localhost/student_management_system/main/index.php"); exit();
                                   break;
                     }
              }
              
              function sidebar(){
                     global $data;
                     global $user_role;
                     global $first_name;
                     switch($user_role){
                            case 1: include 'sidebar.php';
                                   break;
                            case 2: include 'admin_sidebar.php';
                                   break;
                            case 3: include 'teacher_sidebar.php';
                                   break;
                            case 4: include 'student_sidebar.php';
                                   break;
                            }
              }

                     $classes = $data->query( "SELECT * FROM classes WHERE course='$course' ");  
                     $classes->setFetchMode(PDO::FETCH_OBJ);
                     $classes = $classes->fetchAll();

                     
              function showClasses(){
                     global $data;
                     global $classes;
                     
                     //echo "<pre>";
                     //print_r($classes);

                     for($i=0; $i<count($classes);$i++){
                            echo "<tr>";
                                   echo "<td>".($i+1)."</td>";
                                   echo "<td>".$classes[$i]->class_name."</td>";
                            echo "</tr>"; 
                                    
                            }
              }

              function showPayments(){
                     global $data;
                     global $user_id;
                     global $user_role;
                     global $index_num;
                     if($user_role == 4){
                            $payments = $data->query( "SELECT * FROM payments WHERE index_number='$index_num'");  
                            $payments->setFetchMode(PDO::FETCH_OBJ);
                            $payments = $payments->fetchAll();
                     }else{
                            $payments = $data->query( "SELECT * FROM payments");  
                            $payments->setFetchMode(PDO::FETCH_OBJ);
                            $payments = $payments->fetchAll();
                     }
                     

                     if(!empty($payments)){
                            if($user_role == 4){
                                   for($i=0; $i<count($payments);$i++){
                                          echo "<tr>";
                                                 echo "<td style='width:200px;'>".$payments[$i]->date_added."</td>";
                                                 echo "<td style='width:400px;'>".$payments[$i]->purpose."</td>";
                                                 echo "<td style='width:200px;'>".$payments[$i]->amount."</td>";
                                          echo "</tr>";   
                                          }
                            }else{
                                   for($i=0; $i<count($payments);$i++){
                                          echo "<tr>";
                                                 echo "<td>".$payments[$i]->payment_id."</td>";
                                                 echo "<td style='width:150px;'>".$payments[$i]->date_added."</td>";
                                                 echo "<td style='width:300px;'>".$payments[$i]->student."</td>";
                                                 echo "<td style='width:200px;'>".$payments[$i]->index_number."</td>";
                                                 echo "<td>".$payments[$i]->purpose."</td>";
                                                 echo "<td>".$payments[$i]->amount."</td>";
                                          echo "</tr>";   
                                          }
                            }
                            
                     }else{
                            echo "<tr>
                                          <td colspan='6' style='text-align:center;'>There were no payments!</td>
                                   </tr>";
                     }

              }

              $payments = $data->query( "SELECT * FROM payments");  
              $payments->setFetchMode(PDO::FETCH_OBJ);
              $payments = $payments->fetchAll();

              function searchPaymentsBy($by, $req=''){
                     global $data;
                     switch($by){
                            case 'date':  $payments = $data->query( "SELECT * FROM payments WHERE date_added = '$req'");  
                                          $payments->setFetchMode(PDO::FETCH_OBJ);
                                          $payments = $payments->fetchAll();
                                   break;
                            case 'student': $payments = $data->query( "SELECT * FROM payments WHERE index_number = '$req'");  
                                          $payments->setFetchMode(PDO::FETCH_OBJ);
                                          $payments = $payments->fetchAll();
                                   break;
                            case 'id':    $payments = $data->query( "SELECT * FROM payments WHERE payment_id = '$req'");  
                                          $payments->setFetchMode(PDO::FETCH_OBJ);
                                          $payments = $payments->fetchAll();
                                   break;                       
                     }         

                     for($i=0; $i<count($payments);$i++){
                            echo "<tr>";
                                   echo "<td>".$payments[$i]->payment_id."</td>";
                                   echo "<td style='width:150px;'>".$payments[$i]->date_added."</td>";
                                   echo "<td style='width:300px;'>".$payments[$i]->student."</td>";
                                   echo "<td style='width:200px;'>".$payments[$i]->index_number."</td>";
                                   echo "<td>".$payments[$i]->purpose."</td>";
                                   echo "<td>".$payments[$i]->amount."</td>";
                            echo "</tr>";   
                      }  
              }

                     $events = $data->query("SELECT * FROM all_news");  
                     $events->execute();
                     $events->setFetchMode(PDO::FETCH_OBJ);
                     $events = $events->fetchAll();

              function showEvents($ex=''){
                     global $events;
                     global $data;
                     //echo "<pre>";
                     //print_r($events);
                     $num=0;

                     if(!empty($events)){

                            if($ex=='date'){
                                   $events = $data->query( "SELECT * FROM all_news ORDER BY event_day");  
                                   $events->setFetchMode(PDO::FETCH_OBJ);
                                   $events = $events->fetchAll();
                            }elseif($ex =='type'){
                                   $events = $data->query( "SELECT * FROM all_news ORDER BY news_type");  
                                   $events->setFetchMode(PDO::FETCH_OBJ);
                                   $events = $events->fetchAll();
                            }
                            for($i=0; $i<count($events);$i++){

                                  if($events[$i]->news_type == 1){
                                          $type = 'Recent_news';
                                   }else{
                                          $type = 'Activities';
                                   }

                                   echo "<tr>";
                                   echo "<form action='edit_events.php' method='POST'>";
                                          echo "<td>".$type."</td>";
                                          echo "<td>".$events[$i]->event_text."</td>";
                                          $trash_id = $events[$i]->news_id;
                                          echo "<td>".$trash_id."</td>";
                                          echo "<td>".$events[$i]->posted_by."</td>";
                                          echo "<td>".$events[$i]->event_day." "."</td>";
                                          echo "</form>";
                                          echo "</tr>";  
                            } 
                     }else{
                            echo "<tr>
                                          <td colspan='5' style='text-align:center;'>There were no payments!</td>
                                   </tr>";
                     }
                     
              }

              function searchEventsBy($by,$req){
                     global $events;
                     global $data;

                     if($req == 'Recent_news' or $req == 'recent_news' or $req == 'Recent news' or $req == 'recent news'){
                             $reqq = 1;
                     }elseif($req == 'Activities' or $req == 'activities'){
                            $reqq = 2;
                     }

                     switch($by){
                            case 'type':  $events = $data->query("SELECT * FROM all_news WHERE news_type='$reqq'");
                                          $events->setFetchMode(PDO::FETCH_OBJ);
                                          $events = $events->fetchAll();
                                   break;
                            case 'date': $events = $data->query("SELECT * FROM all_news WHERE event_day='$req'");
                                          $events->setFetchMode(PDO::FETCH_OBJ);
                                          $events = $events->fetchAll();
                                   break;
                            case 'id': $events = $data->query("SELECT * FROM all_news WHERE news_id='$req'");
                                          $events->setFetchMode(PDO::FETCH_OBJ);
                                          $events = $events->fetchAll();
                                   break;                       
                     }         

                     for($i=0; $i<count($events);$i++){

                            if($events[$i]->news_type == 1){
                                    $type = 'Recent_news';
                             }else{
                                    $type = 'Activities';
                             }

                             echo "<tr>";
                             echo "<form action='edit_events.php' method='POST'>";
                                    echo "<td>".$type."</td>";
                                    echo "<td>".$events[$i]->event_text."</td>";
                                    $trash_id = $events[$i]->news_id;
                                    echo "<td>".$trash_id."</td>";
                                    echo "<td>".$events[$i]->posted_by."</td>";
                                    echo "<td>".$events[$i]->event_day." "."</td>";
                                    echo "</form>";
                                    echo "</tr>";   
                      }  
              }


                     $user_list = $data->query("SELECT * FROM users ORDER BY userID");  
                     $user_list->execute();
                     $user_list->setFetchMode(PDO::FETCH_OBJ);
                     $user_list = $user_list->fetchAll();

                     function showUsers($ex=''){
                            global $user_list;
                            global $data;
                            global $user_role;

                            if(!empty($user_list)){
       
                                   if($ex=='role'){
                                          $user_list = $data->query( "SELECT * FROM users ORDER BY user_role"); 
                                          $user_list->setFetchMode(PDO::FETCH_OBJ);
                                          $user_list = $user_list->fetchAll(); 
                                   }elseif($ex =='name'){
                                          $user_list = $data->query( "SELECT * FROM users ORDER BY first_name");  
                                          $user_list->setFetchMode(PDO::FETCH_OBJ);
                                          $user_list = $user_list->fetchAll();
                                   }elseif($ex =='date inserted'){
                                          $user_list = $data->query( "SELECT * FROM users ORDER BY date_added"); 
                                          $user_list->setFetchMode(PDO::FETCH_OBJ);
                                          $user_list = $user_list->fetchAll(); 
                                   }elseif($ex =='id'){
                                          $user_list = $data->query( "SELECT * FROM users ORDER BY userID"); 
                                          $user_list->setFetchMode(PDO::FETCH_OBJ);
                                          $user_list = $user_list->fetchAll(); 
                                   }

                                   for($i=0; $i<count($user_list);$i++){
                                          $user_id = $user_list[$i]->userID;
                                          $first_name = $user_list[$i]->first_name;
                                          $last_name = $user_list[$i]->last_name;
                                          $personal_id = $user_list[$i]->personal_id;
                                          $adress = $user_list[$i]->adress;
                                          $contact_number = $user_list[$i]->contact_number;
                                          $mail = $user_list[$i]->mail;
                                          $userPassword = $user_list[$i]->userPassword;
                                          $user_role = $user_list[$i]->user_role;
                                          $date_of_birth = $user_list[$i]->date_of_birth;
                                          $city_of_birth = $user_list[$i]->city_of_birth;
                                          $date_added = $user_list[$i]->date_added;

                                         if($user_list[$i]->user_role == 2){
                                                 $role = 'Admin';
                                          }elseif($user_list[$i]->user_role == 3){
                                                 $role = 'Teacher';
                                          }elseif($user_list[$i]->user_role == 1){
                                                 $role = 'Super Admin';
                                          }else{
                                                 $role = 'Student';
                                          }
       
                                          echo "<tr>";
                                          echo "<form action='edit_events.php' method='POST'>";
                                                 echo "<td>".$user_id."</td>";
                                                 echo "<td>".$role."</td>";
                                                 echo "<td>".$first_name." ".$last_name."</td>";
                                                 echo "<td>".$personal_id."</td>";
                                                 echo "<td>".$date_added."</td>";
                                                 /*echo "<td>".$personal_id."</td>";
                                                 echo "<td>".$adress."</td>";
                                                 echo "<td>".$city_of_birth."</td>";
                                                 echo "<td>".$date_of_birth."</td>";
                                                 echo "<td>".$contact_number."</td>";
                                                 echo "<td>".$mail."</td>";
                                                 echo "<td>".$users_list[$i]->username."</td>";
                                                 echo "<td>".$userPassword."</td>";*/
                                          echo "</form>";
                                          echo "</tr>";   
                                   } 
                            }else{
                                   echo "<tr>
                                                <td colspan='5' style='text-align:center;'>There are no any users!</td>
                                          </tr>";
                            }
                            
                     }

                     function searchUsersBy($by,$reqq=''){
                            global $user_list;
                            global $data;
                            global $user_role;

                            if($reqq == 'super admin' or $reqq == 'Super admin' or $reqq == 'Super Admin'){
                                   $req = 1;
                            }elseif($reqq == 'admin' or $reqq == 'Admin'){
                                   $req = 2;
                            }elseif($reqq == 'teacher' or $reqq == 'Teacher'){
                                   $req = 3;
                            }elseif($reqq == 'student'){
                                   $req = 4;
                            }
                            
                            switch($by){
                                   case 'role':  $user_list = $data->query("SELECT * FROM users WHERE user_role='$req'");
                                                 $user_list->setFetchMode(PDO::FETCH_OBJ);
                                                 $user_list = $user_list->fetchAll();
                                          break;
                                   case 'id': $user_list = $data->query("SELECT * FROM users WHERE userID='$reqq'");
                                                 $user_list->setFetchMode(PDO::FETCH_OBJ);
                                                 $user_list = $user_list->fetchAll();
                                          break;
                                   case 'persid': $user_list = $data->query("SELECT * FROM users WHERE personal_id='$reqq'");
                                                 $user_list->setFetchMode(PDO::FETCH_OBJ);
                                                 $user_list = $user_list->fetchAll();
                                          break;
                                   }
                            for($i=0; $i<count($user_list);$i++){
       
                                   $user_id = $user_list[$i]->userID;
                                          $first_name = $user_list[$i]->first_name;
                                          $last_name = $user_list[$i]->last_name;
                                          $personal_id = $user_list[$i]->personal_id;
                                          $adress = $user_list[$i]->adress;
                                          $contact_number = $user_list[$i]->contact_number;
                                          $mail = $user_list[$i]->mail;
                                          $userPassword = $user_list[$i]->userPassword;
                                          $us_role = $user_list[$i]->user_role;
                                          $date_of_birth = $user_list[$i]->date_of_birth;
                                          $city_of_birth = $user_list[$i]->city_of_birth;

                                   if($us_role == 2){
                                          $role = 'Admin';
                                   }elseif($us_role == 3){
                                          $role = 'Teacher';
                                   }elseif($us_role == 1){
                                          $role = 'Super Admin';
                                   }else{
                                          $role = 'Student';
                                   }

                                   
                                   if($user_role == 2){
                                          echo "<tr>";
                                          echo "<td>".$user_id."</td>";
                                          echo "<td>".$role."</td>";
                                          echo "<td>".$first_name." ".$last_name."</td>";
                                          echo "<td>".$personal_id."</td>";
                                          echo "<td>"."/"."</td>";
                                          /*echo "<td>".$personal_id."</td>";
                                          echo "<td>".$adress."</td>";
                                          echo "<td>".$city_of_birth."</td>";
                                          echo "<td>".$date_of_birth."</td>";
                                          echo "<td>".$contact_number."</td>";
                                          echo "<td>".$mail."</td>";
                                          echo "<td>".$users_list[$i]->username."</td>";
                                          echo "<td>".$userPassword."</td>";*/
                                          echo "</tr>";
                                   }elseif($user_role == 3){
                                          echo "<tr>";
                                                 echo "<td>".$user_id."</td>";
                                                 echo "<td>".$first_name." ".$last_name."</td>";
                                                 echo "<td>".$index."</td>";
                                                 echo "<td>".$courseName->courseName."</td>";
                                                 echo "<td>".$mail."</td>";
                                                 echo "</tr>"; 
                                   }
                                     
                             }  
                     }

                     $students_list = $data->query("SELECT * FROM users WHERE user_role=4 ORDER BY first_name");  
                     $students_list->setFetchMode(PDO::FETCH_OBJ);
                     $students_list = $students_list->fetchAll();

                     $course = $data->query("SELECT courseName FROM course");  
                     $course->setFetchMode(PDO::FETCH_OBJ);
                     $course = $course->fetchAll();

                     function showUsersForTeacher($ex=''){
                            global $students_list;
                            global $data;
                            global $course;
                            
                            //if(!empty($students_list)){
                                   if($ex =='name'){
                                          $students_list = $data->query( "SELECT * FROM users WHERE user_role=4 ORDER BY first_name");  
                                          $students_list->setFetchMode(PDO::FETCH_OBJ);
                                          $students_list = $students_list->fetchAll();
                                   }elseif($ex =='index'){
                                          $students_list = $data->query( "SELECT * FROM users WHERE user_role=4 ORDER BY index_number");  
                                          $students_list->setFetchMode(PDO::FETCH_OBJ);
                                          $students_list = $students_list->fetchAll();
                                   }elseif($ex == 'course'){
                                          $students_list = $data->query( "SELECT * FROM users WHERE user_role=4 ORDER BY course");
                                          $students_list->setFetchMode(PDO::FETCH_OBJ);
                                          $students_list = $students_list->fetchAll();
                                   }
        
                                   for($i=0; $i<count($students_list);$i++){
                                          $first_name = $students_list[$i]->first_name;
                                          $last_name = $students_list[$i]->last_name;
                                          $mail = $students_list[$i]->mail;
                                          $index = $students_list[$i]->index_number;
                                          $courseNum = $students_list[$i]->course;
                                          $courseName = $course[$courseNum];
                                          echo "<tr>";
                                                 echo "<td>".$first_name." ".$last_name."</td>";
                                                 echo "<td>".$index."</td>";
                                                 echo "<td>".$courseName->courseName."</td>";
                                                 echo "<td>".$mail."</td>";
                                          echo "</tr>";   
                                   } 
                            }
                            
                     //}

                     function searchUsersForTeachers($req){
                            global $course;
                            global $data;
                            
                            $student = $data->query("SELECT * FROM users WHERE index_number='$req'");
                            $student->setFetchMode(PDO::FETCH_OBJ);
                            $student = $student->fetch();

                            if(!empty($student)){
                                   $first_name = $student->first_name;
                                   $last_name = $student->last_name;
                                   $mail = $student->mail;
                                   $index = $student->index_number;
                                   $courseNum = $student->course;
                                   $courseName = $course[$courseNum];

                                   echo "<tr>";
                                                 echo "<td>".$first_name." ".$last_name."</td>";
                                                 echo "<td>".$index."</td>";
                                                 echo "<td>".$courseName->courseName."</td>";
                                                 echo "<td>".$mail."</td>";
                                   echo "</tr>";   
                                   echo "<button type='button' onclick='redirectToStudents()' style='height:30px; width:120px; margin-bottom:10px;'><- List students</button>";
                            }else{
                                   echo "<td colspan='5' style='text-align:center;'>Student with index number ".$req." does not exists!</td>";
                                   echo "<button type='button' onclick='redirectToStudents()' style='height:30px; width:120px; margin-bottom:10px;'><- List students</button>";
                            }           
                     }
?>
       <script>
              function redirectToStudents(){
                     window.location.href = "../main/users_information.php";
              }
       </script>
<?php

                     $grades = $data->query("SELECT * FROM grades WHERE teacher = '$user_id' ORDER BY date_added");
                     $grades->setFetchMode(PDO::FETCH_OBJ);
                     $grades = $grades->fetchAll();

                     $studentGrades = $data->query( "SELECT * FROM grades WHERE student='2015/000103' ");  
                     $studentGrades->setFetchMode(PDO::FETCH_OBJ);
                     $studentGrades = $studentGrades->fetchAll();

                     function showGrades(){
                            global $grades;
                            global $data;
                            global $studentGrades;

                            if($user_role == 3){
                                   for($i=0; $i<count($grades);$i++){

                                          //GRADES
                                          $student = $grades[$i]->student;
                                          $class_id = $grades[$i]->class; 
                                          $grade = $grades[$i]->grade;
                                          $points= $grades[$i]->points;
                                          $date = $grades[$i]->date_added;
                                          
                                          //STUDENTS
                                          $student = $data->query("SELECT * FROM users WHERE index_number = '$student'");
                                          $student->setFetchMode(PDO::FETCH_OBJ);
                                          $student = $student->fetch();

                                          $first_name = $student->first_name; 
                                          $last_name = $student->last_name;
                                          $index = $student->index_number;
                                          
                                          $class = $data->query("SELECT * FROM classes WHERE class_id = '$class_id'");
                                          $class->setFetchMode(PDO::FETCH_OBJ);
                                          $class = $class->fetch();
                                          $class_name=$class->class_name;
       
                                          echo "<tr>";
                                                 echo "<td>".$first_name." ".$last_name."</td>";
                                                 echo "<td>".$index."</td>";
                                                 echo "<td>".$class_name."</td>";
                                                 echo "<td>".$grade."</td>";
                                                 echo "<td>".$points."</td>";
                                                 echo "<td>".$date."</td>";
                                           echo "</tr>";      
                                    } 
                            }else{
                                   if(!empty($studentGrades)){
                                          for($i=0;$i<count($studentGrades);$i++){

                                                 $class_id = $studentGrades[$i]->class; 
                                                 $grade = $studentGrades[$i]->grade;
                                                 $points= $studentGrades[$i]->points;
                                                 $date = $studentGrades[$i]->date_added;
                                                 $grade_by = $studentGrades[$i]->teacher;
       
                                                 //CLASS NAME
                                                 $class = $data->query("SELECT * FROM classes WHERE class_id = '$class_id'");
                                                 $class->setFetchMode(PDO::FETCH_OBJ);
                                                 $class = $class->fetch();
                                                 $class_name=$class->class_name;

                                                 //TEACHER NAME
                                                 $teacherName = $data->query("SELECT * FROM users WHERE userID = '$grade_by'");
                                                 $teacherName->setFetchMode(PDO::FETCH_OBJ);
                                                 $teacherName = $teacherName->fetch();
                                                 $teacher=$teacherName->first_name." ". $teacherName->last_name;

                                                        echo "<tr>";
                                                               echo "<td>".$class_name."</td>";
                                                               echo "<td>".$teacher."</td>";
                                                               echo "<td>".$grade."</td>";
                                                               echo "<td>".$points."</td>";
                                                               echo "<td>".$date."</td>";
                                                        echo "</tr>";   
                                          }
                                          
                                   }else{
                                          echo "<tr>";
                                                 echo "<td colspan='6' style='text-align:center;'>There is no grades yet!</td>";
                                          echo "</tr>";
                                   }
                                   
                            }
                     }