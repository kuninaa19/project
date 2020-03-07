<!DOCTYPE html>
<?php session_start();
include_once('../db.php');

?>
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
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<br>
<div class="container">
    <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px" height="50px"></a></div>
        <div class="nav-right-items">
            <div class="nav-item"><a href="#"
                                     onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a>
            </div>
            <div class="nav-item"><a href="review.php">리뷰</a></div>
            <div class="nav-item"><a href="../news/news.php?page=1">뉴스</a></div>
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
        <div class="big-category"><a href="unboxing.php?page=1&list=10">언박싱</div>
        </a>
        <div class="nav-right-items"></div>
    </div>
    <div class="flex-item" style="margin-top:30px; margin-bottom:20px;">
        <?php
        $linePerPage = 4; // 한페이지 줄수  - 한 페이지당 몇개의 글을 보여줄 것인가.
        $sql = "SELECT * FROM unboxing ORDER BY id DESC";
        $rs_unboxing = mysqli_query($conn, $sql);
        $pageTotal = mysqli_num_rows($rs_unboxing);

        if ($pageTotal < $linePerPage) {
            $sql = "SELECT * FROM unboxing ORDER BY id DESC limit 0, $pageTotal";
        } else {

            $sql = "SELECT * FROM unboxing ORDER BY id DESC limit 0, $linePerPage";
        }
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="imgBoxDiv" style="margin-left:30px;">
                <?php
                if ($row['sumnail'] != "") {
                    $imgAddress1 = str_replace('width', '', $row['sumnail']); // width 가리기
                    $imgAddress = str_replace('height', '', $imgAddress1); //height 가리기
                    // $imgAddress = str_replace('width="600px;"','',$row['sumnail']);

                    echo "<div class='imgDiv'><a href='writing_ubx.php?id=" . $row['id'] . "'><img src=" . $imgAddress . "width='100%' height='100%'></div>";
                } else if ($row['video'] != "") {
                    $url = $row['video'];
                    if ($url != "") {
                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
                        $id = $matches[1];
                        $width = '80%';
                        $height = '450px';

                        echo "<div class='imgDiv'><a href='writing_ubx.php?id=" . $row['id'] . "'><img src='http://img.youtube.com/vi/$id/maxresdefault.jpg' width='100%' height='100%'></div>";
                    }
                } else {
                    echo "<div class='imgDiv'><a href='writing_ubx.php?id=" . $row['id'] . "'><img src=" . $row['sumnail'] . "width='100%' height='100%'></div>";

                }

                ?>
                <div class="imgDescDiv"><?= $row['title'] ?></div>
            </div>
            <?php
        }
        ?>

    </div>

    <div class="nav_sub">
        <div class="big-category"><a href="review_list.php?page=1&list=10"> 리뷰</div>
        </a>
        <div class="nav-right-items"></div>
    </div>
    <div class="flex-item" style="margin-top:30px; margin-bottom:20px;">
        <?php
        $linePerPage = 4; // 한페이지 줄수  - 한 페이지당 몇개의 글을 보여줄 것인가.
        $sql = "SELECT * FROM review ORDER BY id DESC";
        $rs_review = mysqli_query($conn, $sql);
        $pageTotal = mysqli_num_rows($rs_review);

        if ($pageTotal < $linePerPage) {
            $sql = "SELECT * FROM review ORDER BY id DESC limit 0, $pageTotal";
        } else {

            $sql = "SELECT * FROM review ORDER BY id DESC limit 0, $linePerPage";
        }
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
            ?>
            <div class="imgBoxDiv" style="margin-left:30px;">
                <?php

                if ($row['video'] != "") {
                    $url = $row['video'];
                    if ($url != "") {
                        preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
                        $id = $matches[1];
                        $width = '80%';
                        $height = '450px';

                        echo "<div class='imgDiv'><a href='writing_rv.php?id=" . $row['id'] . "'><img src='http://img.youtube.com/vi/$id/maxresdefault.jpg' width='100%' height='100%'></div>";
                    }
                } else {
                    // $imgAddress = str_replace('width','',$row['sumnail']); // width 가리기

                    $imgAddress1 = str_replace('width', '', $row['sumnail']); // width 가리기
                    $imgAddress = str_replace('height', '', $imgAddress1); //height 가리기
                    echo "<div class='imgDiv'><a href='writing_rv.php?id=" . $row['id'] . "'><img src=" . $imgAddress . "width='100%' height='100%'></div>";

                }
                ?>
                <div class="imgDescDiv"><?= $row['title'] ?></div>
            </div>
            <?php
        }
        ?>
    </div>

</body>
</html>