//댓글이 입력되었는지 확인
function checkMemo() {
    if (!document.getElementById('textarea').value) {
        alert("댓글을 입력해 주세요.");
        document.getElementById('textarea').focus();
        return true;
    } else {
        subEle = document.getElementById('textarea').value;

        if ($.trim(subEle) == "") { //앞뒤로 공백이 있는지확인
            alert("댓글을 입력해 주세요.");
            document.getElementById('textarea').focus();
            return true;
        } else {
            return false;
        }
    }
};

$(function () {
    $('#textarea').keyup(function (e) {
        var content = $(this).val();
        $('#memoLength').html(content.length + '/150');
    });
    $('#content').keyup();
});

function limitMemo(obj, cnt) {
    if (obj.value.length > cnt) {
        alert("댓글은 150자까지만 입력가능합니다.");
        obj.value = obj.value.substring(0, cnt);
        document.getElementById('memoLength').innerHTML = cnt - obj.value.length;

    }
};

// 버튼눌렀을때 작성된 댓글글자수 초기화
function zeroMemo() {
    document.getElementById('memoLength').innerHTML = "";
};