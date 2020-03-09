<?php
if (!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;

include_once('../db.php');

$id = $_POST['user_id'];
$pw = $_POST['user_pw'];

$sql = "SELECT * FROM user WHERE id='{$id}'";

$result = mysqli_query($conn, $sql);
if ($result === false) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('관리자에게 문의해주세요');";
    echo "window.location.replace('login.php');</script>";
    error_log(mysqli_error($conn));
    exit;
} else {
    $row = mysqli_fetch_array($result);
    //id auth
    if ($row['id'] == $id) {
        //pw auths
        if ($row['password'] == $pw) {
            $_SESSION['user_id'] = $row['id']; //로그인 성공 시 세션 변수 만들기
            $_SESSION['user_name'] = $row['nickname']; //로그인 성공 시 세션 변수 만들기

            if (isset($_SESSION['user_id']) && isset($_SESSION['user_name']))    //세션 변수가 참일 때
            {

                if (isset($_POST['auto_login'])) {

                    include '../crypt.php';
                    $encrypted1 = Encrypt($row['id'], $secret_key, $secret_iv);
                    $encrypted2 = Encrypt($row['nickname'], $secret_key, $secret_iv);

                    setcookie("id", $encrypted1, time() + 86400 * 7);
                    setcookie("nickname", $encrypted2, time() + 86400 * 7);
                }
//                $encrypted3 = Encrypt($row['id'], $secret_key, $secret_iv);
//                $cook = setcookie("chat", $row['id'], time() + 10800); // 3시간 유효 쿠키 생성

                session_start();
                $_SESSION['user_id'] = $row['id']; //로그인 성공 시 세션 변수 만들기
                $_SESSION['user_name'] = $row['nickname']; //로그인 성공 시 세션 변수 만들기
                $_SESSION['cnt_list'];

                echo "<script>location.href='../index.php'</script>";   //로그인 성공 시 페이지 이동
            } else {
                header("Content-Type: text/html; charset=UTF-8");
                echo "<script>alert('관리자에게 문의해주세요');";
                echo "window.location.replace('login.php');</script>";
                error_log(mysqli_error($conn));
                exit;
            }
        } //pw wrong
        else {
            header("Content-Type: text/html; charset=UTF-8");
            echo "<script>alert('잘못된 비밀번호입니다.');";
            echo "window.location.replace('login.php');</script>";
            error_log(mysqli_error($conn));
            exit;
        }
    } else {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('존재하지않는 회원아이디 입니다.');";
        echo "window.location.replace('login.php');</script>";
        exit;
    }
}
?>

