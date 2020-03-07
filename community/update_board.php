<!DOCTYPE html>
<?php session_start();
include_once('../db.php');
$number = $_GET['id'];

$sql = "SELECT * FROM topic WHERE id=$number";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITdream</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css"/>
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<br>
<div class="container">
    <div class="nav">
        <div class="big-category"><a href="../index.php"><img src="/smarteditor/upload/wefewfew.jpg" width="200px"
                                                              height="50px"></a></div>
        <div class="nav-right-items">
            <div class="nav-item"><a href="#" onclick="window.open('http://localhost:8080/auth', '대화방','width=570px height=670px'); return false">채팅</a>
            </div>
            <div class="nav-item"><a href="../review/review.php">리뷰</a></div>
            <div class="nav-item"><a href="../news/news.php?page=1">뉴스</a></div>
            <div class="nav-item"><a href="community.php?page=1&list=10">커뮤니티</a></div>
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
        <div class="big-category"> 글수정</div>
        <div class="nav-right-items"></div>
    </div>

    <form action="updating_board_ok.php" name="Wform" method="post" accept-charset="utf-8">
        <table class="table table-bordered">
            <thead>
            </thead>
            <tr>
                <th>제목</th>
                <td><input type="text" placeholder="제목을 입력해 주세요." id="subject" name="subject" class="form-control"
                           value="<?= $row['title'] ?>"/></td>
            </tr>
            <tr>
                <th>내용</th>
                <td>
                    <?php
                    // DB내 내용 칼럼의 항목을 가져와서 에디터 내에 뿌려 주기 위해 소스 정리한다.
                    $content = preg_replace("/\r\n|\n/", '', stripslashes($row['description']));
                    $content = str_replace("'", "\'", $content);
                    $content = str_replace('"', '\"', $content);
                    ?>
                    <textarea name="content" id="content" rows="10" cols="100"
                              style="width:700px; height:500px; display:none;width:100%">
              </textarea>
                    <script type="text/javascript">
                        var oEditors = [];
                        var sLang = "ko_KR"; // 언어 (ko_KR/ en_US/ ja_JP/ zh_CN/ zh_TW), default = ko_KR
                        // 추가 글꼴 목록
                        //var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];
                        nhn.husky.EZCreator.createInIFrame({
                            oAppRef: oEditors,
                            elPlaceHolder: "content",
                            sSkinURI: "/smarteditor/SmartEditor2Skin.html",
                            htParams: {
                                bUseToolbar: true,    // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                                bUseVerticalResizer: true,  // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                                bUseModeChanger: true,   // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                                //bSkipXssFilter : true,  // client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
                                //aAdditionalFontList : aAdditionalFontSet,  // 추가 글꼴 목록
                                fOnBeforeUnload: function () {
                                    //alert("완료!");
                                },
                                I18N_LOCALE: sLang
                            }, //boolean
                            fOnAppLoad: function () {
                                //예제 코드
                                oEditors.getById["content"].exec("PASTE_HTML", [""]);
                                oEditors.getById["content"].exec("PASTE_HTML", ["<?=$content?>"]);

                            },
                            fCreator: "createSEditor2"
                        });

                    </script>
                    <script src="../js/updateEditor.js"></script>
                </td>
            </tr>
            </tr>
            </tbody>
        </table>
        <hr/>
        <input type="hidden" name="nickname" value=<?= $_SESSION['user_name'] ?>>
        <input type="hidden" name="id" value=<?= $number ?>>
        <input type="button" onClick="submitContents(this);" class="btn btn-default pull-right" value="수정 완료"/>
    </form>
</div>
<div style="margin:100px"></div>
</body>
</html>

   