<!DOCTYPE html>
<?php session_start(); ?>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ITdream</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/bootstrap-theme.css"/>
  <link rel="stylesheet" href="../css/bootstrap.css"/>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <link href="../css/style.css?" rel="stylesheet" type="text/css" />
</head>
    <body>
    <br>
    <div class="container">
        <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
        </div>
        <h3 class="banner">나의 정보</h3>
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
  
 ?>
      <fieldset>
            <b class="txt_sign">아이디</b><br /><input type="text" class="info-form" name="id" value=<?=$row['id']?> disabled><br />
            
            <b class="txt_sign">닉네임</b><br /><input type="text" class="info-form" name="nickname" value=<?=$row['nickname']?> disabled><br />

            <b class="txt_sign">이메일</b><br /><input type="text" class="info-form" name="email" value=<?=$row['email']?> disabled><br /><p style="margin-bottom:30px"></p>
            
            </fieldset>
        
        <?php }?>
        
        <?php } else {
            echo "<a href='../index.php'>[돌아가기]</a> ";
        } ?>
        <span>
        <button type="button" class="btn btn-primary" onClick="location.href='pw.php?form=1'" style="margin-left:30px">닉네임변경</button>
               
        <button type="button" class="btn btn-primary"onClick="location.href='pw.php?form=2'" style="margin-left:50px">비밀번호변경</button>
        
        <button type="button" class="btn btn-primary" onClick="location.href='pw.php?form=3'" style="margin-left:45px">회원탈퇴</button>
        </span>
        
     </div>
</div>
</body>
</html>