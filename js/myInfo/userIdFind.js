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
            window.location.href="../../index.php";
        }
    }
}

// 이메일검증 부분
function validateEmail(value) { //id 값 검증
    send("user_ck.php", value);  // 아이디 중복을 위해 send(url, id)메소드 실행
}