<?php 
          if(!isset($_SESSION['user_id'])||!isset($_SESSION['user_name'])) {
            echo " <a href=\"../SignUp.php\">회원가입</a>";
         } else {
             $user_id = $_SESSION['user_id'];
             $user_name = $_SESSION['user_name'];

             
             echo "<a href=\"../user_info.php\">내정보</a></p>";
         }
        ?>