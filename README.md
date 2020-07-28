# ITdream - IT/전자기기 웹사이트   

IT에 관심있는 모든 사람들이 즐길 수 있는 IT놀이터를 목적으로 웹사이트를 만들었습니다.   

IT dream은 최신 IT 관련뉴스와 전자기기 언박싱 및 리뷰를 볼 수 있는 웹사이트입니다.   

또한 유저들과 소통할 수 있는 커뮤니티와 채팅할 수 있는 공간이 있습니다.   

<br /><br/>
   
## 프로젝트 정보
개발 인원 :　1인 개발   

개발 기간 :　대략 10주   

Front-end : HTML/CSS, JS, jQuery   

Back-End : PHP, Node.js, Apache, Mysql   

Environment : Virtual Box, Ubuntu   

   
<br /><br/>

## 기능
1. 게시판 CRUD
2. 게시판 페이지네이션
3. 댓글 CRUD, 회원가입시 개인정보 중복검사 - jQuery AJAX
4. 네이버 IT 뉴스 크롤링 - php simple html dom parser
5. 다중 인원 채팅 - Node.js socket io
6. 임시 비밀번호 전송 - php sendmail
   
   
<br /><br/>

## 스크린샷
<h4>1. jQuery AJAX 메서드를 사용한 비동기식 댓글 조회, 추가, 수정, 삭제(CRUD)</h4>   
<br/>
<p align="center"> <img src="https://user-images.githubusercontent.com/59405784/88635381-8cbbc380-d0f2-11ea-8364-63d3d14be680.jpg" width="800px" height="300px" title="댓글 CRUD" alt="댓글 구현"></img></p>      

<p align ="center"> <게시판 내부 댓글> </p>   

사용자가 로그인 되어있다면 게시글에 댓글 작성이나 수정 삭제 할 수 있도록 했습니다.   
또한 댓글 작성중 댓글 입력창 내부의 글자수를 표기해서 얼마나 댓글을 작성했는지 인지하기 쉽도록 했습니다.   
   
   <br/>   
   
   <br/>   
   
<h4>2. 각 게시판 페이지네이션 구현</h4>   

<br/>

<p align="center"><img src="https://user-images.githubusercontent.com/59405784/88636065-69dddf00-d0f3-11ea-9923-aae7e68e9204.jpg"  title="페이지 1" alt="페이지네이션"></img></;</p> <br/>
<p align="center"><페이지1></p>

<p align="center"><img src="https://user-images.githubusercontent.com/59405784/88636078-6cd8cf80-d0f3-11ea-9b0c-44967df7f6d0.jpg"  title="마지막 페이지" alt="페이지네이션"></img></p> <br/>
<p align="center"><마지막 페이지></p>
    
    
사용자가 보고 있는 페이지는 파란색으로 표시해 현재페이지를 인지하기 쉽도록 했습니다.   
이전, 다음을 눌러서 10페이지씩 이동할 수 있도록 했습니다.   
   
   <br/>
<h4>3. 커뮤니티, 리뷰페이지에서 세션처리를 통한 조회 수 처리</h4>   

<br/>

<p align="center"><img src="https://user-images.githubusercontent.com/59405784/88636919-7c0c4d00-d0f4-11ea-9e7c-219846413d16.jpg"  width="700px" title="세션저장내용" alt="조회수 처리"></img></p>
<p align="center"><유저 세션 저장 내용></p>   
   
사용자의 로그인과 관계없이 메인페이지에서 게시글 조회내역확인을 위한 세션생성합니다.   
세션을 통해 게시글을 새로고침하거나 반복조회에도 조회수가 올라가지않도록 했습니다.   
사용자가 게시글에 접속시 url의 쿼리스트링 id파라미터값을 가져와서 세션에 저장하고 입장시마다 세션내용을 확인하도록 하였습니다.   

<br/>
<h4>4. 채팅</h4>   

<br/>   

<p align="center"><img src="https://user-images.githubusercontent.com/59405784/88638539-97785780-d0f6-11ea-8527-3212d05e9c87.png"  width="800px" title="채팅방 검색, 채팅목록" alt="채팅"></p></img>
<p align="center"><img src="https://user-images.githubusercontent.com/59405784/88638796-ef16c300-d0f6-11ea-961c-6e64c43a3cdf.jpg"  width="800px" title="실시간 채팅" alt="채팅"></img></p><br />

<채팅방목록> 설명   
참여했던 채팅목록들의 마지막 채팅과 시간(일, 시간, 분,초 단위)을 채팅방 이름과 함께 표시되도록 하였습니다.   

<채팅방 검색> 설명   
채팅방이름을 검색할 수 있도록 하였습니다. 이를 통해 사용자가 자신의 목적에 맞는 채팅방에 들어갈 수 있도록 하였습니다.   

<실시간 채팅> 설명   
채팅방 우측상단에 현재 접속중인 유저 인원이 표시됩니다.   
자신의 채팅내용은 오른쪽에 배치되도록 했습니다. 다른 사용자는 좌측에 배치되며 사용자의 닉네임을 볼 수 있도록 하였습니다.   
실시간 채팅은 socket i.o로 구현하였습니다. 사용자는 각 채팅방마다 따로 룸에 참여하게 되고 채팅내용이 서로 겹치지 않도록 했습니다.   
컬럼으로 검색하고 추가할 때 시행착오를 많이 겪었는데 이를 통해 mySql 조건에 따른 다양한 query문을 사용해보았습니다.   
저장된 json을 파싱하고 객체변환해보면서 json에 대해서 많은 공부를 할 수 있었습니다.

   
<br/>
<h4>5. 뉴스 크롤링</h4>   

<br/>

<p align="center"><img src="https://user-images.githubusercontent.com/59405784/88639787-2174f000-d0f8-11ea-901e-36830168aa8b.jpg"  title="뉴스 크롤링" alt="크롤링"></img></p><br />   

네이버 IT뉴스를 모방하여 만든 카테고리로 사용자들이 실시간으로 최신 IT기사를 테마별로 볼 수 있도록 하였습니다.  
php simple html dom Parser를 사용하여 구현하였습니다.   
링크페이지에서 정보를 크롭하고 html 태그에 맞춰서 정보를 가져오도록 하였습니다. 가져온 정보들을 배열에 저장하였습니다.   

