<!DOCTYPE html>
<?php session_start();?>
<html>
<head>
        <meta charset='utf-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ITdream</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../css/bootstrap-theme.css"/>
        <link rel="stylesheet" href="../css/bootstrap.css"/>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <link href="../style.css?after" rel="stylesheet" type="text/css"/>
</head>
<body>
<br>
    <!-- underLine from title -->
<div class="container">
<div class="nav">
      <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
      <div class="nav-right-items">
      <div class="nav-item"><a href="#" onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a></div>
        <div class="nav-item"><a href="review.php">리뷰</a></div>
	    <div class ="nav-item"><a href="../news/news.php?page=1">뉴스</a></div>
        <div class="nav-item"><a href="../community/community.php?page=1&list=10">커뮤니티</a></div>
        <div class="nav-item"><a href="../notice/notice.php?page=1&list=10">공지사항</a></div>

        <div class="nav-item">
        <?php include '../session_login.php' ?>
        </div>
        <div class="nav-item">
        <?php include '../session_signUp.php' ?>
        </div>
      </div>
    </div>

<div class="nav_sub">
            <div class="big-category"> 리뷰</div> 
            <div class="nav-right-items"></div>
        </div>
<table class="table table-hover">
    <thead>
        <tr>
            <th class="txt_posi">번호</th>
            <th class="txt_posi2">제목</th>
            <th  class="txt_posi">작성자</th>
            <th class="txt_day">날짜</th>
            <th class="txt_posi">조회수</th>
            </a>
        </tr>
    </thead>
    <?php
          $conn = mysqli_connect('localhost', 'minchan', 'Abzz4795!', 'myWeb');
          
          $linePerPage = 10; // 한페이지 줄수  - 한 페이지당 몇개의 글을 보여줄 것인가.
          $sql = "SELECT * FROM review ORDER BY id DESC";
          
          $result = mysqli_query($conn,$sql);
          $pageTotal = mysqli_num_rows($result);
          
          $count = $pageTotal;
          $start = $_GET['page'];
            
          $start-=1;

            if($start!=0){
                $offset= $start*10;
                $sql = "SELECT * FROM review ORDER BY id DESC limit $offset, $linePerPage";
                } else {
                    $sql = "SELECT * FROM review ORDER BY id DESC limit 0, $linePerPage";
                }
          
        $result = mysqli_query($conn,$sql);
        
        //check Board number on a page
        $Num =$pageTotal-(10*($start));

          while( $row = mysqli_fetch_array($result)){        
    ?>
    
    <tr>
    <?if($Num <= 0){ }
    else{?>
        <td class="txt_posi"><?=$Num--?></td><?
    }?>
        <td class="txt_posi2"><a href="writing_rv.php?id=<?=$row['id']?>"><?=$row['title']?></a></td>
        <td  class="txt_posi"><?=$row['nickname']?></td>
        <td class="txt_day"><?= $row['created']?></td>
        <td class="txt_posi"><?=$row['viewed']?></td>
    </tr>
    <?php
        }
    ?>
    </tbody> 
</table>
<hr/>
<!-- access to writing for logined user -->
        <?php 
          $checking=$_SESSION['user_id'];

          $admin = "SELECT * FROM super WHERE id='{$checking}'";

          $sup = mysqli_query($conn,$admin);
          if($sup == TRUE){
              $row1 = mysqli_fetch_array($sup);
          
              if(isset($row1['id']) && $checking == $row1['id']){
                  echo "<a class='btn btn-default pull-right', href='writing_review.php'>글쓰기</a>";
              }
           } 
        ?>
<td colspan="6" Align="center">
<div class="text-center">
    <ul class="pagination">
    <?php
    $pageNum = ($_GET['page']) ? $_GET['page'] : 1;     //page : default - 1
    $list = ($_GET['list']) ? $_GET['list'] : 10; //page : default - 50
 
 
    $b_pageNum_list = 10; //블럭에 나타낼 페이지 번호 갯수
    $block = ceil($pageNum/$b_pageNum_list); //현재 리스트의 블럭 구하기
    // echo $block;
 
    $b_start_page = ( ($block - 1) * $b_pageNum_list ) + 1; //현재 블럭에서 시작페이지 번호
    // echo $b_start_page;
    $b_end_page = $b_start_page + $b_pageNum_list - 1; //현재 블럭에서 마지막 페이지 번호
    // echo $b_end_page;
    $total_page =  ceil($pageTotal/$list); //총 페이지 수
    // echo $total_page;
    if ($b_end_page > $total_page) 
        $b_end_page = $total_page;
    
 
    if($pageNum <= 10){
        // echo "<li><a>처음</a></li>";
        }else{
            echo "<li><a href='review_list.php?page=1&list=$list'>처음</a></li>";    
        }
 
    if($block <=1){
        echo "<li> </li>";
        
    }else{
        $tmp=$b_start_page-1;
        echo "<li><a href='review_list.php?page=$tmp&list=$list'>이전</a></li>";
        
    }
 
    for($j = $b_start_page; $j <=$b_end_page; $j++)
    {
 
        if($pageNum == $j)
        {
            echo "<li class='page-item active'><a style='font-size:20px'>$j</a></li>";

            
        }
        else{
            echo "<li><a href='review_list.php?page=$j&list=$list'>$j</a></li>";   
          }                
 
    }
 
    $total_block = ceil($total_page/$b_pageNum_list);
     $rest_page = ceil($total_page%$b_pageNum_list); //마지막페이지에서 페이지리스트

    if($block >= $total_block){
        echo "<li> </li>";

   }else{   
    $tmp=$b_end_page+1;
    echo "<li><a href='review_list.php?page=$tmp&list=$list'>다음</a></li>";
    
    }
        //마지막 페이지에서 마지막이란 글자안뜨도록
    if($pageNum > $total_page-$rest_page){
        //  echo "<li><a>마지막</a></li>";
        }else{
            if($total_page>10){
                echo "<li><a href='review_list.php?page=$total_page&list=$list'>마지막</a></li>";
            }
        }
    ?>
    </ul>
 </div>
</div>

</body>
</html>