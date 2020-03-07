// 댓글 수정하기버튼으로 변경
$(document).on("click", "#update_btn", function () {

    var id = $(this).attr("name");
    var info = {"replyNum": id, "action": "getInfo"};

    $.ajax({
        type: 'POST',
        url: 'reply_ok.php',
        data: info,
        success: function (data) {
            var res = $.parseJSON(data);
            console.log(res.id);

            $('textarea').val(res.reply);
            $('#send_btn').html(res.id);
            $('#send_btn').val("수정");
            $('#send_btn').attr('id', 'change_btn');

        }
    });
});

// 댓글 삭제
$(document).on("click", "#delete_btn", function () {

    var id = $(this).attr("name");

    var info = {"replyNum": id, "action": "delete"};
    console.log(info);

    $.ajax({
        type: 'POST',
        url: 'reply_ok.php',
        data: info,
        success: function (data) {

            if ($('#replys_form').empty()) {
                getAllList();
                $('textarea').val('');
            }
        }
    });
});
// 수정된 댓글 전송
$(document).on("click", "#change_btn", function () {

    if (!checkMemo()) {
        zeroMemo();
        var id = $('#change_btn').text();

        console.log(id);
        var text = $('textarea').val();
        console.log(text);


        var info = {"replyNum": id, "reply": text, "action": "update"};
        $.ajax({
            type: 'POST',
            url: 'reply_ok.php',
            data: info,
            success: function (data) {

                if ($('#replys_form').empty()) {
                    getAllList();
                    $('textarea').val('');
                    $('#change_btn').html('');
                    $('#change_btn').val("등록");
                    $('#change_btn').attr('id', 'send_btn');
                }
            }
        });
    }
});

// 댓글 전송
$(document).on("click", "#send_btn", function () {

    if (!checkMemo()) {
        zeroMemo();
        var formData = $("#reply_form").serialize();
        console.log(formData);

        $.ajax({
            type: 'POST',
            url: 'reply_ok.php',
            data: formData,
            success: function (data) {
                console.log(data);

                if ($('#replys_form').empty()) {
                    getAllList();
                    $('textarea').val('');
                }
            }
        });
    }
});