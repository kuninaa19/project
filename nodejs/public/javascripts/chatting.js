var chatView = document.getElementById('chatView'); // 메시지 활성창
var chatForm = document.getElementById('chatForm'); //메시지 작성창
var user = document.getElementById('userID');

// 버튼 사용없이 비동기로 정보가져오기
function chat(params) {
    if (params.user_id == user) {
        var msgLine = $('<div class="msgLine">');
        var msgBox = $('<div class="msgBox">');

        msgBox.append(params.reply);
        //msg변수에 css주기
        msgBox.css('display', 'inline-block');

        msgLine.css('text-align', 'right');
        msgLine.append(msgBox);

        $('#chatView').append(msgLine);

        //스크롤 크기값 확인후 스크롤크기값 메시지활성창에 대입
        chatView.scrollTop = chatView.scrollHeight;
    } else {
        var msgLine = $('<div class="msgLine">');
        var nickBox = $('<div class="nickBox">');
        var msgBox = $('<div class="msgBox">');

        // msgBox.append(data.nickname);

        msgBox.append(params.reply);
        msgBox.css('display', 'inline-block');

        nickBox.append(params.nickname);

        msgLine.append(nickBox);

        msgLine.append(msgBox);
        $('#chatView').append(msgLine);

        chatView.scrollTop = chatView.scrollHeight;
    }
};

// 메시지 전송버튼 이벤트리스너
chatForm.addEventListener('submit', function () {
    var msg = $('#msg'); // id가 msg인 값을 msg변수에 저장

    // 값이 입력되지않았다면 전송되지않음
    if (msg.val() == '') {
        return;
    } else {
        //값이있다면 서버에 전달
        var userID = $('#userID').val();
        var nickname = $('#nickname').val();

        var json = {msg: msg.val(), nickname: nickname, userID: userID, roomName: room}
        //socket.emit. 이벤트명 'SEND'으로 서버측에 값 전송
        socket.emit('SEND', json);

        var msgLine = $('<div class="msgLine">');
        var msgBox = $('<div class="msgBox">');

        //.append() 메소드는 선택된 요소의 마지막에 새로운 HTML 요소나 콘텐츠를 추가한다.
        msgBox.append(msg.val());
        //msg변수에 css주기
        msgBox.css('display', 'inline-block');

        msgLine.css('text-align', 'right');
        msgLine.append(msgBox);

        $('#chatView').append(msgLine);

        //메시지 다시 초기화
        msg.val('');
        //스크롤 크기값 확인후 스크롤크기값 메시지활성창에 대입
        chatView.scrollTop = chatView.scrollHeight;
    }
});
//메시지를 수신하기 위해서는 on 메소드를 사용
socket.on('SEND', function (data) {
    var msgLine = $('<div class="msgLine">');
    var nickBox = $('<div class="nickBox">');

    var msgBox = $('<div class="msgBox">');

    // msgBox.append(data.nickname);

    msgBox.append(data.msg);
    msgBox.css('display', 'inline-block');

    nickBox.append(data.nickname);

    msgLine.append(nickBox);

    msgLine.append(msgBox);
    $('#chatView').append(msgLine);

    chatView.scrollTop = chatView.scrollHeight;
});