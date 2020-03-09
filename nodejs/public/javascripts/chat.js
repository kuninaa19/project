// URL get 정보만 가져오기위한 함수
function getLastPath(url) {
    var rLastPath = /\/([a-zA-Z0-9._]+)(?:\?.*)?$/;
    return rLastPath.test(url) && RegExp.$1;
};
// 소켓io서버 객체화
const socket = io();

var room = getLastPath(window.location.pathname);

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