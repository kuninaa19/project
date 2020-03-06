// 소켓io서버 객체화
const socket = io();

$(function () {
    var chat = $('#chat');
    var time = $('#time');

    //content값에 클릭같이 변화가 생겼을때


    socket.emit('latestChat', value);
});

socket.on('latestChat', function (data) {

});

var MyroomList = document.getElementById('MyroomList'); // 내 채팅방 목록