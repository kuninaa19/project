<?php
include_once('../db.php');

if (isset($_POST["action"])) {
    //아이디 찾기
    if ($_POST["action"] == "findID") {

        $sql = "SELECT * from user WHERE email = '{$_POST["info"]}'";

        $result = mysqli_query($conn, $sql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

        if ($result->num_rows > 0) { //참이라면 이미 이메일 존재=> 아이디찾기가능한 이메일
            $row = mysqli_fetch_array($result);

            // 맨뒤 2자리 **로 수정
            $value = substr($row['id'], 0, -2) . "**";

            echo $value;

        } else {
            //이메일 생성가능
            $emailRule = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST["info"]);

            if ($emailRule != true) { // 이메일정규식에 부합하지않은 이메일(참)
                echo "wrongEmail";
            } else {
                echo "invalidateEmail";
            }
        }
    } // 비밀번호 찾기
    else if ($_POST["action"] == "findPW") {
        //아이디 검증부터 실행
        $sql = "SELECT * from user  WHERE id = '{$_POST["idValue"]}'";

        $result = mysqli_query($conn, $sql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

        if ($result->num_rows > 0) { //참이라면 이미 아이디 존재=> 이메일 검증실시

            $emailSql = "SELECT * from user  WHERE id = '{$_POST["idValue"]}' AND email = '{$_POST["emailValue"]}'";

            $result = mysqli_query($conn, $emailSql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

            if ($result->num_rows > 0) { // 참이라면 이미 이메일 존재=> 비밀번호 랜덤 변경
                include 'tempPW.php'; // 임시비밀번호만들고 비밀번호 변경

                $temp = passwordGenerator($length = 12); //랜덤생성된 문자열 출력

                $modSql = "UPDATE user SET password = '{$temp}' WHERE id = '{$_POST["idValue"]}'";

                $result = mysqli_query($conn, $modSql);

                if ($result === false) {
                    header("Content-Type: text/html; charset=UTF-8");
                    //   echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
                    echo "window.location.replace('user_pw_find.php');</script>";
                    print(mysqli_error($conn));
                    exit;
                }

                include 'sendmail.php';
                // $config=array(
                // 'host'=>'ssl://smtp.gmail.com',
                // 'smtp_id'=>'example@gmail.com',
                // 'smtp_pw'=>'password',
                // 'debug'=>1,
                // 'charset'=>'utf-8',
                // 'ctype'=>'text/plain'
                // );

                // $sendmail = new Sendmail($config);

                /* 클래스 객체 변수 선언 */
                $sendmail = new Sendmail();
                /* + $to : 받는사람 메일주소 ( ex. $to="hong <hgd@example.com>" 으로도 가능)
                + $from : 보내는사람 이름 +
                 $subject : 메일 제목 +
                 $body : 메일 내용 +
                 $cc_mail : Cc 메일 있을경우 (옵션값으로 생략가능)
                 + $bcc_mail : Bcc 메일이 있을경우 (옵션값으로 생략가능) */

                $to = $_POST["emailValue"];
                $from = "ITdream";
                $subject = "ITdream에서 임시발급된 비밀번호입니다.";
                $body = "사용자의 요청으로 ITdream에서 임시 비밀번호가 발급되었습니다. \n 로그인후 비밀번호를 변경해주세요.\n\n임시비밀번호 : $temp ";

                /* 메일 보내기 */

                $sendmail->send_mail($to, $from, $subject, $body);

                echo "exist";
            } else { // 아이디 존재 이메일 안맞음
                echo "existId";
            }
        } else { // 아이디 안맞음 => 이메일 검증
            $emailSql = "SELECT * from user  WHERE email = '{$_POST["emailValue"]}'";

            $result = mysqli_query($conn, $emailSql); //mysqli_query실행은 실행되기만하면 무조건 true 진행

            if ($result->num_rows > 0) { // 참이라면 이메일 존재=> 아이디 안맞고 이메일 맞음
                echo "existEmail";
            } else { // 이메일 안맞음=> 아이디 이메일 정보둘다 안맞음
                echo "notExist";
            }
        }
    } else {
        echo "관리자에게 문의해주세요";
    }
}
?>