<fieldset>
    <legend>Thông tin</legend>
    <input type="text" class="date" name="tbdatefrom" placeholder="Start Day">
    <input type="text" class="date" name="tbdateto" placeholder="Stop Day">

    <input type="text" name="edit" value="" readonly="true" placeholder="ID">
    <br>
    <label> Active </label><input type="checkbox" name="tbactive" >
    <br>
    <br>
    <fieldset>
        <legend>Hình ảnh</legend>
        <input id="picupload" type="file" name="files[]"
                           data-url="<?= base_url() ?>main/calljupload"
                           multiple>
        <div id="pic"></div>
    </fieldset>
    <input type="hidden" name="currpage" value="1">
    <input type="button" value="Lưu" onclick="save()">
    <input type="button" value="Load" onclick="load(1)">
    <input type="button" value="Xóa nhập liệu" onclick="clear()">
    <div id="loadstatus" style="float:right;"></div>
</fieldset>
<fieldset>
    <legend>Danh sách</legend>
    <div id="list_province"></div>
</fieldset>
<script>
    $('.date').mask('9999-99-99 99:99:99');
    function save() {
        var tbdatefrom = $("input[name=tbdatefrom]").val();
        var tbdateto = $("input[name=tbdateto]").val();
        var edit = $("input[name=edit]").val();
        var tbactive = (($("input[name=tbactive]").prop('checked'))?1:0);

        if (tbdatefrom.trim() != "" && tbdateto.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>main/savegame",
                data: "tbdatefrom=" + tbdatefrom
                          + "&tbdateto=" + tbdateto
                          + "&edit=" + edit
                          + "&tbactive=" + tbactive,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");                                            
                            break;
                        case "1":                           
                            break;
                        default :
                            alert("Lỗi lưu Tỉnh - không xác định.")                           
                            break;
                    }

                }
            });
        }
        else {
            alert("Vui lòng nhập tối thiểu Tên đầy đủ và Seo URL");
        }
    }
    function load(page) {
        // addloadgif("#loadstatus");
        // $("#list_province").load("<?=base_url()?>admin/loadprovince/"+page,function (){removeloadgif("#loadstatus");});
        // $("input[name=currpage]").val(page);
    }
    function clear(){
        $("input[name=tbdatefrom]").val("");
        $("input[name=tbdateto]").val("");
        $("input[name=edit]").val("");
    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>main/loadeditgame/" + id,
            success: function (msg) {
                if (msg == "0") alert('khong co data');
                else {
                    var province = eval(msg);
                    $("input[name=tbdatefrom]").val(province.tbdatefrom);
                    $("input[name=edit]").val(province.id);
                    $("input[name=tbdateto]").val(province.tbdateto);
                    $("input[name=tbactive]").prop('checked',((province.tbactive==1)?true:false));

                }
            }
        });
    }
    function hide(id, status,taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>main/hide/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    // loadProvince($("input[name=currpage]").val());
                }
                else {
                    alert("Thao tác thất bại!");
                }
            }
        });
    }
</script>