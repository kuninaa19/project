<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITdream</title>
    <link rel="stylesheet" href="../css/bootstrap.css"/>
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<br>
<div class="container">
    <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
    </div>
    <dt><p style="margin-top:30px; text-align: center; font-size : 20px;">개인 정보 보호를 위해 비밀번호를 입력해주세요</p></dt>

    <div class="box">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <form method="post" action="pw_check.php">
                <fieldset>
                    <p><input type="password" name="user_pw" placeholder="비밀번호" class="info-form"/></p>
                    <input type="hidden" name="user_id" value=<?= $_SESSION['user_id'] ?>>
                    <?php
                    $i = $_GET['form'];
                    switch ($i) {
                        case 1:
                            ?>
                            <input type="hidden" name="ck" value="1">
                            <p><input type="submit" value="확인" class="button-form" id="button-color"/></p><?php
                            break;

                        case 2:
                            ?>
                            <input type="hidden" name="ck" value="2">
                            <p><input type="submit" value="확인" class="button-form" id="button-color"/></p><?php
                            break;

                        case 3:
                            ?>
                            <input type="hidden" name="ck" value="3">
                            <p><input type="submit" value="확인" class="button-form" id="button-color"/></p><?php
                            break;
                    }
                    ?>
                </fieldset>
            </form>
        <?php } else {
            echo "<a href='../index.php'>[돌아가기]</a> ";
        } ?>
    </div>
</div>
</body>
</html>