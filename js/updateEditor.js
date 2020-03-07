function pasteHTML() {
    var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
    oEditors.getById["content"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
    var sHTML = oEditors.getById["content"].getIR();
    alert(sHTML);
}

function submitContents(elClickedObj) {
    oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.
    //  oEditors2.getById["content_chn"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.

    // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.

    var subCheck = 0;
    try {

        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.
        if (!Wform.subject.value) {
            alert("글제목을 입력해 주세요.");
            Wform.subject.focus();
            return;
        } else {
            subEle = Wform.subject.value;

            if ($.trim(subEle) != "") {
                // console.log("작성내용있음");
                subCheck = 1;
            } else {
                // console.log("모두 빈칸임");
                alert("글제목을 입력해 주세요.");
                Wform.subject.focus();
                return;

            }
        }

        // 1차 검사
        if (document.getElementById("content").value == "<p>&nbsp;</p>" || document.getElementById("content").value == " ") {
            alert("내용을 입력해 주세요.");
            oEditors.getById["content"].exec("FOCUS", []);
            return;
        } else {
            // 2차검사 모든 태그와 띄어쓰기를 제거후에 내용이있는지 확인
            var element = document.getElementById("content").value;
            // console.log("맨처음"+element);

            text = element.replace(/&nbsp; /ig, "");
            // console.log("&nbsp; 삭제"+text);

            text1 = text.replace(/&nbsp;/ig, "");
            // console.log("&nbsp;삭제"+text1);

            text2 = text1.replace(/<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/ig, "");

            // console.log("<p>삭제"+text2);

            if (text2 != "" && subCheck == 1) {
                // console.log("작성내용있음");
                elClickedObj.form.submit();
            } else {
                // console.log("모두 빈칸임");
                alert("내용을 입력해 주세요.");
                oEditors.getById["content"].exec("FOCUS", []);
                return;

            }
        }
    } catch (e) {
        alert(e);
    }
}

function setDefaultFont() {
    var sDefaultFont = '궁서';
    var nFontSize = 24;
    oEditors.getById["content"].setDefaultFont(sDefaultFont, nFontSize);
}

function writeReset() {
    document.f.reset();
    oEditors.getById["content"].exec("SET_IR", ["<?=$content?>"]);

}