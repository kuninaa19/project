// URL get 정보만 가져오기위한 함수
var getParameters = function (paramName) {
    // 리턴값을 위한 변수 선언
    var returnValue;

    // 현재 URL 가져오기
    var url = location.href;

    // get 파라미터 값을 가져올 수 있는 ? 를 기점으로 slice 한 후 split 으로 나눔
    var parameters = (url.slice(url.indexOf('?') + 1, url.length)).split('&');

    // 나누어진 값의 비교를 통해 paramName 으로 요청된 데이터의 값만 return
    for (var i = 0; i < parameters.length; i++) {
        var varName = parameters[i].split('=')[0];
        if (varName.toUpperCase() == paramName.toUpperCase()) {
            returnValue = parameters[i].split('=')[1];
            return decodeURIComponent(returnValue);
        }
    }
};
// 소켓io서버 객체화
const socket = io();
var room = getParameters('id');
socket.emit('joinRoom', room);

//사람 현재인원표기
socket.on('person', function (data) {
    console.log(data);
    document.getElementById("personNum").innerHTML = data + "명";
});

// 클라이언트 나감
socket.on('personRMV', function (data) {
    console.log(data);
    document.getElementById("personNum").innerHTML = data + "명";
});

//뒤로버튼  눌렀을때 나가려는 유저제외하고 알림
function back() {
    //현재 인원표
    socket.emit('personRMV', room);
    location.href = "http://localhost:8080/";
}

// 방나가기
function exit() {
    var jbResult = confirm('채팅방을 나가시겠습니까?');

    if (jbResult) {
        $.ajax({
            //호출할 원격URL
            url: "http://localhost:8080/room/chat/out",
            async: true,
            type: 'POST',
            data: {
                roomNum: room
            },
            dataType: "json",
            success: function (data) {
                socket.emit('personRMV', room);
                location.href = "http://localhost:8080/";
            }
        });
    }
}