<!-- needs data store process-->
<?php
    $conn = mysqli_connect("localhost", "minchan", "Abzz4795!", "myWeb");
   $sql = "
   INSERT INTO user
     (id, password, email,nickname)
     VALUES(
         '{$_POST['id']}',
         '{$_POST['pw']}',
         '{$_POST['email']}',
         '{$_POST['nickname']}'
     )
 ";

$result = mysqli_query($conn, $sql);
 if($result === false){
    header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
        echo "window.location.replace('login.php');</script>";
        error_log(mysqli_error($conn));
        exit;
    
 } else {
  header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('회원가입 완료!');";
        echo "window.location.replace('index.php');</script>";
 }
?>
<!-- <meta http-equiv="refresh" content="0;url=index.php" /> -->
