<?php
session_start();
include_once('../../db.php');
include_once('viewed_ck.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITdream</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.css"/>
    <link href="../../css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<br>
<div class="container">
    <div class="nav">
        <div class="big-category"><a href="../../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px"
                                                                 height="50px"></a></div>
        <div class="nav-right-items">
            <div class="nav-item"><a href="#"
                                     onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a>
            </div>
            <div class="nav-item"><a href="../review.php">리뷰</a></div>
            <div class="nav-item"><a href="../../news/news.php?page=1">뉴스</a></div>
            <div class="nav-item"><a href="../../community/community.php?page=1&list=10">커뮤니티</a></div>
            <div class="nav-item"><a href="../../notice/notice.php?page=1&list=10">공지사항</a></div>
            <div class="nav-item">
                <?php include '../../auth/session_login.php' ?>
            </div>
            <div class="nav-item">
                <?php include '../../auth/session_signUp.php' ?>
            </div>
        </div>
    </div>

    <div class="nav_sub">
        <div class="big-category">언박싱</div>
        <div class="nav-right-items"></div>
    </div>

    <table class="table table-bordered">
        <thead>
        </thead>
        <tr>
            <th class="txt_posi">제목</th>
            <th colspan="3" class="txt_posi3"><?= $row['title'] ?></th>
            <th class="txt_posi">조회</th>
            <th class="txt_count"><?= $row['viewed'] ?></th>

        </tr>

        <tr>
            <th class="txt_posi">이름</th>
            <th class="txt_posi2"><?= $row['nickname'] ?></th>
            <th class="txt_posi">날짜</th>
            <th class="txt_day"><?= $row['created'] ?></th>
            <th class="txt_posi">댓글</th>
            <th class="txt_count" id="replyNum"><?= $Count ?></th>
        </tr>

        <tr>
            <td colspan="6" class="txt_write"> <?= $row['description'] ?></td>
        </tr>
        <!-- 동영상 -->
        <?php $url = $row['video'];
        // video주소가 DB에 저장되어있다면
        if ($url != "") {
            preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
            $id = $matches[1];
            $width = '80%';
            $height = '450px';

            echo "<tr>";
            echo "<td colspan='6'>";
            echo "<object width='80%' height='500'>";
            // 화면보여짐
            echo "<iframe id='ytplayer' type='text/html' width='$width' height='$height' src='https://www.youtube.com/embed/$id?rel=0&showinfo=0&color=white&iv_load_policy=3' frameborder='0' allowfullscreen></iframe>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <hr/>
    <!-- declare class setting to "pull-right", maked button reversed -->
    <?php
    $checking = $_SESSION['user_id'];

    $admin = "SELECT * FROM super WHERE id='{$checking}'";

    $sup = mysqli_query($conn, $admin);
    if ($sup == TRUE) {
        $row1 = mysqli_fetch_array($sup);

        if (isset($row1['id']) && $checking == $row1['id']) {
            echo "<a class='btn btn-default pull-right' id= 'btn_margin' onclick='return confirm('정말로 삭제하시겠습니까?')' href='./delete_board_ok.php?id=$number'>삭제</a>";
            echo "<a class='btn btn-default pull-right' href='./update_board.php?id=$number'>수정</a>";

            //  관리자인지 검증작업
            $superCk = "SELECT * FROM super WHERE id='{$checking}'";
            $confirm2 = mysqli_query($conn, $superCk);
            if ($confirm2 == TRUE) {
                $super = mysqli_fetch_array($confirm2);
            }
            FUNCTION hello()
            {
                echo "<script> if (confirm('이 버튼에 대한 동작을 수행합니다. 계속합니까?')) {
           // 확인 버튼 클릭 시 동작
           alert('동작을 시작합니다.');
       } else {
           // 취소 버튼 클릭 시 동작
           alert('동작을 취소했습니다.');
       }
           </script>";
            }
        }
    }
    ?>

    <!-- 댓글 바 -->

    <br></br>
    <div style="margin:10px 0px 5px 0px; border-bottom: 1px solid #E6E6E6;"></div>
    <div class="big-category" style="font-size:16px; padding:5px 0px 0px 0px;">댓글
        <div style="display: inline-block" id="replyNum2"><?= $Count ?></div>
    </div>
    <div class="nav-right-items"></div>
    <div style="margin-top:5px; border :0.5px solid #E6E6E6;"></div>
    <div class="reply_box">

        <!-- 댓글정보 가져오기 -->
        <script>
            $(document).ready(function () {
                getAllList();
            });

            var str = "";
            var count = 0;

            // 댓글 전부 업로드
            function getAllList() {
                $.getJSON("reply_list.php?board=<?=$number?>", function (data) {
                    console.log(data);
                    $(data).each(function () {
                        count += 1;

                        if (this.user_id == "<?=$_SESSION['user_id']?>") {
                            str += "<li class='reply'>" +
                                "<div class='replyText'>" + this.nickname + "<p class='dayfont'>" + this.created +
                                "<p class='replybutton'>" +
                                "<input type='button' name='" + this.id + "' id='update_btn' value='수정'>" +
                                "<div class='replybutton' style='margin-left:20px;'>" +
                                "<input type='button' name='" + this.id + "' id='delete_btn'  value='삭제'>" +
                                "</div>" +
                                "</div>" +
                                this.reply + "<div style='display:none' id='user_id'>" + this.user_id + "</div></li>";
                        }
                        //슈퍼유저의 댓글 삭제
                        else if ("<?=$super['id']?>" === "<?=$_SESSION['user_id']?>" && "" != "<?=$_SESSION['user_id']?>") {
                            str += "<li class='reply'>" +
                                "<div class='replyText'>" + this.nickname + "<p class='dayfont'>" + this.created +
                                "<p class='replybutton'>" +
                                "<input type='button' name='" + this.id + "' id='delete_btn'  value='삭제'>" +
                                "</div>" +
                                this.reply + "<div style='display:none' id='user_id'>" + this.user_id + "</div></li>";
                        } else {
                            str += "<li class='reply'>" +
                                "<div class='replyText'>" + this.nickname + "<p class='dayfont'>" + this.created +

                                "</div>" +
                                "</div>" +
                                this.reply + "<div style='display:none' id='user_id'>" + this.user_id + "</div></li>";

                        }


                    });
                    $("#replys_form").html(str);
                    $("#replyNum").html(count);
                    $("#replyNum2").html(count);

                });
                str = "";
                count = 0;
            }
        </script>
        <script type="text/javascript" src="../../js/reply.js"></script>

        <ul class="replylist" id="replys_form">
        </ul>
    </div>

    <?php if (isset($_SESSION['user_id'])) { ?>

    <div class="chat_box">
        <!-- 글자수제한 및 엔터 제한 -->
        <script type="text/javascript" src="../../js/replyCk.js"></script>

        <form name="replyContent" method="post" id="reply_form">
            <div class="wrap">
          <textarea row="1" cols="100" class="replyarea" id='textarea' maxlength="150" name="memo"
                    onKeyPress="javascript: if (event.keyCode==13) return false;"
                    onKeyUp="javascript: limitMemo(this, 150);"
                    placeholder="댓글을 150자 이내로 작성해주세요."></textarea>
                <span id="memoLength"></span>
            </div>
            <div class="chatbutton">
                <input type="hidden" name="board_num" value=<?= $number ?>>
                <input type="button" class="medium-btn" name="action" id="send_btn" value="등록"/>
            </div>
    </div>
    </form>
</div>
<?php
}
?>
<!-- container div -->
</div>
<!-- 아래 비우기 -->
</div>
<div style="margin:100px"></div>
</body>
</html>

   