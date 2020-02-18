module.exports = function(app,fs)
{    
    const mysql  = require('mysql');

    var connection = mysql.createConnection({
        host     : 'localhost',
        user     : 'minchan',
        password : 'Abzz4795!',
        database : 'myWeb',
        charset  : 'utf8_general_ci',
        dateStrings: 'date'
      });
      
      connection.connect();

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

    //auth를 거쳐서 아이디가 세션에 등록되었는지 확인
    function loginCk(req,res){
        if(req.session.is_logined){
            return true;
        }else{
            return false;
        }
    }

    //auth이후 메인페이지
    app.get('/',function(req,res){
        if(loginCk(req,res)){
            var userID = req.session.userID;
            // let user_id =  '[{"user": "'+user+'"}]';
            // WHERE "user" = '+userID+'
            //채팅방테이블에서 JSON형태로 저장되어있는 아이디칼럼들중에 유저의 아이디가 있는지 검색
            // select 조건뒤에 as를 붙이면 검색한내용조건을 user로 변경해줌
        
               // userID칼럼속 ID키의 배열 전체 참조 그리고 배열내부 user키값 string중에서 userID가 존재하는지 파악
               //LIKE는 % %안에 포함되는 문자가 전체텍스트내부에 동일한 문자가 있는지 확인
            sql = 'SELECT * FROM chat WHERE userID->"$.ID[*].user" LIKE "%'+userID+'%" ORDER BY latestChat->"$.date" DESC';
            connection.query(sql, function (error, results, fields) {
            if (error) {
                console.log(error);
            }
            //시간비교 저장
            var relativeTime = new Array();
            // 채팅내용 저장
            var reply = new Array();

            //moment를 사용해서 작성된 시간과 현재시간 비교후 상대시간 저장
            for(var i=0;i<results.length;i++){
            
                if(results[i].latestChat != null){ 
                    // 가져온 아이디값들은 string으로 저장되어있음. 다시 JSON형태로 만들어야 사용하기 편함
                    var obj = results[i].latestChat;
                    var objStr = JSON.parse(obj);
                    
                    relativeTime[i] = moment(objStr.date).fromNow();
                    reply[i]=objStr.chat; 
                }
                else{
                    relativeTime[i]=""; 
                    reply[i]="채팅내용이 없습니다."; 
                }
             }

             sql = 'SELECT count(*) as total FROM chat ';
             connection.query(sql, function (error, get, fields) {
                if (error) {
                    console.log(error);
                }
                count = get[0].total;
                res.render('index.ejs',{count:count,roomlist:results,reply:reply,relativeTime:relativeTime});
            });
                
            });
        }
        else{
            //세션을통한 로그인인증이 안되었을시 창닫기
            //알림은 뜨는데 창은 안닫아짐
            res.send('<script type="text/javascript">alert("로그인후 이용해주세요"); window..close();</script>');
        }
     });
}