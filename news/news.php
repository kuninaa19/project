<!DOCTYPE html>
<?php session_start();
include '../simple_html_dom.php';
      $title_array = array();
      $address_array=array();
      $info_array = array();
      $img_array = array();
      $date_array=array();
      $t_array=array();
      $copy_array=array();

      switch($_GET['page']){
        case 1:
    //it general
      $html = file_get_html('https://news.naver.com/main/list.nhn?mode=LS2D&mid=shm&sid1=105&sid2=230');
      break;

      case 2:
      //mobile
      $html = file_get_html('https://news.naver.com/main/list.nhn?mode=LS2D&mid=shm&sid1=105&sid2=731');
      break;
      
      case 3:
      //media
      $html = file_get_html('https://news.naver.com/main/list.nhn?mode=LS2D&mid=shm&sid1=105&sid2=227');
      break;
      
      case 4:
      //internet/sns
      $html = file_get_html('https://news.naver.com/main/list.nhn?mode=LS2D&mid=shm&sid1=105&sid2=226');
      break;
      
      case 5:
      //security
      $html = file_get_html('https://news.naver.com/main/list.nhn?mode=LS2D&mid=shm&sid1=105&sid2=732');
      break;
      
      case 6:
      //computer
      $html = file_get_html('https://news.naver.com/main/list.nhn?mode=LS2D&mid=shm&sid1=105&sid2=283');
      }

      $copy = $html->find('ul.type06_headline dl');

      $img = $html->find('ul.type06_headline dt.photo');
      $title = $html->find('ul.type06_headline dt');
      $detail = $html->find('ul.type06_headline span.lede');
      $date = $html->find('ul.type06_headline span.date');

      foreach($copy as $article){
        array_push($copy_array, $article);
      }
      
        foreach($img as $article) {
          array_push($img_array, $article);                             
        }
        foreach($title as $article) {
            array_push($title_array, $article->plaintext);                
        }
        foreach($html->find('dt a') as $article) {
          $text= $article->plaintext;
          array_push($t_array, $text);                
      }
        foreach($html->find('dt a') as $article) {
            $text= $article->href;
          array_push($address_array, $text);                
        }
        
          foreach($detail as $article) {
            array_push($info_array, $article);                             
        }
        foreach($date as $article) {
          array_push($date_array, $article);                             
      }
?>
<html>
<head>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ITdream</title>
        <link rel="stylesheet" href="../css/bootstrap.css"/>
        <link  rel="stylesheet" type="text/css" href="../css/style.css"/>
</head>
<body>
<br>
    <div class="container">
    <div class="nav">
      <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
      <div class="nav-right-items">
      <div class="nav-item"><a href="#" onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a></div>
        <div class="nav-item"><a href="../review/review.php">리뷰</a></div>
	      <div class ="nav-item"><a href="news.php?page=1">뉴스</a></div>
        <div class="nav-item"><a href="../community/community.php?page=1&list=10">커뮤니티</a></div>
        <div class="nav-item"><a href="../notice/notice.php?page=1&list=10">공지사항</a></div>
        <div class="nav-item">
        <?php include '../auth/session_login.php' ?>
        </div>
        <div class="nav-item">
        <?php include '../auth/session_signUp.php' ?>
        </div>
      </div>
    </div>
    <div class="nav_sub">
            <div class="big-category">뉴스</div> 
            <div class="nav-right-items"></div>
        </div>
        <div class="nav-right-items">
          <ul class="news_subject">
            <li class="sub" style="border-bottom: 1px solid #E6E6E6;"><h4>IT<h4></li>
            <li class="sub"><a href="news.php?page=1">IT 일반</a></li>            
            <li class="sub"><a href="news.php?page=2">모바일</a></li>
            <li class="sub"><a href="news.php?page=3">통신/뉴미디어</a></li>
            <li class="sub"><a href="news.php?page=4">인터넷/SNS</a></li>
            <li class="sub"><a href="news.php?page=5">보안/해킹</a></li>
            <li class="sub"><a href="news.php?page=6">컴퓨터</a></li>
          </ul>
          <!-- 크롤링 정보 나열 -->
          <div class="sub_box">
            <ul class="newslist">
                <li class="news">
                  <dl style="margin-top:10px;">
                    <div style= "float: left; margin-right:10px;">
                      <?php 
                      $k=0;
                      $ck=0;
                      $subCk=0;
                        //image
                        if($copy_array[0]->find("dt.photo")){
                          echo $img_array[$k].'</div> <dt> <p>';
                          $k++;
                          echo "<a href='$address_array[1]'>",$title_array[1].'</a></dt>';
                        }
                        else{
                          echo '</div> <dt> <p>';
                          echo "<a href='$address_array[0]'>",$title_array[0].'</a></dt>';
                          $ck=1;
                          $subCk=1;
                        }
                        echo $info_array[0];
                        echo $date_array[0];
                        ?>
                  </dl>
                </li>
                <?php
      
                for($i=1;$i<10;$i++){
                ?>
                <li class="news">
                <dl style="margin-top:10px;">
                  <div style= "float: left; margin-right:10px;">
                    <?php 
                      //image
                      if($copy_array[$i]->find("dt.photo")){
                        echo $img_array[$k].'</div> <dt> <p>';
                        $k++;
                        // 이상하게 이미지가 없는 기사가 배치되면 제목명이 올라가지않는 경우가 발생( 왜인지는 모름) 그래서 ck를 통해서 판단
                        if($ck!=1){ 
                          // 이미지가 함께 붙은 기사는 홀수 진행되면 이미지 제목들이 제대로 배치됨
                          $j=($i*2+1);
                          echo "<a href='$address_array[$j]'>",$title_array[$j].'</a></dt>';
                      
                         
                        }
                        else{
                          // 도중에 이미지 없는 1회나오면 기사는 짝수로 변경 짝수 진행되면 제목이 제대로 배치됨
                          if($subCk<=2){
                          $j=($i*2);
                          echo "<a href='$address_array[$j]'>",$t_array[$j].'</a></dt>';
                         
                          }
                          else{
                            $j=($i*2+1-$subCk);
                          echo "<a href='$address_array[$j]'>",$t_array[$j].'</a></dt>';
                        
                          }
                        }
                      }
                      else{
                        
                        $j=($i*2-$subCk);
                        echo '</div> <dt> <p>';
                        echo "<a href='$address_array[$j]'>",$t_array[$j].'</a></dt>';
            
                        $subCk+=1;
                        $ck=1;

                      }
                      echo $info_array[$i];
                      echo $date_array[$i];
                      ?>
                </dl>
              </li>
                <?php
                }
                ?>
              </ul>
          </div>

</body>
</html>