<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITdream</title>
    <link rel="stylesheet" href="../css/bootstrap.css"/>
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
</head>
<body>
<br>
<script src="../js/myInfo/userIdFind.js"></script>

<div class="container">
    <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
    </div>
    <h3 class="banner">아이디 찾기</h3>

    <div class="box">
        <form method="post" name="findID">
            <fieldset>
                <h4 style="margin-left:30px;">가입시 등록한 메일주소를 입력해주세요.</h4>
                <p><input type="text" name="email" placeholder="이메일" class="info-form"/></p>
                <span class="error_box" id="emailSpan" style="color:red"></span><br/>
                <p><input type="button" value="확인" class="button-form" id="button-color" onclick="validateEmail(email.value)"/></p>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>