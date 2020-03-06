// 소켓io서버 객체화
var socket = io();

$(document).ready(function () {
    var content = $('#search');

    //content값에 클릭같이 변화가 생겼을때
    content.keyup(function () {
        var value = content.val();
        //방이 있는지 검색요청
        socket.emit('roomSearch', value);
    });
});

moment.updateLocale('en', {
    relativeTime: {
        future: "%s 후",
        past: "%s 전",
        s: "%d 초",
        ss: "%d 초",
        m: "%d 분",
        mm: "%d 분",
        h: "%d 시간",
        hh: "%d 시간",
        d: "%d 일",
        dd: "%d 일",
        M: "%d 달",
        MM: "%d 달",
        y: "%d 년",
        yy: "%d 년"
    }
});

//검색에 대한 결과
socket.on('searchResults', function (data) {
    var html = "";
    if (data != null && data.length > 0) {
        html = "<ul>";
        for (var i = 0; i < data.length; i++) {
            let date = moment(data[i].created);

            html += "<li><a href='/room/chat?id=" + data[i].id + "'  data-ajax='false'>";
            html += "<div style ='font-size:x-large; margin-left:10px'>" + data[i].title + "</div>";
            html += "<small style='margin-left:10px'>" + data[i].description + "</small>";
            html += "<small style='float:right; margin-right:10px'>생성일 " + date.fromNow() + "</small></a></li>";
        }
        html += "<ul>";

        $('#MyroomList').html(html);
    }
});