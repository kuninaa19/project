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
        <link href="../style.css?after" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
</head>
<body>
<br>
<div class="container">
<div class="nav">
      <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
      <div class="nav-right-items">
      <div class="nav-item"><a href="#" onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a></div>
        <div class="nav-item"><a href="../review/review.php">리뷰</a></div>
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
    
    <script type="text/javascript">

  //글자수 제한
    function numberMaxLength(e){
        if(e.value.length > e.maxLength){
          alert('한영포함 40자까지 입력가능합니다.');
            e.value = e.value.slice(0, e.maxLength);
            
        }
    }
      //댓글 글자수 제한
        function subjectMemo(obj,cnt) {
        if (obj.value.length>cnt){ 
          alert("댓글은 150자까지만 입력가능합니다.");
          obj.value = obj.value.substring(0, cnt);
        document.getElementById('memoLength').innerHTML = cnt-obj.value.length;
        
      }
        };
        // 버튼눌렀을때 작성된 댓글글자수 초기화
        function zeroMemo() { 
         document.getElementById('memoLength').innerHTML = "";
         };

     

    </script>

<div class="nav_sub">
    <div class="big-category"> 글쓰기</div> 
    <div class="nav-right-items"></div>
</div>

<form action="writing_ok.php" name="Wform"  method="post" accept-charset="utf-8">
<table class="table table-bordered">
    <thead>
    </thead>         
        <tr>
          <th>제목</th>
          <td><input type="text" placeholder="제목을 입력해 주세요." id ="subject" name="subject" class="form-control" maxlength="40" onkeyup="numberMaxLength(this)"/></td>
        </tr>
        <tr>
          <th>내용</th>
          <td><textarea  name="content" id="content" rows="10" cols="100" style="width:700px; height:500px; display:none; width:100%" >
          </textarea>
          <script type="text/javascript" src="../editor.js"></script>
            </td>
          
            </tr>
        </tr>
      
    </tbody> 
</table>
<hr/>
<input type="hidden" name="user_id" value=<?=$_SESSION['user_id']?>> 
<input type="hidden" name="nickname" value=<?=$_SESSION['user_name']?>> 
<input type="button" onClick="submitContents(this);" class="btn btn-default pull-right"  value="글쓰기 완료"/>
</form>
</div>
<div style="margin:100px"></div>
    
</body>
    </html>

   