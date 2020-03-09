<!DOCTYPE html>
<?php
include_once('db.php');

if (isset($_COOKIE["id"]) && isset($_COOKIE["nickname"])) {
// get id and nickname from cookie
    include 'crypt.php';
    $decrypted1 = Decrypt($_COOKIE["id"], $secret_key, $secret_iv);
    $decrypted2 = Decrypt($_COOKIE["nickname"], $secret_key, $secret_iv);

    session_start();
    $_SESSION['user_id'] = $decrypted1;
    $_SESSION['user_name'] = $decrypted2;
//    $_SESSION['cnt_list'];

} else {
     session_start();
//    $_SESSION['cnt_list'];
}
include_once 'simple_html_dom.php';

$news_array = array();
$picture_array = array();
$address_array = array();
$semina_array = array();

$html = file_get_html('https://news.naver.com/main/main.nhn?mode=LSD&mid=shm&sid1=105');
$html2 = file_get_html('https://www.sharedit.co.kr/seminars');

foreach ($html->find('div[id=ranking_105] a') as $article) {
    $text = $article->plaintext;
    array_push($news_array, $text);
}
foreach ($html->find('div[id=ranking_105] a') as $article) {
    $text = $article->href;

    array_push($address_array, $text);
}
foreach ($html2->find('background-image') as $article) {

    echo $article->plaintext;
    array_push($picture_array, $article);
}
foreach ($html2->find('span.sponsor') as $article) {
    $text = $article->plaintext;
    array_push($semina_array, $text);
}
foreach ($html2->find('h1.margin-bottom') as $article) {
    $text = $article->plaintext;
    echo $text;
}

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITdream</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <style>
        /* Make the image fully responsive */
        .carousel-inner img {
            width: 1100px;
            height: 400px;
        }
    </style>
