<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITdream</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css"/>
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<br>
<script src="../js/myInfo/userPwFind.js"></script>
<div class="container">
    <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px"
                                                              height="50px"></a></div>
    </div>
    <h3 class="banner">비밀번호 찾기</h3>

    <div class="box">
        <form method="post" name="findEmail">
            <fieldset>
                <h3 style="margin-left:30px; font-weight: bold;">임시비밀번호 받기</h3>
                <hr>
                <h5 style="margin-left:30px;">가입시 등록한 <span style="color:red;">아이디와 메일주소</span>를 입력해주세요. </h5>

                <p><input type="text" name="userID" placeholder="아이디" class="info-form"/></p>
                <span class="error_box" id="idSpan" style="color:red"></span><br/>
                <p><input type="text" name="email" placeholder="이메일" class="info-form"/></p>
                <span class="error_box" id="emailSpan" style="color:red"></span><br/>
                <p><input type="button" value="임시 비밀번호 받기" class="button-form" id="button-color"
                          onclick="validateUser(userID.value,email.value)"/></p>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>