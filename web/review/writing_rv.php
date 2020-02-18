<?php
    session_start();
    $conn = mysqli_connect("localhost", "minchan", "Abzz4795!", "myWeb");
    $number= $_GET['id'];

    $board_name = "review"; //이것은 게시판들의 중복을 막기위한 값입니다. (게시판 이름)
    //예를들어 자유게시판 1번글을 읽었는데
    //공지사항 1번글을 읽었을때도 조회수 중복이 막히면 안돼겠죠??
    $number = $_GET['id']; //이것이 있어야 어떤글을 읽었는지 조사할 수 있겠죠? "게시판글의 고유번호"

    $_dummy= $_SESSION['cnt_list'];
    $cnt_list_dummy = explode(";",$_dummy); //현재 세션에 있는 내용을 조각냅니다.

    $board_cnt_ok = 0; //조회수를 올려도 되는지 저장하는 변수를 초기화합니다.
    
    for($i = 0; $i < sizeof($cnt_list_dummy); $i++)
    {
      if($cnt_list_dummy[$i] == $board_name."_".$number) //조각낸 게시물과 일치하는 세션값이 있는지 검사합니다.
      {
        $board_cnt_ok = 1; //만약 있다면 현재글을 이미 읽다다는 표시를 해둡니다. 저는 0과 1로 표현했어요~
        break; //반복문을 멈춥니다.
      }
    }
    if($board_cnt_ok == 0) //검사한 값에 조회한적이 있는지 검사합니다.
    {
      
    mysqli_query($conn,"UPDATE review SET viewed=viewed+1 where id=$number");

    //만약 이글을 처음 조회하는것이면 아래를 실행합니다.
    /*여기에는 조회수를 +1하는 소스를 넣어두세요.
    프로그램 짜시는 분마다 다르기 때문에 이부분은 생략입니다^^;*/
    $cn = ";".$board_name."_".$number; 
 
    $_SESSION['cnt_list'].=$cn;
    session_start(); // 세션을 수정했다면 변경된 내용을 저장해줘야함.
    }
    function Console_log($data){
      echo "<script>console.log( '유저조회내역: " . $data . "' );</script>";
  }
  
  // Console_log($_dummy);
    
    $sql= "SELECT * FROM review WHERE id=$number";
    $result= mysqli_query($conn,$sql);
    
    $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<?php session_start();?>
<html>
<head>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ITdream</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/bootstrap-theme.css"/>
        <link rel="stylesheet" href="../css/bootstrap.css"/>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <link href="../style.css?ater" rel="stylesheet" type="text/css"/>
</head>
<body>
<br>
<div class="container">
<div class="nav">
      <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
      <div class="nav-right-items">
      <div class="nav-item"><a href="#" onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a></div>
        <div class="nav-item"><a href="review.php">리뷰</a></div>
	    <div class ="nav-item"><a href="../news/news.php?page=1">뉴스</a></div>
        <div class="nav-item"><a href="../community/community.php?page=1&list=10">커뮤니티</a></div>
        <div class="nav-item"><a href="../notice/notice.php?page=1&list=10">공지사항</a></div>
        <div class="nav-item">
        <?php include '../session_login.php' ?>
        </div>
        <div class="nav-item">
        <?php include '../session_signUp.php' ?>
        </div>
      </div>
    </div>

<div class="nav_sub">
    <div class="big-category">리뷰</div> 
    <div class="nav-right-items"></div>
</div>

<table class="table table-bordered">
    <thead>
    </thead>         
        <tr>
          <th class="txt_posi">제목</th>
          <th  colspan="3"class="txt_posi3"><?=$row['title']?></th>
          <th class="txt_posi">조회</th>
          <th class="txt_count"><?=$row['viewed']?></th>
          
        </tr>

        <tr>
          <th class="txt_posi">이름</th>
          <th class="txt_posi2"><?=$row['nickname']?></th>
          <th class="txt_posi">날짜 </th>
          <th class="txt_day"><?=$row['created']?></th>
          <th class="txt_posi">댓글</th>
          <th class="txt_count" id="replyNum"><?=$Count?></th>
        </tr>

        <tr>
          <td colspan="6" class="txt_write"> <?=$row['description']?></td>
        </tr>
      
        <!-- 동영상 -->
        <?php $url = $row['video']; 
          // video주소가 DB에 저장되어있다면
          if($url!=""){
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
            $id = $matches[1]; $width = '80%'; $height = '450px'; 
            echo "<tr>";
            echo "<td colspan='6'>";

            echo "<object width='80%' height='500'>";
              // 화면보여짐
            echo "<iframe id='ytplayer' type='text/html' width='$width' height='$height' src='https://www.youtube.com/embed/$id?rel=0&showinfo=0&color=white&iv_load_policy=3' frameborder='0' allowfullscreen></iframe>";
            echo "</td>";
            echo "</tr>";
          }
          ?> 
      
    </tbody> 
