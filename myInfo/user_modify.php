<!DOCTYPE html>
<?php session_start();
?>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ITdream</title>
  <link rel="stylesheet" href="../css/bootstrap.css"/>
  <link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
    <body>
    <br>
       <div class="container">
        <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
        </div>
        <?php
        $i=$_GET['form'];
            switch($i){
            case 1:
         ?>
        <h3 class="banner">나의 정보 변경</h3><?php
            break;
            case 2:
        ?>
        <h3 class="banner">비밀번호 변경</h3><?php
            break;
            case 3:
        ?>
        <h3 class="banner">회원탈퇴</h3><?php
         }?>
       
        <div class="box">
        <?php if(isset($_SESSION['user_id'])) {

            include_once ('../db.php');

            $sql="SELECT * FROM user WHERE id='{$_SESSION['user_id']}'";

            $result = mysqli_query($conn, $sql);
            if($result === false){
            header("Content-Type: text/html; charset=UTF-8");
            echo "<script>alert('관리자에게 문의해주세요');";
            echo "window.location.replace('../index.php');</script>";
            error_log(mysqli_error($conn));
            exit;
            }
            else{
                $row=mysqli_fetch_array($result);
                $i=$_GET['form'];

            switch($i){

            case 1: //닉네임변경
         ?>
         <form method="post" action="user_modify_check.php" name="nickForm">
            <fieldset>
            <b class="txt_sign">아이디</b><br /><input type="text" class="info-form" name="id" value=<?=$row['id']?> disabled><p><br/>
            <b class="txt_sign">닉네임</b><br /><input type="text" class="info-form" name="nickname" value=<?=$row['nickname']?> onblur="validateNickname(this.value)"><p>
            <span class="error_box" id="nickSpan"></span> <br/><p>
            <b class="txt_sign">이메일</b><br /><input type="text" class="info-form" name="email" value=<?=$row['email']?> disabled><br/></p>
            <input type="hidden" name="process" value="nick"> 

            <input type="button" class="button-form" id="button-color" onclick="placeOrder(this.form,1)" value="확인">
            </fieldset>
            </form>
            <?php
            break;
            
            // 비밀번호 변경
            case 2: ?> 
            <form method="post" action="user_modify_check.php" name="passForm">
            <fieldset>
            <b class="txt_sign">새 비밀번호</b><br /><input type="password" class="info-form" name="pw" onblur="validatePassword(this.value)"><br />
            <span class="error_box" id="passwordSpan"></span><br/><p></p>
            <b class="txt_sign">새 비밀번호 확인</b><br /><input type="password" class="info-form" name="pw2" onblur="validatePassword2(pw.value,this.value)"><br />
            <span class="error_box" id="password2Span"></span><br/>
            <input type="hidden" name="process" value="pass"> 

            <input type="button" class="button-form" id="button-color"  onclick="placeOrder(this.form,2)" value="확인">
            </fieldset>
            </form>
            <?php
            break;

            //회원탈퇴
            case 3: ?>
            <form method="post" action="user_modify_check.php">
            <fieldset>
            <b class="txt_sign">정말로 회원탈퇴하시겠습니까?</b><br /><b class="txt_sign" style="color:#DF0101;">회원탈퇴시 모든 정보가 삭제됩니다.</b><br />
            
            <input type="hidden" name="process" value="out"> 
            <input type="submit" class="button-form" id="button-color" value="확인">
            </fieldset>
            </form>
        <?php }
            } 
        }?>
    <!-- script는 클라이언트실행 php서버실행 -->
            <script src="../js/myInfo/userModify.js"></script>
    <script>
        function validateNickname(value) { // 닉네임 검증
            var alphaSmall =/[a-z]/;
            var alphaBig=/[A-Z]/;
            var specialCharacter=/[^A-Za-zㄱ-힣0-9-]/; // 특수문자, 공백 검증
            var korean=/^[가-힣]+$/; // 한글
            var english=/^[A-z]+$/; // 영어
            checkNameRule=false;

            var original = <?php echo json_encode($row['nickname']); ?>; // 기존닉네임 정보 저장

            document.getElementById("nickSpan").style="color:red";

            //이름 검증 시작 (DB검색하지않고 순수하게 정보처리)
            // console.log(value);

            if(value == original){
                document.getElementById("nickSpan").innerHTML="기존 닉네임과 다르게 입력해주세요";
            }else{
                if(value.length<2 || value.length>6)
                    document.getElementById("nickSpan").innerHTML="2자리 ~ 6자리글자내로 입력해주세요";
                else if(specialCharacter.test(value))
                    document.getElementById("nickSpan").innerHTML="한글또는 영문을 사용하세요. (특수기호, 공백 사용 불가)";
                else {
                    send("user_modify_ck.php", value,"changeNick");   // 닉네임 중복을 위해 send(url, id)메소드 실행
                }
            }
        }
    </script>
     </div>
</div>
</body>
</html>