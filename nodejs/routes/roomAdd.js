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

    app.get('/roomAdd',function(req,res){
        res.render('roomAdd.ejs')
     });

     //방만들기 완료되었을때 처리
     app.post('/roomAdd/done',function(req,res){
         
        //done에 입장시 서울시간을 파악
        const moment = require('moment');
        require('moment-timezone');
        moment.tz.setDefault("Asia/Seoul");
        var date = moment().format('YY-MM-DD HH:mm');
        // console.log(date);

        let body = req.body; //방만들때 받은 제목, 내용 작성자..등등
        let title = body.subject;
        let description = body.content;
        var user = req.session.userID;
        //유저아이디 JSON형태.. 변수바깥에는 ""로 감싸져야됨.(숫자제외)
        // JSON 배열 형태로 Key에 맞춰서 값이 있고 이 값은 배열형태로 구성되어있음.
        let user_id =  '{"ID" : [{"user" : "'+user+'"}]}';
        
        //query를 통해 mysql에 데이터저장
        sql = 'INSERT into chat (title, description,created,userID) values (?,?,?,?)';
        connection.query(sql,
        [title,description,date,user_id], function (error, results, fields) {
        if (error) {
            console.log(error);
            res.redirect('/');
        }
            res.redirect('../room/chat?id='+results.insertId+'');
        });
     });

     
}