// 소켓io서버 객체화
const socket = io();
var userID;
// 버튼 사용없이 비동기로 정보가져오기
$(function () {
    $.ajax({
        //호출할 원격URL
        url: "http://localhost:80/nodePhpAuth.php",
        //jsonp방식
        dataType: "jsonp",
        crossOrigin: true,
        jsonp: "callback",
        //success는 일반 json 방식과 같음
        success: function (data) {
            console.log("result data object", data);

            //ajax를 통해 로그인되어있지않다는 정보를 받았을때 창을 닫음
            if (data == "로그인후 이용해주세요") {
                alert('로그인후 이용해주세요');
                window.close();
            } else {
                var row_datas = data.split('|');
                var info = {user: row_datas[0], nickname: row_datas[1]};

                //form전송을 위해 아이디,닉네임 값을 저장
                document.roomForm.user.value = row_datas[0];
                document.roomForm.nickname.value = row_datas[1];

                // 세션생성을 위해 userid를 소켓으로 전송
                socket.emit('Session', info);
            }
        }
    });
});

function placeOrder() { //form 제출
    document.getElementById('frm').submit();
}
//페이지움직이라는 정보를 소켓으로부터 받았을때
socket.on('MOVE', function (data) {
    placeOrder();
});