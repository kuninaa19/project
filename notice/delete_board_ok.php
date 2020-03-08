<!-- needs data store process-->
<?php
include_once('../db.php');

$number = $_GET['id'];

$sql = "DELETE FROM notice WHERE id = $number";

$result = mysqli_query($conn, $sql);
if ($result == false) {
    header("Content-Type: text/html; charset=UTF-8");
    //   echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
    echo "window.location.replace('notice.php?page=1&list=10');</script>";
    print(mysqli_error($conn));
    exit;
}
?>
<meta http-equiv="refresh" content="0;url=notice.php?page=1&list=10"/>
