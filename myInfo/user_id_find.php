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
  <link rel="stylesheet" href="../css/style.css" type="text/css"/>
</head>
    <body>
    <br>
    <script>
    var request = null;
    
    function send(url, info) { //서버측으로 XMLHttpRequest 전송
    	request = new XMLHttpRequest();
    	if(request!=null) {

    		request.abort();
    		url+="?dummy="+new Date().getTime(); //cache에서 긁어오는것 방지 위해 send할때마다 url 달라짐
        
    		try {
    			request.onreadystatechange = handleRequest;
    			request.open("POST", url, true);  //항상 비동기이므로 true;
    			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=euc-kr");
    			//post 시에는 항상 헤더 설정 필요. get시에는 불필요함
    			request.send("info="+info+"&action=findID"); //send뒤에 데이터를 붙여서 전송 ex)xhr.send("name=" + irum + "&age=" + nai); 
    		}
    		catch(e) {
    			alert("서버와 통신 실패. details : " + e);
    		}
    	}
    }

    function handleRequest() {      //DB검사이후 전송되어 돌아온 값 처리 
    
    	if(request.readyState==4 && request.status==200) {  
    		var result="";
    		result = request.responseText; // 서버로부터 받은 텍스트를 result에 저장
			
			  // 이메일
    		if(result=="wrongEmail") { //result에 false문자열이 있으면 사용 불가능
        
    			document.getElementById("emailSpan").innerHTML="유효하지않은 이메일입니다.";
    		  }		
        else if(result=="invalidateEmail"){
    			document.getElementById("emailSpan").innerHTML="회원가입된 이메일이 아닙니다.";
          }
        else{
          alert("아이디는 "+result+ "입니다.");
          window.location.href="../index.php";
    		  }
    	  }
    }

    // 이메일검증 부분
    function validateEmail(value) { //id 값 검증

	    send("user_ck.php", value);  // 아이디 중복을 위해 send(url, id)메소드 실행
      }
    
    </script>

    <div class="container">
        <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
        </div>
        <h3 class="banner">아이디 찾기</h3>
        
        <div class="box">
        <form method="post" name= "findID">
        <fieldset>   
            <h4 style="margin-left:30px;">가입시 등록한 메일주소를 입력해주세요.</h4>
            <p><input type="text" name="email" placeholder="이메일" class="info-form"/></p>
            <span class="error_box" id="emailSpan" style="color:red"></span><br/>
            <p ><input type="button" value="확인" class="button-form" id="button-color" onclick="validateEmail(email.value)"/></p>
        </fieldset>   
        </form>
       </div>
    </div>
</body>
</html>