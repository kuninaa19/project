
<?php
session_start();
@Header("Access-Control-Allow-Origin: *");
@Header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
@Header("Access-Control-Allow-Headers:orgin, x-requested-with");

header("content-type:text/html; charset=utf-8");

$callback  = $_REQUEST['callback'];

if(!isset($_COOKIE["chat"])) {
    
    $returnMsg = "로그인후 이용해주세요";

    echo $callback."(".json_encode($returnMsg).")";

}

else {

    echo $callback."(".json_encode($_COOKIE["chat"]."|".$_SESSION['user_name']).")";

}


// // request이용한 값가져오기(세션)
// $conn = mysqli_connect('localhost', 'minchan', 'Abzz4795!', 'myWeb');
//     session_start();
//     $returnMsg = "로그인후 이용해주세요";

//     // $id="fafa2";
//     //nodejs에서 php세션값 가져올수없음    
//     $id=$_SESSION['user_name'];
    

//     $sql="SELECT * FROM user WHERE nickname='{$id}'";
//     $result = mysqli_query($conn,$sql);
//     $row=mysqli_fetch_array($result);

//     $enc_data =  $row['nickname'];

    // echo $returnMsg."|".$_COOKIE["chat"];


// // request이용한 값가져오기(쿠키)

//   include 'crypt.php';
//   $enc_data = Decrypt($_COOKIE["chat"], $secret_key, $secret_iv);
  
//       $returnMsg = "로그인후 이용해주세요";
  
//       if($enc_data!= " "){
//         $conn = mysqli_connect("localhost", "minchan", "Abzz4795!", "myWeb");
//      $sql = "
//      INSERT INTO ckLogin
//        (ckLogin, userID)
//        VALUES(
//            now(),
//            '{$_SESSION['user_name']}'
//        )
//    ";
   
//   $result = mysqli_query($conn, $sql);
//    if($result === false){
//       header("Content-Type: text/html; charset=UTF-8");
//           echo "<script>alert('저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요');";
//           echo "window.location.replace('notice.php?page=1&list=10');</script>";
//           error_log(mysqli_error($conn));
//           exit;
//    }
//    else{
//     echo $returnMsg."|".$_COOKIE["chat"];
//     }
//   }
//   else{
//     echo $returnMsg."|"."44";

//   }
?>