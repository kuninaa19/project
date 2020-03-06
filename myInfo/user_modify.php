<!DOCTYPE html>
<?php session_start();
?>
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
       <div class="container">
        <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
        </div>
        <?php
        $i=$_GET['form'];
            switch($i){
            case 1:
         ?>
        <h3 class="banner">나의 정보 변경</h3><?php
            break;
            case 2:
        ?>
        <h3 class="banner">비밀번호 변경</h3><?php
            break;
            case 3:
        ?>
        <h3 class="banner">회원탈퇴</h3><?php
         }?>
       
        <div class="box">
        <?php if(isset($_SESSION['user_id'])) {

            include_once ('../db.php');


            $sql="SELECT * FROM user WHERE id='{$_SESSION['user_id']}'";

            $result = mysqli_query($conn, $sql);
            if($result === false){
            header("Content-Type: text/html; charset=UTF-8");
            echo "<script>alert('관리자에게 문의해주세요');";
            echo "window.location.replace('index.php');</script>";
            error_log(mysqli_error($conn));
            exit;
            }
            else{
                $row=mysqli_fetch_array($result);
                $i=$_GET['form'];

            switch($i){

            case 1: //닉네임변경
         ?>
         <form method="post" action="user_modify_check.php" name="nickForm">
            <fieldset>
            <b class="txt_sign">아이디</b><br /><input type="text" class="info-form" name="id" value=<?=$row['id']?> disabled><p><br/>
            <b class="txt_sign">닉네임</b><br /><input type="text" class="info-form" name="nickname" value=<?=$row['nickname']?> onblur="validateNickname(this.value)"><p>
            <span class="error_box" id="nickSpan"></span> <br/><p>
            <b class="txt_sign">이메일</b><br /><input type="text" class="info-form" name="email" value=<?=$row['email']?> disabled><br/></p>
            <input type="hidden" name="process" value="nick"> 

            <input type="button" class="button-form" id="button-color" onclick="placeOrder(this.form,1)" value="확인">
            </fieldset>
            </form>
            <?php
            break;
            
            // 비밀번호 변경
            case 2: ?> 
            <form method="post" action="user_modify_check.php" name="passForm">
            <fieldset>
            <b class="txt_sign">새 비밀번호</b><br /><input type="password" class="info-form" name="pw" onblur="validatePassword(this.value)"><br />
            <span class="error_box" id="passwordSpan"></span><br/><p></p>
            <b class="txt_sign">새 비밀번호 확인</b><br /><input type="password" class="info-form" name="pw2" onblur="validatePassword2(pw.value,this.value)"><br />
            <span class="error_box" id="password2Span"></span><br/>
            <input type="hidden" name="process" value="pass"> 

            <input type="button" class="button-form" id="button-color"  onclick="placeOrder(this.form,2)" value="확인">
            </fieldset>
            </form>
            <?php
            break;

            //회원탈퇴
            case 3: ?>
            <form method="post" action="user_modify_check.php">
            <fieldset>
            <b class="txt_sign">정말로 회원탈퇴하시겠습니까?</b><br /><b class="txt_sign" style="color:#DF0101;">회원탈퇴시 모든 정보가 삭제됩니다.</b><br />
            
            <input type="hidden" name="process" value="out"> 
            <input type="submit" class="button-form" id="button-color" value="확인">
            </fieldset>
            </form>
        <?php }
         
            } 
        }?>
    <!-- script는 클라이언트실행 php서버실행 -->
    <script>
    var request = null;
    
    function send(url, info,action) { //서버측으로 XMLHttpRequest 전송
    	request = new XMLHttpRequest();
    	if(request!=null) {

    		request.abort();
    		url+="?dummy="+new Date().getTime(); //cache에서 긁어오는것 방지 위해 send할때마다 url 달라짐
        
    		try {
    			request.onreadystatechange = handleRequest;
    			request.open("POST", url, true);  //항상 비동기이므로 true;
    			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=euc-kr");
    			//post 시에는 항상 헤더 설정 필요. get시에는 불필요함
    			request.send("info="+info+"&action="+action); //send뒤에 데이터를 붙여서 전송 ex)xhr.send("name=" + irum + "&age=" + nai); 
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
			  // 닉네임
    		if(result=="possibleNick") { //result에 false문자열이 있으면 사용 불가능
    			document.getElementById("nickSpan").style="color:green";
    			document.getElementById("nickSpan").innerHTML="사용가능한 닉네임입니다.";
                checkNameRule=true;
    		  }		
            else if(result=="existNick") { //result에 false문자열이 있으면 사용 불가능
				document.getElementById("nickSpan").style="color:red";
    			document.getElementById("nickSpan").innerHTML="중복된 닉네임입니다.";
    		}
            // 비밀번호
            else if(result=="possiblePW"){
                checkPasswordRule=true;
                document.getElementById("passwordSpan").style="color:green";
    			document.getElementById("passwordSpan").innerHTML="사용가능한 비밀번호입니다.";
            }
            else if(result=="existPW"){
                document.getElementById("passwordSpan").style="color:red";
    			document.getElementById("passwordSpan").innerHTML="이전비밀번호와 다르게 입력해주세요";
            }
         }
    }

    //-----------------로그인 폼 검증-----------
    var checkNameRule;
    var checkPasswordRule;
    var checkPassword2Rule;

    function validateNickname(value) { // 닉네임 검증
    	var alphaSmall =/[a-z]/;
    	var alphaBig=/[A-Z]/;
        var specialCharacter=/[^A-Za-zㄱ-힣0-9-]/; // 특수문자, 공백 검증
    	var korean=/^[가-힣]+$/; // 한글
    	var english=/^[A-z]+$/; // 영어
    	checkNameRule=false;

        var original = <?php echo json_encode($row['nickname']); ?>; // 기존닉네임 정보 저장
    
        document.getElementById("nickSpan").style="color:red";

    	//이름 검증 시작 (DB검색하지않고 순수하게 정보처리)
        console.log(value);

        if(value == original){
            document.getElementById("nickSpan").innerHTML="기존 닉네임과 다르게 입력해주세요";
        }else{
            if(value.length<2 || value.length>6)
	        	document.getElementById("nickSpan").innerHTML="2자리 ~ 6자리글자내로 입력해주세요";
	        else if(specialCharacter.test(value))
	        	document.getElementById("nickSpan").innerHTML="한글또는 영문을 사용하세요. (특수기호, 공백 사용 불가)";
	        else {
	        	send("user_modify_ck.php", value,"changeNick");   // 닉네임 중복을 위해 send(url, id)메소드 실행
	        }
        }	
    }

    function validatePassword(value) {	//패스워드 검증 
	    var alphaSmall =/[a-z]/;
	    var alphaBig=/[A-Z]/;
	    var number=/[0-9]/;
	    var specialChar=/[!@#$%^&*()_+|]/;
	    var space =/[\s]/;
	    checkPasswordRule=false;
        document.getElementById("passwordSpan").style="color:red";
	    if(value.length >15 || value.length < 9) 
	    	document.getElementById("passwordSpan").innerHTML="8~16자 영문, 숫자, 특수문자를 사용하세요.";
	    else if(!number.test(value))
	    	document.getElementById("passwordSpan").innerHTML="숫자를 포함시켜야 합니다.";
	    else if(!alphaSmall.test(value) && !alphaBig.test(value)) 
	    	document.getElementById("passwordSpan").innerHTML="영문을 포함시켜야합니다.";
	    else if(!specialChar.test(value)) 
	    	document.getElementById("passwordSpan").innerHTML="특수문자를 포함시켜야 합니다.";
	    else if(space.test(value)) 
	    	document.getElementById("passwordSpan").innerHTML="공백은 사용 할 수 없습니다.";
	    else {
            send("user_modify_ck.php", value,"changePW");   // 비밀번호 중복 확인을 위해 send(url, id)메소드 실행
	    }
    }

    function validatePassword2(value1, value2) {	//패스워드 검증 
    	var alphaSmall =/[a-z]/;
    	var alphaBig=/[A-Z]/;
    	var number=/[0-9]/;
    	var specialChar=/[!@#$%^&*()_+|]/;
    	var space =/[\s]/;
    	var space2 ="";

        checkPassword2Rule=false;
        document.getElementById("password2Span").style="color:red";
        
        if(value2.length >15 || value2.length < 9){}
	    else if(!number.test(value2)){}
	    else if(!alphaSmall.test(value2) && !alphaBig.test(value2)) {}
	    else if(!specialChar.test(value2)){}
	    else if(space.test(value2)) {
        document.getElementById("password2Span").innerHTML="공백은 사용 할 수 없습니다.";
    }
	    else if (value1==value2) {
            checkPassword2Rule=true;
            document.getElementById("password2Span").style="color:green";
            document.getElementById("password2Span").innerHTML="비밀번호가 일치합니다.";
	    }
        else{
            document.getElementById("password2Span").innerHTML="비밀번호를 일치시켜주세요";

        }

    	
    }

    function placeOrder(form,num) { //form 제출
    // 닉네임 변경
    if(num==1){
        if(!checkNameRule) {
    		alert("닉네임을 올바르게 입력하세요");
    	}
        else{
    		form.submit();
        }
    }
    // 비밀번호 변경
    else if(num==2){
        if(!checkPasswordRule) {
			alert("입력하신 비밀번호를 확인해주세요");
	    }
        else if(!checkPassword2Rule) {
			alert("입력하신 비밀번호를 확인해주세요");
	    }
        else{
    		form.submit();
        }
    } 
    	
    }
    </script>
     </div>
</div>
</body>
</html>