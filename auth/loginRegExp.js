var request = null;

function send(url, info, action) { //서버측으로 XMLHttpRequest 전송
    request = new XMLHttpRequest();
    if (request != null) {

        request.abort();
        url += "?dummy=" + new Date().getTime(); //cache에서 긁어오는것 방지 위해 send할때마다 url 달라짐

        try {
            request.onreadystatechange = handleRequest;
            request.open("POST", url, true);  //항상 비동기이므로 true;
            request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=euc-kr");
            //post 시에는 항상 헤더 설정 필요. get시에는 불필요함
            request.send("info=" + info + "&action=" + action); //send뒤에 데이터를 붙여서 전송 ex)xhr.send("name=" + irum + "&age=" + nai);
        } catch (e) {
            alert("서버와 통신 실패. details : " + e);
        }
    }
}

function handleRequest() {      //DB검사이후 전송되어 돌아온 값 처리

    if (request.readyState == 4 && request.status == 200) {
        var result = "";
        result = request.responseText; // 서버로부터 받은 텍스트를 result에 저장

        // 아이디 여부
        if (result == "possibleID") {  //result에 true문자열이 있으면 사용가능
            document.getElementById("idSpan").style = "color:green";
            document.getElementById("idSpan").innerHTML = "사용가능한 아이디입니다.";
            checkUsedId = true;
        } else if (result == "existID") { //result에 false문자열이 있으면 사용 불가능
            document.getElementById("idSpan").style = "color:red";
            document.getElementById("idSpan").innerHTML = "중복된 아이디입니다.";
        }
        //닉네임 여부
        if (result == "possibleNick") {  //result에 true문자열이 있으면 사용가능
            document.getElementById("nameSpan").style = "color:green";
            document.getElementById("nameSpan").innerHTML = "사용가능한 닉네임입니다.";
        } else if (result == "existNick") { //result에 false문자열이 있으면 사용 불가능
            document.getElementById("nameSpan").style = "color:red";
            document.getElementById("nameSpan").innerHTML = "중복된 닉네임입니다.";
        }
        // 이메일 여부
        if (result == "possibleEmail") {  //result에 true문자열이 있으면 사용가능
            checkEmailRule = true;
            document.getElementById("emailSpan").style = "color:green";
            document.getElementById("emailSpan").innerHTML = "사용가능한 이메일입니다.";
        } else if (result == "existEmail") {//result에 false문자열이 있으면 사용 불가능

            document.getElementById("emailSpan").style = "color:red";
            document.getElementById("emailSpan").innerHTML = "중복된 이메일입니다.";
        } else if (result == "wrongEmail") {
            document.getElementById("emailSpan").style = "color:red";
            document.getElementById("emailSpan").innerHTML = "올바른 e-mail주소를 입력하세요";
        }
    }
}

//-----------------로그인 폼 검증-----------
var checkPasswordRule;
var checkPassword2Rule;
var checkNameRule;
var checkEmailRule;
var checkIdRule;
var checkUsedId;

function validateId(value) {       //id 값 검증
    var IdRule = /^\w+$/;
    checkIdRule = false;
    checkUsedId = false;

    document.getElementById("idSpan").style = "color:red";

    if (value.length < 1) {
        document.getElementById("idSpan").innerHTML = "아이디를 입력하세요";
    } else if (value.length < 5 || value.length > 15) {
        document.getElementById("idSpan").innerHTML = "5~15자리의 아이디를 입력하세요";
    } else if (!IdRule.test(value)) {
        document.getElementById("idSpan").innerHTML = "영문/숫자만 사용 가능합니다.";
    } else {
        checkIdRule = true;
        send("signUp_ck.php", value, "id");   // 아이디 중복을 위해 send(url, id)메소드 실행
    }
}

