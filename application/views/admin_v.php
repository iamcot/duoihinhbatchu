<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Tổng quan</a></li>
        <li><a href="<?=base_url()?>main/admingame">Tạo game</a></li>
        <li><a href="<?=base_url()?>main/adminvoucher">Quản lý voucher</a></li>
    </ul>
    <div id="tabs-1">
        <?=$sTQ?>
        </div>
</div>
<script>
    $(function() {
        $( "#tabs" ).tabs(
            {
                beforeLoad: function( event, ui ) {
                    for (var i = 1; i <= 2; i++) {
                         $("#ui-tabs-" + i).empty();
                    }
                    ui.jqXHR.error(function() {
                        ui.panel.html(
                            "Trang không tồn tại." );
                    });
                }
            }
        )
    });
    /*

     .addClass( "ui-tabs-vertical ui-helper-clearfix" );
     $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
     */
</script>