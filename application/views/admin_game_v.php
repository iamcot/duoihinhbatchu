<fieldset>
    <legend>Thông tin</legend>
    <input type="text" name="tbdatefrom" placeholder="Start Day">
    <input type="text" name="tbdateto" placeholder="Stop Day">

    <input type="text" name="edit" value="" readonly="true" placeholder="ID">
    <br>
    <label> Active </label><input type="checkbox" name="tbactive" >
    <br>
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
    $(function(){
        load(1);
    });
    function save() {
        var dalong_name = $("input[name=dalong_name]").val();
        var daurl = $("input[name=daurl]").val();
        var edit = $("input[name=edit]").val();
        var dashowhome = (($("input[name=dashowhome]").prop('checked'))?1:0);

        if (dalong_name.trim() != "" && daurl.trim() != "") {
            $.ajax({
                type: "post",
                url: "<?=base_url()?>admin/saveprovince",
                data: "dalong_name=" + dalong_name
                          + "&daurl=" + daurl
                          + "&edit=" + edit
                          + "&daprefix=" + daprefix,
                success: function (msg) {
                    switch (msg) {
                        case "0":
                            alert("Không thể lưu");
                            loadProvince($("input[name=currpage]").val());
                            provinceclear();
                            break;
                        case "1":
                            loadProvince($("input[name=currpage]").val());
                            addsavegif("#loadstatus");
                            provinceclear();
                            break;
                        default :
                            alert("Lỗi lưu Tỉnh - không xác định.")
                            loadProvince($("input[name=currpage]").val());
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
        addloadgif("#loadstatus");
        $("#list_province").load("<?=base_url()?>admin/loadprovince/"+page,function (){removeloadgif("#loadstatus");});
        $("input[name=currpage]").val(page);
    }
    function clear(){
        $("input[name=dalong_name]").val("");
        $("input[name=daurl]").val("");
        $("input[name=edit]").val("");
    }
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/loadeditprovince/" + id,
            success: function (msg) {
                if (msg == "0") alert('<?=lang("NO_DATA")?>');
                else {
                    var province = eval(msg);
                    $("input[name=dalong_name]").val(province.dalong_name);
                    $("input[name=edit]").val(province.id);
                    $("input[name=daurl]").val(province.daurl);
                    $("input[name=dashowhome]").prop('checked',((province.dashowhome==1)?true:false));

                }
            }
        });
    }
    function hide(id, status,taga) {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>admin/hideprovince/" + id + "/" + status,
            success: function (msg) {
                if (msg == "1") {
                    loadProvince($("input[name=currpage]").val());
                }
                else {
                    alert("Thao tác thất bại!");
                }
            }
        });
    }
</script>