function validatePassword(value) {	//패스워드 검증
    var alphaSmall = /[a-z]/;
    var alphaBig = /[A-Z]/;
    var number = /[0-9]/;
    var specialChar = /[!@#$%^&*()_+|]/;
    var space = /[\s]/;
    checkPasswordRule = false;
    document.getElementById("passwordSpan").style = "color:red";
    if (value.length > 15 || value.length < 9)
        document.getElementById("passwordSpan").innerHTML = "8~16자 영문, 숫자, 특수문자를 사용하세요.";
    else if (!number.test(value))
        document.getElementById("passwordSpan").innerHTML = "숫자를 포함시켜야 합니다.";
    else if (!alphaSmall.test(value) && !alphaBig.test(value))
        document.getElementById("passwordSpan").innerHTML = "영문을 포함시켜야합니다.";
    else if (!specialChar.test(value))
        document.getElementById("passwordSpan").innerHTML = "특수문자를 포함시켜야 합니다.";
    else if (space.test(value))
        document.getElementById("passwordSpan").innerHTML = "공백은 사용 할 수 없습니다.";
    else {
        checkPasswordRule = true;
        document.getElementById("passwordSpan").style = "color:green";
        document.getElementById("passwordSpan").innerHTML = "사용가능합니다.";
    }
}

function validatePassword2(value1, value2) {	//패스워드 검증
    var alphaSmall = /[a-z]/;
    var alphaBig = /[A-Z]/;
    var number = /[0-9]/;
    var specialChar = /[!@#$%^&*()_+|]/;
    var space = /[\s]/;
    checkPassword2Rule = false;

    if (value2.length > 15 || value2.length < 9) {
    } else if (!number.test(value2)) {
    } else if (!alphaSmall.test(value2) && !alphaBig.test(value2)) {
    } else if (!specialChar.test(value2)) {
    } else if (space.test(value2)) {
        document.getElementById("password2Span").innerHTML = "공백은 사용 할 수 없습니다.";
    } else if (value1 == value2) {
        checkPassword2Rule = true;
        document.getElementById("password2Span").style = "color:green";
        document.getElementById("password2Span").innerHTML = "비밀번호가 일치합니다.";
    } else {
        document.getElementById("password2Span").style = "color:red";
        document.getElementById("password2Span").innerHTML = "비밀번호를 일치시켜주세요";

    }
}

function validateNickname(value) { // 닉네임 검증
    var alphaSmall = /[a-z]/;
    var alphaBig = /[A-Z]/;
    var korean = /^[가-힣]+$/;
    var english = /^[A-z]+$/;
    checkNameRule = false;
    document.getElementById("nameSpan").style = "color:red";

    //이름 검증 시작 (DB검색하지않고 순수하게 정보처리)
    if (value.length < 2 || value.length > 6)
        document.getElementById("nameSpan").innerHTML = "2자리 ~ 6자리글자내로 입력해주세요";
    else if (!korean.test(value) && !english.test(value))
        document.getElementById("nameSpan").innerHTML = "한글또는 영문을 사용하세요. (특수기호, 공백 사용 불가)";
    else {
        checkNameRule = true;
        send("signUp_ck.php", value, "nick");   // 아이디 중복을 위해 send(url, id)메소드 실행
    }
}

function validateEmail(value) { //email검증
    checkEmailRule = false;

    send("signUp_ck.php", value, "email");   // 아이디 중복을 위해 send(url, id)메소드 실행

}


function placeOrder(form) { //form 제출
    if (!checkIdRule) {
        alert("아이디를 올바르게 입력하세요");
        validateId(document.getElementById("id").value);
    } else if (!checkUsedId) {
        alert("중복된 아이디입니다.");
        validateId(document.getElementById("id").value);

    } else if (!checkPasswordRule) {
        alert("패스워드를 올바르게 입력하세요");
        validatePassword(document.getElementById("pw").value);
    } else if (!checkPassword2Rule) {
        alert("입력하신 비밀번호를 확인해주세요");
        validatePassword(document.getElementById("pwcf").value);

    } else if (!checkEmailRule) {
        alert("이메일을 올바르게 입력하세요");
        validateEmail(document.getElementById("email").value);
    } else if (!checkNameRule) {
        alert("닉네임을 올바르게 입력하세요");
        validateNickname(document.getElementById("nickname").value);
    } else {
        form.submit();
    }
}