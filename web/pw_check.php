<?php
if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
$conn = mysqli_connect("localhost", "minchan", "Abzz4795!", "myWeb");
$id=$_POST['user_id'];
$pw=$_POST['user_pw'];
$ck=$_POST['ck'];
$sql="SELECT * FROM user WHERE id='{$id}'";

$result = mysqli_query($conn, $sql);
if($result === false){
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('관리자에게 문의해주세요');";
    echo "window.location.replace('login.php');</script>";
    error_log(mysqli_error($conn));
    exit;
 }
 else{
    $row=mysqli_fetch_array($result);
    //id auth
    if($row['id']==$id){
        //pw auths
        if($row['password']==$pw){
            switch($ck){
                case 1:
                    echo "<script>location.href='user_modify.php?form=$ck'</script>";   //로그인 성공 시 페이지 이동

                exit;
                break;
                case 2:
                    echo "<script>location.href='user_modify.php?form=$ck'</script>";   //로그인 성공 시 페이지 이동
  
                    exit;
                break;
                case 3:
                    echo "<script>location.href='user_modify.php?form=$ck'</script>";   //로그인 성공 시 페이지 이동
          
                    exit;
                break;
            }
        }
        //pw wrong
        else{
            header("Content-Type: text/html; charset=UTF-8");
            echo "<script>alert('잘못된 비밀번호입니다.');";
            echo "window.location.replace('pw.php?form=$ck');</script>";
            error_log(mysqli_error($conn));
            exit;
        }
    }
    else{
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('존재하지않는 회원아이디 입니다.');";
        echo "window.location.replace('index.php');</script>";
        exit;
    }
   
 }
?>

