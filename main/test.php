
<?php
include 'conf.php';
include 'simple_html_dom.php';
require_once 'functions.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Document</title>

       <script>
                     $(function(){
                     $('#datepicker').datepicker({
                            dateFormat: 'd M, yy',
                            inline: true,
                            showOtherMonths: true,
                            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                     });
              });
              </script>
</head>
<body>
       <input type="text" id="datepicker">
</body>
</html>






<?php

/*<div class="delete-warning id="delete-warning">
                            <p></p>
                            <form action="" method="POST">
                                   <input type="submit" value="Yes" name="delete">
                                   <input type="submit" value="No" name="dont-delete">
                            </form>
                     </div>

                     <div id="warning-bg">
                     </div>*/

                     ?>