</table>
<hr/>
<!-- declare class setting to "pull-right", maked button reversed -->
<?php
$checking=$_SESSION['user_id'];
    
$admin = "SELECT * FROM super WHERE id='{$checking}'";

$sup = mysqli_query($conn,$admin);
if($sup == TRUE){
    $row1 = mysqli_fetch_array($sup);

    if(isset($row1['id']) && $checking == $row1['id']){
     echo "<a class='btn btn-default pull-right' id= 'btn_margin' onclick='return confirm('정말로 삭제하시겠습니까?')' href='./delete_review.php?id=$number'>삭제</a>";
     echo "<a class='btn btn-default pull-right' href='./update_review.php?id=$number'>수정</a>";
    
     //  관리자인지 검증작업
     $superCk= "SELECT * FROM super WHERE id='{$checking}'";
     $confirm2= mysqli_query($conn,$superCk);
     if($confirm2 == TRUE){
       $super = mysqli_fetch_array($confirm2);
     }
   FUNCTION hello(){
     echo "<script> if (confirm('이 버튼에 대한 동작을 수행합니다. 계속합니까?')) {
       // 확인 버튼 클릭 시 동작
       alert('동작을 시작합니다.');
   } else {
       // 취소 버튼 클릭 시 동작
       alert('동작을 취소했습니다.');
   }
       </script>";
    }
 }
}
?>  

<!-- 댓글 바 -->

<br></br>
  <div style="margin:10px 0px 5px 0px; border-bottom: 1px solid #E6E6E6;"></div>
  <div class="big-category" style="font-size:16px; padding:5px 0px 0px 0px;">댓글
  <div style="display: inline-block" id="replyNum2"><?=$Count?></div></div>
    <div class="nav-right-items"></div>
    <div style="margin-top:5px; border :0.5px solid #E6E6E6;"></div>
    <div class="reply_box">
    
   <!-- 댓글정보 가져오기 -->
<script>
	$(document).ready(function(){
		getAllList();
	});

	var str = "";
  var count = 0;
 
  
  // 댓글 전부 업로드
	function getAllList(){
    
		$.getJSON("reply_list_r.php?board=<?=$number?>", function(data){
			console.log(data);
			$(data).each(function(){
        count+=1;
        
        if(this.user_id == "<?=$_SESSION['user_id']?>") {
          str += "<li class='reply'>"+
                  "<div class='replyText'>"+this.nickname+"<p class='dayfont'>" + this.created+
                    "<p class='replybutton'>"+
                        "<input type='button' name='"+this.id+"' id='update_btn' value='수정'>"+
                            "<div class='replybutton' style='margin-left:20px;'>"+
                          "<input type='button' name='"+this.id+"' id='delete_btn'  value='삭제'>"+
                      "</div>"+
                 "</div>"+
					this.reply + "<div style='display:none' id='user_id'>" + this.user_id+ "</div></li>";
        }
         //슈퍼유저의 댓글 삭제
         else if("<?=$super['id']?>"=="<?=$_SESSION['user_id']?>"){
          str += "<li class='reply'>"+
                  "<div class='replyText'>"+this.nickname+"<p class='dayfont'>" + this.created+
                    "<p class='replybutton'>"+  
                          "<input type='button' name='"+this.id+"' id='delete_btn'  value='삭제'>"+
                 "</div>"+
					this.reply + "<div style='display:none' id='user_id'>" + this.user_id+ "</div></li>";
        }
        else{
          str += "<li class='reply'>"+
                  "<div class='replyText'>"+this.nickname+"<p class='dayfont'>" + this.created+
                  
                      "</div>"+
                 "</div>"+
					this.reply + "<div style='display:none' id='user_id'>" + this.user_id+ "</div></li>";

        }

        
          });
      $("#replys_form").html(str);
      $("#replyNum").html(count);
      $("#replyNum2").html(count);

		  });
      str = "";
      count = 0;
	}


