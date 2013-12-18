<!DOCTYPE html>
<html>
<head>


    <title><?= $sTitle ?></title>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?=$_SERVER['SERVER_NAME']?> là shop thời trang Thái. <?=$_SERVER['SERVER_NAME']?> cung cấp sỉ và lẻ mỹ phẩm và thời trang Thái Lan." />
    <meta name="keyword" content="<?= $sTitle ?>" />
    <meta name="author" content="<?=$_SERVER['SERVER_NAME']?>">
    <meta name="robots" content="INDEX, FOLLOW">
    <meta property="og:title" content="<?= $sTitle ?>" />
    <meta property="og:image" content="<?=base_url()?>empty.png" />
    <meta property="og:description" content="<?=$_SERVER['SERVER_NAME']?> cung cấp sỉ và lẻ mỹ phẩm và thời trang Thái Lan." />
    <meta property="og:type" content="" />
    <meta property="og:url" content="<?="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
    <meta property="og:site_name" content="<?=$_SERVER['SERVER_NAME']?>" />
    <link id="page_favicon" href="/favicon.ico" rel="icon" type="image/x-icon" />
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/font-awesome/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/frontstyle.css">
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/ckeditor/skins/moono/editor.css">
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/smoothness/jquery-ui-1.10.3.custom.css">
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/jquery.bxslider/jquery.bxslider.css">
    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>src/jquery.countdown.css">
    <script src="<?= base_url() ?>src/jquery.min.js"></script>
    <script src="<?= base_url() ?>src/mylib.js"></script>
    <script src="<?= base_url() ?>src/jquery-ui-min.js"></script>
    <script src="<?= base_url() ?>src/jquery.jqpagination.min.js"></script>
    <script src="<?= base_url() ?>src/jupload/vendor/jquery.ui.widget.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.iframe-transport.js"></script>
    <script src="<?= base_url() ?>src/jupload/jquery.fileupload.js"></script>
    <script src="<?= base_url() ?>src/jquery.bxslider/jquery.bxslider.min.js"></script>
    <script src="<?= base_url() ?>src/jquery.countdown.min.js"></script>
    <script src="<?= base_url() ?>src/jquery.countdown-vi.js"></script>

</head>

<body>
<div id="allpage">
<div id="content" class="wrap">
    <?= (isset($sBody) ? $sBody : "") ?>
</div>
<footer>
    <div class="wrap">
        <p>Copyright &copy 2013.</p>
    </div>
</footer>
    <input type="hidden" name="base_url" value="<?=base_url()?>">
    <input type="hidden" name="ajaxloading" value="0">
</div>
</body>
</html>