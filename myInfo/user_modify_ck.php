<?php
include_once('../db.php');

if (isset($_POST["action"])) {
    //닉네임 변경
    if ($_POST["action"] == "changeNick") {

        $sql = "SELECT * from user WHERE nickname = '{$_POST["info"]}'";

        $result = mysqli_query($conn, $sql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

        if ($result->num_rows > 0) { //참이라면 이미 닉네임 존재=> 만들수없는 닉네임

            echo "existNick";
        } else {
            //닉네임 생성가능
            echo "possibleNick";
        }
    } // 비밀번호 변경
    else if ($_POST["action"] == "changePW") {
        //아이디 검증부터 실행
        $sql = "SELECT * from user  WHERE (id = '{$_SESSION["user_id"]}' AND 'password' = '{$_POST["info"]}')";


        $result = mysqli_query($conn, $sql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

        if ($result->num_rows > 0) { //참이라면 동일 비밀번호

            echo "existPW";
        } else {
            //비밀번호 사용가능
            echo "possiblePW";
        }
    } else {
        echo "관리자에게 문의해주세요";
    }
}
?>