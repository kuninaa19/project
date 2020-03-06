var express = require('express');
var app = express();
var bodyParser = require('body-parser');
var fs = require('fs');
var socketio = require('socket.io');
var request = require('request');
var mysql      = require('mysql');
const session = require('express-session');
const FileStore = require('session-file-store')(session);

//dotenv
require('dotenv').config({ path: '/var/www/html/web/db.env' });

var connection = mysql.createConnection({
    host     : process.env.DB_HOST,
    user     : process.env.DB_USER,
    password : process.env.DB_PASS,
    database : process.env.DB_NAME,
    dateStrings: 'date'
});

connection.connect();

//8080번 포트를 읽으면 로그cmd에 남김
var server = app.listen(8080, function(){
    console.log("8080서버 실행중")
   });

//8080서버를 읽을때마다 리스트에 사람 채워줌
var io = socketio.listen(server);
var socketList = [];

//view안의 html에 ejs 템플릿렌더링
app.set('views', __dirname + '/views');
app.set('view engine', 'ejs');
app.engine('html', require('ejs').renderFile);

//public의 내용[동적]을 사용 (use는 동적)
//절대경로
// app.use(express.static(__dirname + '/public'));
//상대경로
app.use('/public', express.static(__dirname + '/public'));

//제이슨형식 읽기 및 해독
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
//세션생성틀
app.use(session({
    secret: '%^#*SIGN@*$#',
    resave: false,
    saveUninitialized: true,
    store: new FileStore(),
    //세션 2시간허용
    cookie: { originalMaxAge: 7.2e+6, httpOnly: true }
}));

// 소켓io가 연결되었을때
io.on('connection', function(socket){
    // 특정 소켓에서 connection 이벤트가 발생할 시(소켓이 연결이 됐을때) socketList에 push해줍니다. socketlist에 추가
    socketList.push(socket);

    // console.log('User Join');

    // 접속한 유저가 속해있는 채팅방의 가장 최신 채팅 전달
    socket.on('latestChat', function(data) {
        sql = 'select * from chat WHERE title LIKE "'+value+'%" ORDER BY created DESC';
        connection.query(sql, function (error, results, fields) {if (error) {
            console.log(error);
              }
            // Array로 선언해야됨 array X
            var relativeTime = new Array();

            //moment를 사용해서 작성된 시간과 현재시간 비교후 상대시간 저장
            for(var i=0;i<results.length;i++){
            relativeTime[i] = moment(results[i].created).fromNow();
                }
            });
    });
    
    // 채팅방목록검색
    socket.on('roomSearch', function(value) {
        sql = 'select * from chat WHERE title LIKE "'+value+'%" ORDER BY created DESC';
        connection.query(sql, function (error, results, fields) {if (error) {
            console.log(error);
              }
            //   console.log(results);
              if (!results) socket.emit('searchResults', {});
            else socket.emit('searchResults', results);
            });
    });

     // joinRoom을 클라이언트가 emit 했을 시 (채팅방에 들어갔을때)
    socket.on('joinRoom', function(data){    
        console.log('joinRoom'+data);

        //방번호 대입
        let roomName = data;
        socket.join(roomName);    // 클라이언트를 msg에 적힌 room으로 참여 시킴

        // 클라이언트가 접속해있는 채팅방에 현재 참여자수
        let pNum = io.sockets.adapter.rooms[roomName].length

        //입장시에 그룹에 참여중인 인원파악
        io.to(roomName).emit('person', pNum); // 그룹 전체

    });
    
    //유저가 사용중인 채팅방에서 누군가가 나갔을때
    socket.on('personRMV',function(data){
        //방번호 대입
        let roomName = data;

        // 클라이언트가 접속해있는 채팅방에 현재 참여자수
        let pNum = io.sockets.adapter.rooms[roomName].length

        //입장시에 그룹에 참여중인 인원파악
        io.to(roomName).emit('personRMV', pNum-1); // 그룹 전체
        
    });

    // 클라이언트가 채팅 내용을 보냈을 시
    socket.on('SEND', function(data) {      
        //done에 입장시 서울시간을 파악
        const moment = require('moment');
        require('moment-timezone');
        moment.tz.setDefault("Asia/Seoul");
        var date = moment().format('YYYY-MM-DD HH:mm:ss');

        sql = 'INSERT into chat_reply (roomNum, reply,nickname,user_id,created) values (?,?,?,?,?)';
        connection.query(sql,[data.roomName,data.msg,data.nickname,data.userID,date], function (error, results, fields) {if (error) {
            console.log(error);
              }
              
              var json ={msg:data.msg,nickname:data.nickname,userID:data.userID}

              //해당방에 나를 제외하고 전부에게 메세지전달
              socket.broadcast.to(data.roomName).emit('SEND', json); 
            });
            
        let chat =  '{"chat" : "'+data.msg+'","date" : "'+date+'"}';

        updateSql = 'UPDATE chat SET latestChat= ? WHERE id="'+data.roomName+'"';
        connection.query(updateSql,[chat], function (error, results, fields) {if (error) {
            console.log(error);
            }
        });

    })

    // 최초접속(auth)시 ajax를 통해 아이디받고 세션생성
    socket.on('Session', function(data) {
        // console.log(data);
        
        // 메인페이지로 이동하기위한 emit
        socket.emit('MOVE',data);
    });

    //소켓 미 연결시 연결해제시
    socket.on('disconnect', function() {
        // 특정 소켓에서 disconnect 이벤트가 발생할 시(소켓 연결이 해제됐을때) socketList에서 해당 socket을 삭제해줍니다
        //소켓저장된 위치를 찾아서 잘라줌 1개(splice 추가 삭제 코드다름.)
        socketList.splice(socketList.indexOf(socket), 1);
    });
});

// 라우터 자바의 import같은 역할
var indexRouter = require('./routes/index')(app,request, fs);
var roomListRouter = require('./routes/roomList')(app, fs);
var roomAddRouter = require('./routes/roomAdd')(app, fs);
var chatRouter = require('./routes/chat')(app,fs);
var authRouter = require('./routes/auth')(app, fs);
