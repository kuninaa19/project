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

      //auth를 거쳐서 아이디가 세션에 등록되었는지 확인
    function loginCk(req,res){
        if(req.session.is_logined){
            return true;
        }else{
            return false;
        }
    }

    // 현재와 해당 채팅방이 언제만들어졌는지 상대시간을 구하기위해서 사용
    const moment = require('moment');

    moment.updateLocale('en', {
        relativeTime : {
            future: "%s 후",
            past:   "%s 전",
            s  : "%d 초",
            ss : "%d 초",
            m:  "%d 분",
            mm: "%d 분",
            h:  "%d 시간",
            hh: "%d 시간",
            d:  "%d 일",
            dd: "%d 일",
            M:  "%d 달",
            MM: "%d 달",
            y:  "%d 년",
            yy: "%d 년"
        }
    });
    app.get('/roomList',function(req,res){
        if(loginCk(req,res)){
        connection.query('SELECT * FROM chat ORDER BY created DESC', function (error, results, fields) {if (error) {
            console.log(error);
              }
              // Array로 선언해야됨 array X
            var relativeTime = new Array();

            //moment를 사용해서 작성된 시간과 현재시간 비교후 상대시간 저장
            for(var i=0;i<results.length;i++){
            relativeTime[i] = moment(results[i].created).fromNow();
             }

             res.render('roomList.ejs',{roomlist:results,relativeTime:relativeTime})
            });
         }
         else{
            //세션을통한 로그인인증이 안되었을시 창닫기
            //알림은 뜨는데 창은 안닫아짐
            res.send('<script type="text/javascript">alert("로그인후 이용해주세요"); window..close();</script>');
        }
    });
}