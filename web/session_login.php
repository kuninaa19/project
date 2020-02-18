<?php
             if(!isset($_SESSION['user_id'])||!isset($_SESSION['user_name'])) {
              echo " <a href=\"../login.php\">로그인</a>";
           } else {
               $user_id = $_SESSION['user_id'];
               $user_name = $_SESSION['user_name'];
               
               echo "<a href=\"../logout.php\">로그아웃</a></p>";
           }
        ?>