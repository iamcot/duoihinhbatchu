<fieldset>
    <legend>Thông tin</legend>
    <input type="text" class="date" name="tbdatefrom" placeholder="Start Day">
    <input type="text" class="date" name="tbdateto" placeholder="Stop Day">

    <input type="text" name="edit" value="" readonly="true" placeholder="ID">
    <br>
    <label> Active </label><input type="checkbox" name="tbactive">
    <br>
    <br>
    <fieldset>
        <legend>Hình ảnh</legend>
        <input id="picupload" type="file" name="files[]"
               data-url="<?= base_url() ?>main/calljupload"
               multiple>

        <table id="piclist">

        </table>
    </fieldset>
    <input type="hidden" name="currpage" value="1">
    <input type="button" value="Lưu" onclick="save()">
    <input type="button" value="Load" onclick="load(1)">
    <input type="button" value="Xóa nhập liệu" onclick="clear()">

    <div id="loadstatus" style="float:right;"></div>
</fieldset>
<fieldset>
    <legend>Danh sách</legend>
    <div id="list_game"></div>
</fieldset>
<script>
    $('.date').mask('9999-99-99 99:99:99');
    load(1);
    $('#picupload').fileupload({
        dataType: 'json',
        start: function () {
            addloadgif("#loadstatus");
        },
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                $("#piclist").append('' +
                                          '<tr>' +
                                          '<td>' +
                                          '[<a href="javascript:delpic(\'' + file.name + '\')">Xóa</a>]' +
                                          '<input datype="new" type="text" name="tbpic" value="' + file.name + '" readonly=true >' +
                                          '<input datype="new" type="text" name="tbresultvn" placeholder="Đáp án tiếng việt có dấu ">' +
                                          '<input datype="new" type="text" name="tbresult" placeholder="Đáp án tiếng việt ko dấu ">' +
                                          '<input datype="new" type="text" name="tbcountword" placeholder="Số từ"></td>' +
                                          '<td><img src="<?=base_url()?>thumbnails/' + file.name + '"></td>' +
                                          '</tr>' +
                                          '');

            });
            removeloadgif("#loadstatus");
        }
    });
    function delpic(filename) {
        var cinput = $("input[value=\"" + filename + "\"]");
        var deldb = 0;
        if (cinput.attr("datype") == "old") {
            deldb = 1;
           // addloadgif("#loadstatus");
        }
        $.ajax({
            type: "post",
            url: "<?=base_url()?>main/delfile/" + filename + "/" + deldb,
            success: function (msg) {
                if (msg == 1) {
                    $("input[value=\"" + filename + "\"]").parent().parent().remove();
                    if (deldb == 1) {
                 //       removeloadgif("#loadstatus");
                    }
                }
                else {
                    alert("Không thể xóa file, xin hãy kiểm tra lại");
                }
            }
        });
    }

    function loadoldpic() {
        $("#piclist").html("");
        var id = $("input[name=edit]").val();
        if (id == "" || id <= 0) {
            //alert("Chưa có ID Điểm dịch vụ");
            return;
        }
        $.ajax({
            type: "post",
            url: "<?=base_url()?>main/loadgamepic/" + id,
            success: function (msg) {
                if (msg == "0") console.log('ko co du lieu');
                else {
                    var pics = eval(msg);

                    $.each(pics, function (index, file) {
                        $("#piclist").append('' +
                                             '<tr>' +
                                             '<td>' +
                                             '[<a href="javascript:delpic(\'' + file.tbpic + '\')">Xóa</a>]' +
                                             '<input datype="old" type="text" name="tbpic" value="' + file.tbpic + '" readonly=true >' +
                                             '<input datype="old" type="text" name="tbresultvn" value="' + file.tbresultvn + '" placeholder="Đáp án tiếng việt có dấu ">' +
                                             '<input datype="old" type="text" name="tbresult" value="' + file.tbresult + '" placeholder="Đáp án tiếng việt ko dấu ">' +
                                             '<input datype="old" type="text" name="tbcountword" value="' + file.tbcountword + '" placeholder="Số từ"></td>' +
                                             '<td><img src="<?=base_url()?>thumbnails/' + file.tbpic + '"></td>' +
                                             '</tr>' +
                                             '');

                    });
                }
            }
        });
    }
    function savepic() {
        var id = $("input[name=edit]").val();
        if (id == "" || id <= 0) {
            alert("Chưa có ID");
            return;
        }
        updateoldpic();
        var img="";
        var resultvn = "";
        var result = "";
        var countword = "";
        $("#piclist tr").each(function () {
            $(this).find("input[datype=new]").each(function(key,value){
//                console.log(value);
                if($(value).prop("name")=="tbpic")
                    img += $(value).val()+",";
                if($(value).prop("name")=="tbresult")
                    result += $(value).val()+",";
                if($(value).prop("name")=="tbresultvn")
                    resultvn += $(value).val()+",";
                if($(value).prop("name")=="tbcountword")
                    countword += $(value).val()+",";
            });

        });
//         console.log(img);
//         console.log(result);
//         console.log(resultvn);
//         console.log(countword);

        if (img != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>main/savegamepic/" + id,
                data: "img=" + img + "&result=" + result+ "&resultvn=" + resultvn+ "&countword=" + countword,
                success: function (msg) {
                    if (msg > 0) {
                        loadoldpic();
                    }
                    else if (msg == -1) {
                        alert("Game không tồn tại");
                    }
                    else {
                        alert("Thao tác thất bại, xin kiểm tra lại");
                    }

                }
            });
        }

    }
    function updateoldpic() {
        var id = $("input[name=edit]").val();
        if (id == "" || id <= 0) {
            alert("Chưa có ID");
            return;
        }
//        updateoldpic();
        var img="";
        var resultvn = "";
        var result = "";
        var countword = "";
        $("#piclist tr").each(function () {
            $(this).find("input[datype=old]").each(function(key,value){
//                console.log(value);
                if($(value).prop("name")=="tbpic")
                    img += $(value).val()+",";
                if($(value).prop("name")=="tbresult")
                    result += $(value).val()+",";
                if($(value).prop("name")=="tbresultvn")
                    resultvn += $(value).val()+",";
                if($(value).prop("name")=="tbcountword")
                    countword += $(value).val()+",";
            });

        });

        if (img != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>main/updateoldpic/" + id,
                data: "img=" + img + "&result=" + result+ "&resultvn=" + resultvn+ "&countword=" + countword,
                success: function (msg) {
                    if (msg > 0) {
                        loadoldpic();
                    }
                    else if (msg == -1) {
                        alert("Game không tồn tại");
                    }
                    else {
                        alert("Thao tác thất bại, xin kiểm tra lại");
                    }

                }
            });
        }

    }
    function save() {
        var tbdatefrom = $("input[name=tbdatefrom]").val();
        var tbdateto = $("input[name=tbdateto]").val();
        var edit = $("input[name=edit]").val();
        var tbactive = (($("input[name=tbactive]").prop('checked')) ? 1 : 0);

        if (tbdatefrom.trim() != "" && tbdateto.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>main/savegame",
                data: "tbdatefrom=" + tbdatefrom
                          + "&tbdateto=" + tbdateto
                          + "&edit=" + edit
                          + "&tbactive=" + tbactive,
                success: function (msg) {
                    if (msg == 0) {
                        alert("Không thể lưu");
                    }
                    else if (msg > 0) {
                        if(edit == "")
                            $("input[name=edit]").val(""+msg);
                        savepic();
                        load(1);
                        clear();
                    }
                    else {
                        alert("Lỗi lưu - không xác định.")
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập du lieu");
        }
    }
    function load(page) {
        addloadgif("#loadstatus");
        $("#list_game").load("<?=base_url()?>main/adminloadgame/" + page, function () {removeloadgif("#loadstatus");});
        //loadoldpic();
        // $("input[name=currpage]").val(page);
    }
    function clear() {
        $("input[name=tbdatefrom]").val("");
        $("input[name=tbdateto]").val("");
        $("input[name=edit]").val("");
        $("input[name=tbactive]").prop('checked',false);
    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>main/loadeditgame/" + id,
            success: function (msg) {
                if (msg == "0") {
                    alert('khong co data');
                }
                else {
                    var province = eval(msg);
                    $("input[name=tbdatefrom]").val(province.tbdatefrom);
                    $("input[name=edit]").val(province.id);
                    $("input[name=tbdateto]").val(province.tbdateto);
                    $("input[name=tbactive]").prop('checked', ((province.tbactive == 1) ? true : false));
                    loadoldpic();
                }
            }
        });
    }
</script>