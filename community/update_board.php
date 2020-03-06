<!DOCTYPE html>
<?php session_start(); 
  include_once ('../db.php');
  $number= $_GET['id'];

  $sql= "SELECT * FROM topic WHERE id=$number";
  $result= mysqli_query($conn,$sql);
  
  $row = mysqli_fetch_array($result);
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ITdream</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/bootstrap-theme.css"/>
        <link rel="stylesheet" href="../css/bootstrap.css"/>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <link href="../css/style.css?after" rel="stylesheet" type="text/css"/>
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
        <div class="nav-item"><a href="community.php?page=1&list=10">커뮤니티</a></div>
        <div class="nav-item"><a href="../notice/notice.php?page=1&list=10">공지사항</a></div>
        <div class="nav-item">
        <?php include '../auth/session_login.php' ?>
        </div>
        <div class="nav-item">
        <?php include '../auth/session_signUp.php' ?>
        </div>
      </div>
    </div>

<div class="nav">
    <div class="big-category"> 글수정</div> 
    <div class="nav-right-items"></div>
</div>

<form action="updating_board_ok.php" name="Wform" method="post" accept-charset="utf-8" >
<table class="table table-bordered">
    <thead>
    </thead>         
        <tr>
          <th>제목</th>
          <td><input type="text" placeholder="제목을 입력해 주세요." id ="subject" name="subject" class="form-control" value="<?=$row['title']?>"/></td>
        </tr>
        <tr>
        <th>내용</th>
          <td>
          <?php
              // DB내 내용 칼럼의 항목을 가져와서 에디터 내에 뿌려 주기 위해 소스 정리한다.
              $content = preg_replace("/\r\n|\n/",'',stripslashes($row['description']));  
              $content = str_replace("'","\'",$content);
              $content = str_replace('"','\"',$content);
              ?>      
          <textarea  name="content" id="content" rows="10" cols="100" style="width:700px; height:500px; display:none;width:100%">
              </textarea>   
              <script type="text/javascript">      
              var oEditors = [];

                var sLang = "ko_KR"; // 언어 (ko_KR/ en_US/ ja_JP/ zh_CN/ zh_TW), default = ko_KR
                
                // 추가 글꼴 목록
                //var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];
                
                nhn.husky.EZCreator.createInIFrame({
                 oAppRef: oEditors,
                 elPlaceHolder: "content",
                 sSkinURI: "/smarteditor/SmartEditor2Skin.html", 
                 htParams : {
                  bUseToolbar : true,    // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                  bUseVerticalResizer : true,  // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                  bUseModeChanger : true,   // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                  //bSkipXssFilter : true,  // client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
                  //aAdditionalFontList : aAdditionalFontSet,  // 추가 글꼴 목록
                  fOnBeforeUnload : function(){
                   //alert("완료!");
                  },
                  I18N_LOCALE : sLang
                 }, //boolean
                 fOnAppLoad : function(){
                  //예제 코드
                  oEditors.getById["content"].exec("PASTE_HTML", [""]);
                  oEditors.getById["content"].exec("PASTE_HTML", ["<?=$content?>"]);
                  
                 },
                 fCreator: "createSEditor2"
                });
                
                function pasteHTML() {
                 var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
                 oEditors.getById["content"].exec("PASTE_HTML", [sHTML]);
                }
                
                function showHTML() {
                 var sHTML = oEditors.getById["content"].getIR();
                 alert(sHTML);
                }
                
                function submitContents(elClickedObj) {
                 oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.
                //  oEditors2.getById["content_chn"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.
                
                 // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.
                
                 var subCheck=0;
                 try {
                
                  // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.
                 if (!Wform.subject.value) {
                  alert("글제목을 입력해 주세요.");
                  Wform.subject.focus();
                  return;
                 }else{
                  subEle = Wform.subject.value;
                  
                  if($.trim(subEle)!=""){
                    // console.log("작성내용있음");
                    subCheck=1;
                  }
                  else{
                    // console.log("모두 빈칸임");
                    alert("글제목을 입력해 주세요.");
                    Wform.subject.focus();
                    return;
                  
                  }
                 }
               
                  // 1차 검사
                  if (document.getElementById("content").value=="<p>&nbsp;</p>"||document.getElementById("content").value==" ") {
                   alert("내용을 입력해 주세요.");
                   oEditors.getById["content"].exec("FOCUS",[]);
                   return;
                  }
                
                  else{
                    // 2차검사 모든 태그와 띄어쓰기를 제거후에 내용이있는지 확인
                    var element = document.getElementById("content").value;
                    // console.log("맨처음"+element);
                  
                    text = element.replace(/&nbsp; /ig, "");
                    // console.log("&nbsp; 삭제"+text);
                  
                    text1 = text.replace(/&nbsp;/ig, "");
                    // console.log("&nbsp;삭제"+text1);
                  
                    text2 = text1.replace(/<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/ig, "");
                  
                    // console.log("<p>삭제"+text2);
                  
                    if(text2!=""&&subCheck==1){
                      // console.log("작성내용있음");
                      elClickedObj.form.submit();
                    }
                    else{
                      // console.log("모두 빈칸임");
                      alert("내용을 입력해 주세요.");
                      oEditors.getById["content"].exec("FOCUS",[]);
                      return;
                    
                    }
                  }
                
                //   form2.action="writing_ok.php";
                // //   elClickedObj.form.submit();
                //   form2.submit();
                 } catch(e) {alert(e);}
               
                }
                
                function setDefaultFont() {
                 var sDefaultFont = '궁서';
                 var nFontSize = 24;
                 oEditors.getById["content"].setDefaultFont(sDefaultFont, nFontSize);
                }
                
                function writeReset() {
                 document.f.reset();
                 oEditors.getById["content"].exec("SET_IR", ["<?=$content?>"]);
                
                }</script>
                      <!-- <script type="text/javascript" src="../editor2.js"></script> -->
            </td>
            </tr>
        </tr>
    </tbody> 
</table>
<hr/>
<input type="hidden" name="nickname" value=<?=$_SESSION['user_name']?>> 
<input type="hidden" name="id" value=<?=$number?>> 
<input type="button" onClick="submitContents(this);" class="btn btn-default pull-right"  value="수정 완료"/>
</form>
</div>
<div style="margin:100px"></div>
              </body>
    </html>

   