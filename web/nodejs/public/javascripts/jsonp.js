$(function(){
    $.ajax({
				//호출할 원격URL
			    url : "http://localhost:80/Ck.php",
				//jsonp방식
                dataType : "jsonp",
                crossOrigin: true,
			    jsonp : "callback",
				async: false,
				//success는 일반 json 방식과 같음
			    success : function(data){
                    console.log("result data object",data);
                    
                    var userID = data;
                    document.write(data);
			    }
        });
    });