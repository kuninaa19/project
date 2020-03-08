<?php
$board_name = "review";
$number = $_GET['id'];

$_dummy = $_SESSION['cnt_list'];
$cnt_list_dummy = explode(";", $_dummy);

$board_cnt_ok = 0;

for ($i = 0; $i < sizeof($cnt_list_dummy); $i++) {
    if ($cnt_list_dummy[$i] == $board_name . "_" . $number)
    {
        $board_cnt_ok = 1;
        break;
    }
}
if ($board_cnt_ok == 0)
{

    mysqli_query($conn, "UPDATE review SET viewed=viewed+1 where id=$number");

    $cn = ";" . $board_name . "_" . $number;

    $_SESSION['cnt_list'] .= $cn;
    session_start(); // 세션을 수정했다면 변경된 내용을 저장해줘야함.
}
function Console_log($data)
{
    echo "<script>console.log( '유저조회내역: " . $data . "' );</script>";
}

// Console_log($_dummy);

$sql = "SELECT * FROM review WHERE id=$number";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
?>