// 댓글 수정하기
  $(document).on("click", "#update_btn", function() {
		
    var id = $(this).attr("name");

    var info = { "replyNum":id, "action": "getInfo"};

		$.ajax({
			type : 'POST',
			url : 'reply_r_ok.php',
			data : info,
			success : function(data){
        var res = $.parseJSON( data );
        console.log(res.id);

      $('textarea').val(res.reply);
      $('#send_btn').html(res.id);
      $('#send_btn').val("수정");
      $('#send_btn').attr('id','change_btn');

       
			}
		});
    });
    
    // 댓글 삭제
    $(document).on("click", "#delete_btn", function() {

      var id = $(this).attr("name");

    var info = { "replyNum":id, "action": "delete"};
    console.log(info);

		$.ajax({
			type : 'POST',
			url : 'reply_r_ok.php',
			data : info,
			success : function(data){
        
        if($('#replys_form').empty()){
          getAllList();
          $('textarea').val('');
        }
			}
		});
    });
    // 수정된 댓글 전송
  $(document).on("click", "#change_btn", function() {
    
    if(!checkMemo()){
    zeroMemo();
    var id = $('#change_btn').text();

    console.log(id);
    var text = $('textarea').val();
    console.log(text);


    var info = { "replyNum":id,"reply":text, "action": "update"};
		$.ajax({
			type : 'POST',
			url : 'reply_r_ok.php',
			data : info,
			success : function(data){
        
        if($('#replys_form').empty()){
          getAllList();
          $('textarea').val('');
          $('#change_btn').html('');
          $('#change_btn').val("등록");
          $('#change_btn').attr('id','send_btn');
          
              }
	      		}
          });
        }
    });

  // 댓글 전송
	$(document).on("click", "#send_btn", function() {
    
    if(!checkMemo()){
      zeroMemo();

		var formData = $("#reply_form").serialize();

		$.ajax({
			type : 'POST',
			url : 'reply_r_ok.php',
			data : formData,
			success : function(data){
        
        if($('#replys_form').empty()){
          getAllList();
          $('textarea').val('');
             }
      			}
         });
       }
    });
</script> 

      <ul class="replylist" id="replys_form">
      </ul>
    </div>

    <?php if(isset($_SESSION['user_id'])) {?>
      

    <div class="chat_box">
      <!-- 글자수제한 및 엔터 제한 -->
    <script type="text/javascript">

          //댓글이 입력되었는지 확인
        function checkMemo() {
          if (!document.getElementById('textarea').value){
            alert("댓글을 입력해 주세요.");
            document.getElementById('textarea').focus();
            return true;
          }
          else{
           subEle = document.getElementById('textarea').value;
                    
           if($.trim(subEle)==""){ //앞뒤로 공백이 있는지확인
            alert("댓글을 입력해 주세요.");
            document.getElementById('textarea').focus();
             return true;
           }
           else{
             return false;
           }
          }
        };


        $(function() {
              $('#textarea').keyup(function (e){
                  var content = $(this).val();
                  $('#memoLength').html(content.length + '/150');
              });
              $('#content').keyup();
        });

        function limitMemo(obj,cnt) {
        if (obj.value.length>cnt){ 
          alert("댓글은 150자까지만 입력가능합니다.");
          obj.value = obj.value.substring(0, cnt);
        document.getElementById('memoLength').innerHTML = cnt-obj.value.length;
        
      }
        };

        function zeroMemo() {
        document.getElementById('memoLength').innerHTML = "";
        };
    </script>
        <form  name="replyContent" method="post" id="reply_form">
        <div class="wrap">
        <textarea  row="1" cols="100" class="replyarea" id='textarea' maxlength="150" name="memo" onKeyPress="javascript: if (event.keyCode==13) return false;" onKeyUp="javascript: limitMemo(this, 150);"
          placeholder="댓글을 150자 이내로 작성해주세요."></textarea>
          <span id="memoLength"></span>
          </div>
          <div class="chatbutton"> 
          <input type="hidden" name="board_num" value=<?=$number?>> 
            <input type="button" class="medium-btn" name="action" id="send_btn" value="등록"/>
          </div>
      </form>

    </div>
    <?php 
    }
    ?>
    <!-- container div -->
</div>
<!-- 아래 비우기 -->
</div>
<div style="margin:100px"></div>
</body>
    </html>

   