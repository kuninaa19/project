module.exports = function(app,fs)
{
   const mysql  = require('mysql');

    require('dotenv').config({ path: '/var/www/html/web/db.env' });

    var connection = mysql.createConnection({
        host     : process.env.DB_HOST,
        user     : process.env.DB_USER,
        password : process.env.DB_PASS,
        database : process.env.DB_NAME,
        charset  : 'utf8_general_ci',
        dateStrings: 'date'
      });
      
      connection.connect();
      
   //room id에 맞게 채팅목록창으로 이동 + 채팅방에 가입되어있는지 확인하기
   app.get('/room/chat/:id', function (req, res) {
      connection.query('SELECT * FROM chat WHERE id="'+req.params.id+'"', function (error, results, fields) {
          if (error) {
          console.log(error);
            }
          //채팅방 제목
          var title =results[0].title;
          var nickname =req.session.nickname;
          var userID =req.session.userID;

          // 가져온 아이디값들은 string으로 저장되어있음. 다시 JSON형태로 만들어야 사용하기 편함
            var obj = results[0].userID;
            var objStr = JSON.parse(obj);

            var ck=0; // 동일한 아이디가 있는지 확인하기위한 변수

            // 채팅방에 참가중인 아이디인지 확인
            for(var i=0;i<objStr.ID.length;i++){
              if(objStr.ID[i].user===userID){
                  ck=1;
                  break;
              }
            }
            //등록되지않은 유저일때
            if(ck==0){
              // 해당 채팅방 유저JSON배열에 유저아이디 추가
              objStr.ID.push({"user" : userID});

              //JSON형태를 Mysql에 넣기위해 string형으로 변환
              var myJSON = JSON.stringify(objStr);
              //query를 통해 mysql에 데이터저장
              sql = 'UPDATE chat SET userID= ? WHERE id="'+req.params.id+'"';
              connection.query(sql,myJSON, function (error, results, fields) {
              if (error) {
                  console.log(error);
                  res.redirect('/');
              }
              //해당 채팅방의 모든 채팅목록 가져옴.
              connection.query('SELECT * FROM chat_reply WHERE roomNum="'+req.params.id+'"', function (error, results, fields) {
                if (error) {
                  console.log(error);
                    }
                    // console.log(results);

                    res.render('chat.ejs',{title:title,nickname:nickname,userID:userID,chatList:results})
                });
              });
            }
            else{
              //해당 채팅방의 모든 채팅목록 가져옴.
              connection.query('SELECT * FROM chat_reply WHERE roomNum="'+req.params.id+'"', function (error, results, fields) {
                if (error) {
                  console.log(error);
                    }

                    // console.log(results);

                    res.render('chat.ejs',{title:title,nickname:nickname,userID:userID,chatList:results})
              });
            }
      });
  });

    // 채팅방 탈퇴
    app.post('/room/chat/out',function(req,res){
      // console.log(req.body.roomNum);
      connection.query('SELECT userID FROM chat WHERE id= ?',req.body.roomNum, function (error, results, fields) { 
        if (error) {
          console.log(error);
        }

        var userID =req.session.userID; // 방나가려는 유저의 아이디

        // 가져온 아이디값들은 string으로 저장되어있음. 다시 JSON형태로 만들어야 사용하기 편함
        var obj = results[0].userID;
        var objStr = JSON.parse(obj);

        //채팅방을 나가려는 유저가 마지막유저라면 방을 삭제
        if(objStr.ID.length==1){
          sql = 'DELETE FROM chat WHERE id= ?';
          connection.query(sql,req.body.roomNum, function (error, results, fields) {
          if (error) {
              console.log(error);
            }else{
              res.json({ok:true});
              // res.redirect('/')
            }
          });
        }
        else{
        // 채팅방에 참가중인 아이디인지 확인
        for(var i=0;i<objStr.ID.length;i++){
          if(objStr.ID[i].user===userID){
            //objStr.ID배열에서 i번(아이디가 동일한 인덱스)부터 1개요소 제거
            objStr.ID.splice(i,1);
              break;
          }
        }
        //JSON형태를 Mysql에 넣기위해 string형으로 변환
        var myJSON = JSON.stringify(objStr);

        sql = 'UPDATE chat SET userID= ? WHERE id= ?';
              connection.query(sql,[myJSON,req.body.roomNum], function (error, results, fields) {
              if (error) {
                  console.log(error);
              }else{
                res.json({ok:true});

                // res.redirect('/')
                }
              });
          }
        }); 
    });
}