<!-- needs data store process-->
<?php
include_once('../db.php');

$sql = "
     INSERT INTO topic
       (nickname, title, description,created,viewed,user_id)
       VALUES(
            '{$_POST['nickname']}',
           '{$_POST['subject']}',
           '{$_POST['content']}',
           now(),
           0,
           '{$_POST['user_id']}'
       )
   ";

$result = mysqli_query($conn, $sql);
if ($result === false) {
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
    echo "window.location.replace('community.php?page=1&list=10');</script>";
    error_log(mysqli_error($conn));
    exit;
}
?>
<meta http-equiv="refresh" content="0;url=community.php?page=1&list=10"/>
