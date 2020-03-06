<?php
include_once('../db.php');

if (isset($_POST["action"])) {
    //아이디 중복확인
    if ($_POST["action"] == "id") {

        $sql = "SELECT * from user WHERE id = '{$_POST["info"]}'";

        $result = mysqli_query($conn, $sql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

        if ($result->num_rows > 0) { //참이라면 이미 아이디 존재=> 만들수없는 아이디

            echo "existID";
        } else {
            //아이디 생성가능
            echo "possibleID";
        }
    } // 이메일 중복확인
    else if ($_POST["action"] == "email") {
        $sql = "SELECT * from user  WHERE email = '{$_POST["info"]}'";

        $result = mysqli_query($conn, $sql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

        if ($result->num_rows > 0) { //참이라면 이미 이메일 존재=> 만들수없는 이메일
            echo "existEmail";
        } else {
            //이메일 생성가능
            $emailRule = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST["info"]);

            if ($emailRule != true) {
                echo "wrongEmail";
            } else {
                echo "possibleEmail";
            }
        }
    } // 닉네임 중복확인
    else if ($_POST["action"] == "nick") {
        $sql = "SELECT * FROM user WHERE nickname = '{$_POST['info']}'";

        $result = mysqli_query($conn, $sql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

        if ($result->num_rows > 0) { //참이라면 이미 닉네임 존재=> 만들수없는 닉네임

            echo "existNick";
        } else {
            //닉네임 생성가능
            echo "possibleNick";
        }

    } else {
        echo "관리자에게 문의해주세요";
    }
}
?>