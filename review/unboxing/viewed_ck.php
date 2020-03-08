<?php
$board_name = "unboxing";

$number = $_GET['id'];

$_dummy = $_SESSION['cnt_list'];
$cnt_list_dummy = explode(";", $_dummy);

$board_cnt_ok = 0;

for ($i = 0; $i < sizeof($cnt_list_dummy); $i++) {
    if ($cnt_list_dummy[$i] == $board_name . "_" . $number) {
        $board_cnt_ok = 1;
        break;
    }
}
if ($board_cnt_ok == 0) {

    mysqli_query($conn, "UPDATE unboxing SET viewed=viewed+1 where id=$number");

    $cn = ";" . $board_name . "_" . $number;

    $_SESSION['cnt_list'] .= $cn;
    session_start(); // 세션을 수정했다면 변경된 내용을 저장해줘야함.
}
//
//echo $_SESSION['user_name'];
//echo $_dummy;
$sql = "SELECT * FROM unboxing WHERE id=$number";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
?>