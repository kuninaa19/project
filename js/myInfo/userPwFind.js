var request = null;

function send(url, idValue, emailValue) { //서버측으로 XMLHttpRequest 전송
    request = new XMLHttpRequest();
    if (request != null) {

        request.abort();
        url += "?dummy=" + new Date().getTime(); //cache에서 긁어오는것 방지 위해 send할때마다 url 달라짐

        try {
            request.onreadystatechange = handleRequest;
            request.open("POST", url, true);  //항상 비동기이므로 true;
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=euc-kr");
            //post 시에는 항상 헤더 설정 필요. get시에는 불필요함
            request.send("idValue=" + idValue + "&emailValue=" + emailValue + "&action=findPW"); //send뒤에 데이터를 붙여서 전송 ex)xhr.send("name=" + irum + "&age=" + nai);
        } catch (e) {
            alert("서버와 통신 실패. details : " + e);
        }
    }
}

function handleRequest() { //DB검사이후 전송되어 돌아온 값 처리

    if (request.readyState == 4 && request.status == 200) {
        var result = "";
        result = request.responseText; // 서버로부터 받은 텍스트를 result에 저장

        // console.log(result);
        // 이메일


        if (result == "existId") { // 아이디 정보 알맞게 입력 이메일 정보 안맞음
            document.getElementById("idSpan").innerHTML = " ";
            document.getElementById("emailSpan").innerHTML = "입력하신 정보를 확인해주세요.";
        } else if (result == "existEmail") {
            document.getElementById("idSpan").innerHTML = "입력하신 정보를 확인해주세요.";
            document.getElementById("emailSpan").innerHTML = " ";
        } else if (result == "notExist") {
            document.getElementById("idSpan").innerHTML = "입력하신 정보를 확인해주세요.";
            document.getElementById("emailSpan").innerHTML = "입력하신 정보를 확인해주세요.";
        } else if (result.indexOf("exist") != -1) {
            alert("임시 발급된 비빌번호를 전송하였습니다.");
            window.location.href = "../index.php";
        } else {
            alert("Not Found!!");
        }

    }
}

// 이메일검증 부분
function validateUser(idValue, emailValue) { //id 값 검증

    send("user_ck.php", idValue, emailValue);  // 아이디 중복을 위해 send(url, id)메소드 실행
}