</head>
<body>
<br>
<div class="container">
    <div class="nav">
        <div class="big-category"><a href="index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px"
                                                           height="50px"></a></div>
        <div class="nav-right-items">
            <div class="nav-item"><a href="#"
                                     onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a>
            </div>
            <div class="nav-item"><a href="review/review.php">리뷰</a></div>
            <div class="nav-item"><a href="news/news.php?page=1">뉴스</a></div>
            <div class="nav-item"><a href="community/community.php?page=1&list=10">커뮤니티</a></div>
            <div class="nav-item"><a href="notice/notice.php?page=1&list=10">공지사항</a></div>
            <div class="nav-item">
                <?php include 'auth/session_login.php' ?>
            </div>
            <div class="nav-item">
                <?php include 'auth/session_signUp.php' ?>
            </div>
        </div>
    </div>

    <div id="demo" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        <p>
            <!-- The slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/smarteditor/upload/201911121042091784148361.jpg" alt="Los Angeles" width="50" height="50">
                <div class="carousel-caption" style="font-color=#848484">
                    <!-- <h3>SAP코리아</h3>
                    <h2>지능형 비서가 탑재된 SMART ERP, SAP S/4HANA 1909를 소개합니다. _11월 20일(수)</h2>

                    <p>2019-11-20(수) 14:00 ~ 15:00</p> -->
                </div>
            </div>
            <div class="carousel-item">
                <img src="/smarteditor/upload/201911121042091427946911.png" alt="Chicago" width="50" height="50">
                <div class="carousel-caption" style="font-color=#424242">
                    <!-- <h3>VMware</h3>
                    <h2>VMware vFORUM 2019에 귀하를 초대합니다.</h2>

                    <p>2019-11-19(화) 07:30 ~ 17:00</p> -->
                </div>
            </div>
            <div class="carousel-item">
                <img src="/smarteditor/upload/2019111210420957185430.jpg" alt="New York" width="50" height="50">
                <div class="carousel-caption" style="font-color=#848484">
                    <!-- <h3>AWS | 아마존웹서비스</h3>
                    <h2>AWS와 APN 파트너사 삼성 SDS가 함께하는 온라인 세미나 | 실 적용 사례로 확인하는 AWS 보안의 장점 </h2>
                    <p>2019-11-14(목) 11:00 ~ 12:00</p> -->
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>

    <div class="nav_sub" style="margin-top:20px">
        <div class="big-category"><a href="review/review.php?page=1&list=10"> 최근리뷰</a></div>
    </div>
    <p>

        <!-- 리뷰 뿌리기 4개씩 -->
    <div class="nav-right-items" style="margin-top:30px;  margin-bottom:20px;">

        <?php
        $linePerPage = 4; // 한페이지 줄수  - 한 페이지당 몇개의 글을 보여줄 것인가.
        $sql = "SELECT * FROM review UNION SELECT * FROM unboxing";
        $rs_review = mysqli_query($conn, $sql);
        $pageTotal = mysqli_num_rows($rs_review);

        if ($pageTotal < $linePerPage) {
            $sql = "SELECT * FROM review UNION SELECT * FROM unboxing  ORDER BY created DESC limit 0, $pageTotal";
        } else {

            $sql = "SELECT * FROM review UNION SELECT * FROM unboxing  ORDER BY created DESC limit 0, $linePerPage";
        }
        $result = mysqli_query($conn, $sql);


        while ($row = mysqli_fetch_array($result)) {
            ?>

            <div class="imgBoxDiv" style="margin-left:20px;">
                <?php
                if ($row['getN'] == 0) { // 리뷰 echo 내부 $row사용시 "{$row['xx']}"사용(작성형식)

                    if ($row['video'] != "") {
                        $url = $row['video'];
                        if ($url != "") {
                            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
                            $id = $matches[1];
                            $width = '80%';
                            $height = '450px';

                            echo "<div class='imgDiv'><a href='review/review/boardPage.php?id=" . $row['id'] . "'><img src='http://img.youtube.com/vi/$id/maxresdefault.jpg' width='100%' height='100%'></div>";
                        }
                    } else {
                        // $imgAddress = str_replace('width="600px;"','',$row['sumnail']);

                        $imgAddress1 = str_replace('width', '', $row['sumnail']); // width 가리기
                        $imgAddress = str_replace('height', '', $imgAddress1); //height 가리기

                        echo "<div class='imgDiv'><a href='review/review/boardPage.php?id=" . $row['id'] . "'><img src=" . $imgAddress . "width='100%' height='100%'></div>";

                    }

                } else if ($row['getN'] == 1) { //언박싱 echo 내부 $row사용시 "{$row['xx']}"사용

                    if ($row['sumnail'] != "") {
                        $imgAddress = str_replace('width="600px;"', '', $row['sumnail']);

                        echo "<div class='imgDiv'><a href='review/unboxing/boardPage.php?id=" . $row['id'] . "'><img src=" . $imgAddress . "width='100%' height='100%'></div>";
                    } else if ($row['video'] != "") {
                        $url = $row['video'];
                        if ($url != "") {
                            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
                            $id = $matches[1];
                            $width = '80%';
                            $height = '450px';

                            echo "<div class='imgDiv'><a href='review/unboxing/boardPage.php?id=" . $row['id'] . "'><img src='http://img.youtube.com/vi/$id/maxresdefault.jpg' width='100%' height='100%'></div>";
                        }
                    } else {
                        echo "<div class='imgDiv'><a href='review/unboxing/boardPage.php?id=" . $row['id'] . "'><img src=" . $row['sumnail'] . "width='100%' height='100%'></div>";

                    }

                } ?>
                <div class="imgDescDiv"><?= $row['title'] ?></div>

            </div>
            <?php
        }
        ?>
    </div>
    <p>
        <!-- 리뷰뿌리기 끝 -->

    <div class="nav_sub">
        <div class="big-category"><a href="news/news.php"> 가장 많이 본 뉴스</a></div>
        <div class="middle-category"><a href="community/community.php?page=1&list=10"> 커뮤니티</a></div>
        <div class="last-category"><a href="notice/notice.php?page=1&list=10"> 공지사항</a></div>

        <div class="nav-right-items"></div>
    </div>
    <div class="nav-right-items">
        <div class="newsbox">
            <ul class="mylist">
                <!-- news -->
                <?php
                for ($i = 0; $i < 10; $i++) {
                    ?>
                    <li class="index">
                        <?php
                        echo "<a href='https://news.naver.com$address_array[$i]'>", $news_array[$i] . '</a>';
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <!-- community -->
        <div class="minibox">
            <!-- 커뮤니티 리스트 출력 -->
            <ul class="mylist">
                <?php
                $linePerPage = 15; // 한페이지 줄수  - 한 페이지당 몇개의 글을 보여줄 것인가.
                $topic = "SELECT * FROM topic ORDER BY id DESC";
                $rs_topic = mysqli_query($conn, $topic);
                $pageTotal = mysqli_num_rows($rs_topic);

                if ($pageTotal > $linePerPage) {
                    $sql = "SELECT * FROM topic ORDER BY id DESC limit 0, $linePerPage";
                } else {

                    $sql = "SELECT * FROM topic ORDER BY id DESC limit 0, $pageTotal";
                }
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    ?>

                    <!-- while문을통한 링크출력 -->

                    <li class="index"><a href="community/boardPage.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></li>

                    <?php
                }
                ?>

            </ul>
        </div>

        <!-- notice -->
        <div class="minibox">
            <ul class="mylist">
                <?php
                $linePerPage = 15; // 한페이지 줄수  - 한 페이지당 몇개의 글을 보여줄 것인가.
                $notice = "SELECT * FROM notice ORDER BY id DESC";
                $rs_notice = mysqli_query($conn, $notice);
                $pageTotal = mysqli_num_rows($rs_notice);

                if ($pageTotal > $linePerPage) {
                    $sql = "SELECT * FROM notice ORDER BY id DESC limit 0, $linePerPage";
                } else {

                    $sql = "SELECT * FROM notice ORDER BY id DESC limit 0, $pageTotal";
                }
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <li class="index"><a href="notice/boardPage.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<div style="margin:70px"></div>
</body>
</html>