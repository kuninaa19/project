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
  <link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
    <body>
    <br>

    <script>
    var request = null;
    
    function send(url, idValue,emailValue) { //서버측으로 XMLHttpRequest 전송
    	request = new XMLHttpRequest();
    	if(request!=null) {

    		request.abort();
    		url+="?dummy="+new Date().getTime(); //cache에서 긁어오는것 방지 위해 send할때마다 url 달라짐
        
    		try {
    			request.onreadystatechange = handleRequest;
    			request.open("POST", url, true);  //항상 비동기이므로 true;
    			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=euc-kr");
    			//post 시에는 항상 헤더 설정 필요. get시에는 불필요함
    			request.send("idValue="+idValue+"&emailValue="+emailValue+"&action=findPW"); //send뒤에 데이터를 붙여서 전송 ex)xhr.send("name=" + irum + "&age=" + nai); 
    		}
    		catch(e) {
    			alert("서버와 통신 실패. details : " + e);
    		}
    	}
    }

    function handleRequest() { //DB검사이후 전송되어 돌아온 값 처리 
    
    	if(request.readyState==4 && request.status==200) {  
    		var result="";
    		result = request.responseText; // 서버로부터 받은 텍스트를 result에 저장
			
        console.log(result);
			  // 이메일
    		

        if(result=="existId"){ // 아이디 정보 알맞게 입력 이메일 정보 안맞음
          document.getElementById("idSpan").innerHTML=" ";
    			document.getElementById("emailSpan").innerHTML="입력하신 정보를 확인해주세요.";
          }

        else if(result=="existEmail"){ 
          document.getElementById("idSpan").innerHTML="입력하신 정보를 확인해주세요.";
          document.getElementById("emailSpan").innerHTML=" ";
    		  }
        else if(result=="notExist"){
          document.getElementById("idSpan").innerHTML="입력하신 정보를 확인해주세요.";
          document.getElementById("emailSpan").innerHTML="입력하신 정보를 확인해주세요.";
          }

        else if (result.indexOf("exist") != -1) {
            alert("임시 발급된 비빌번호를 전송하였습니다.");
            window.location.href="index.php";
          }
          else {
            alert("Not Found!!");
          }
          
    	  }
    }

    // 이메일검증 부분
    function validateUser(idValue,emailValue) { //id 값 검증

	    send("user_ck.php", idValue,emailValue);  // 아이디 중복을 위해 send(url, id)메소드 실행
      }
    
    </script>

    <div class="container">
        <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
        </div>
        <h3 class="banner">비밀번호 찾기</h3>
        
        <div class="box">
        <form method="post" name= "findEmail">
        <fieldset>   
            <h3 style="margin-left:30px; font-weight: bold;">임시비밀번호 받기</h3><hr>
            <h5 style="margin-left:30px;">가입시 등록한 <span style="color:red;">아이디와 메일주소</span>를 입력해주세요. </h5>

            <p><input type="text" name="userID" placeholder="아이디" class="info-form"/></p>
            <span class="error_box" id="idSpan" style="color:red"></span><br/>
            <p><input type="text" name="email" placeholder="이메일" class="info-form"/></p>
            <span class="error_box" id="emailSpan" style="color:red"></span><br/>
            <p ><input type="button" value="임시 비밀번호 받기" class="button-form" id="button-color" onclick="validateUser(userID.value,email.value)"/></p>
        </fieldset>   
        </form>
     </div>
</div>

</body>
</html>