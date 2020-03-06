<!-- needs data store process-->
<?php session_start(); ?>

<?php
include_once ('../db.php');


$process = $_POST['process'];
    
    // 닉네임 변경
    if($process=="nick"){
        $nickname= $_POST['nickname'];
      
    $sql = "UPDATE user SET nickname = '{$nickname}' WHERE id = '{$_SESSION['user_id']}'";

      $result = mysqli_query($conn, $sql);
        if($result == false){
        echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
        echo "window.location.replace('user_modify.php&form=1');</script>";
        error_log(mysqli_error($conn));
        exit;
    
        } else {
            if(isset($_COOKIE["id"])||isset($_COOKIE["nickname"])){
                unset($_COOKIE["id"]);
                unset($_COOKIE["nickname"]);
                setcookie('id', null, -1, '/');
                setcookie('nickname', null, -1, '/');
             }
             $_SESSION['user_name']=$nickname;
             session_start();
             echo "<script>location.replace('index.php')</script>";
            //  echo "<script>alert('닉네임 변경 완료!');"; 안됨
        }
    }
    // 패스워드 변경
    else if($process=="pass"){
        $password= $_POST['pw2'];

        $sql = "UPDATE user SET password = '{$password}' WHERE id = '{$_SESSION['user_id']}'";
        
        $result = mysqli_query($conn, $sql);

        if($result === false){
        header("Content-Type: text/html; charset=UTF-8");
        //   echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
          echo "window.location.replace('user_modify.php&form=2');</script>";
          print(mysqli_error($conn));
          exit;
        }

        if(isset($_COOKIE["id"])||isset($_COOKIE["nickname"])){
            unset($_COOKIE["id"]);
            unset($_COOKIE["nickname"]);
            setcookie('id', null, -1, '/');
            setcookie('nickname', null, -1, '/');
         }
         echo "<script>location.replace('index.php')</script>";

    }
    //회원탈퇴
    else if($process=="out"){
        $sql = "DELETE FROM user WHERE id ='{$_SESSION['user_id']}'";
        
        $result = mysqli_query($conn, $sql);
        if($result === false){
        header("Content-Type: text/html; charset=UTF-8");
        //   echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
          echo "window.location.replace('user_modify.php&form=3');</script>";
          print(mysqli_error($conn));
          exit;
        }

        session_destroy();

        if(isset($_COOKIE["id"])||isset($_COOKIE["nickname"])){
            unset($_COOKIE["id"]);
            unset($_COOKIE["nickname"]);
            setcookie('id', null, -1, '/');
            setcookie('nickname', null, -1, '/');
         }
         echo "<script>location.replace('index.php')</script>";
    }
?>