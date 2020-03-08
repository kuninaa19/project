<!-- needs data store process-->
<?php
session_start();
include_once('../../db.php');


$html = $_POST['content'];
preg_match("/<img[^>]*src=[']?([^>']+)[']?[^>]*>/", $html, $img);


$sql = "
     INSERT INTO unboxing
       (nickname, title, description,video,created,viewed,user_id,sumnail)
       VALUES(
            '{$_POST['nickname']}',
           '{$_POST['subject']}',
           '{$_POST['content']}',
           '{$_POST['video']}',
           now(),
           0,
           '{$_SESSION['user_id']}',
           '{$img[1]}'
       )
   ";

$result = mysqli_query($conn, $sql);
if ($result == false) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
    echo "window.location.replace('unboxing.php?page=1&list=10');</script>";
    error_log(mysqli_error($conn));
    exit;
}
?>
<meta http-equiv="refresh" content="0;url=unboxing.php?page=1&list=10"/>
