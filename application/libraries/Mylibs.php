<?php
class MyLibs
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public $CI;

    public function makeNavAddr($sStopLevel, $aAddress, $placeid=0)
    {
        $aAddrTree = $this->CI->config->item('aAddrTree');
        $sNavCurr = "/";
        $font = 10;
        $parentid = 0;
        $parentname = "";
        $sAddNav = "";
        $currurl = base_url();
        foreach ($aAddrTree as $level => $aAddr) {
            $oCurrAdd = $aAddress[$level];
            if ($oCurrAdd == null) header("Location: " . $currurl);
            $sAddNav .= '<li class="parentnav smalltext' . $font . '" onmouseover="ShowSubCat(this,\'' . $parentname . '\',' . $parentid . ',\'' . $level . '\',\'' . $sNavCurr . '\')" onmouseout="HideSubCat(\'' . $level . '\')">
                ' . (($font == 10) ? '<i class="fa fa-map-marker"></i> ' : '') . '<a href="' . $sNavCurr . $oCurrAdd->daurl.(($placeid>0 && $font==6)?'-'.$placeid.'.html':'') . '">' . $oCurrAdd->dalong_name . '</a> <i class="fa fa-caret-down"></i>
                <div class="subnav" id="subcat_' . $level . '" style="display: none;"></div>
                </li>';
            $parentname = $level;
            $parentid = $oCurrAdd->id;
            $sNavCurr .= $oCurrAdd->daurl . '/';
            $currurl .= $oCurrAdd->daurl . '/';
            $font--;
            if ($sStopLevel == $level) break;
        }
        return $sAddNav;
    }

    public function echojson($data = array())
    {
        $this->CI->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function accessadmin()
    {
        $acees = false;
        switch ($this->CI->session->userdata("darole")) {
            case "admin":
                $acees = true;
                break;
            case "author":
                $acees = true;
                break;
            case "member":
                $acees = false;
                break;
            default:
                $acees = false;
                break;
        }
        return $acees;
    }

    public function accessuserpage()
    {
        $acees = false;
        switch ($this->CI->session->userdata("darole")) {
            case "admin":
                $acees = true;
                break;
            case "author":
                $acees = false;
                break;
            case "member":
                $acees = false;
                break;
            default:
                $acees = false;
                break;
        }
        return $acees;
    }

    public function accessaddresspage()
    {
        $acees = false;
        switch ($this->CI->session->userdata("darole")) {
            case "admin":
                $acees = true;
                break;
            case "author":
                $acees = true;
                break;
            case "member":
                $acees = false;
                break;
            default:
                $acees = false;
                break;
        }
        return $acees;
    }

    public function accessservicepage()
    {
        $acees = false;
        switch ($this->CI->session->userdata("darole")) {
            case "admin":
                $acees = true;
                break;
            case "author":
                $acees = true;
                break;
            case "member":
                $acees = false;
                break;
            default:
                $acees = false;
                break;
        }
        return $acees;
    }

    public function accessdealpage()
    {
        $acees = false;
        switch ($this->CI->session->userdata("darole")) {
            case "admin":
                $acees = true;
                break;
            case "author":
                $acees = true;
                break;
            case "member":
                $acees = false;
                break;
            default:
                $acees = false;
                break;
        }
        return $acees;
    }
    public function candeletecomment()
    {
        $acees = false;
        switch ($this->CI->session->userdata("darole")) {
            case "admin":
                $acees = 2;
                break;
            case "author":
                $acees = 2;
                break;
            case "member":
                $acees = 1;
                break;
            default:
                $acees = 0;
                break;
        }
        return $acees;
    }

    public function makePlaceUrl($place)
    {
        return base_url() . $place->provinceurl . '/' . $place->districturl . '/' . (($place->wardurl != '') ? $place->wardurl . '/' : '') . (($place->streeturl != '') ? $place->streeturl . '/' : '') . $place->daurl . '-' . $place->id . '.html';
    }

    public function makeThumbnails($file_path, $file_name, $width, $height)
    {
        $file_path = $file_path . $file_name;

        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }

        if($width > $img_width || $height > $img_height){
            $height = $img_height;
            $tmph = $img_height;
            $width = $img_width;
            $tmpw = $img_width;
        }
        if($height == 'auto'){
            $height = $img_height * ($width/$img_width);
            $offW = 0;
            $offH = 0;
            $tmpw = $img_width;
            $tmph = $img_height;
        }
        else{
        $ratew = $width/$img_width;
        $rateh = $height/$img_height;

        $rate = ($ratew>$rateh)?$ratew:$rateh; //lay rate cao hon
        $tmpw = $width / $rate;
        $tmph = $height / $rate;


            if($tmph < $img_height)
            $offH = ($img_height - $tmph) /2;
            else $offH = ($tmph - $img_height) /2;

            if($tmpw < $img_width)
            $offW = ($img_width - $tmpw ) / 2;
            else $offW = ($tmpw - $img_width) / 2;
        }
        $new_img = @imagecreatetruecolor($width, $height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                //$write_image = 'imagejpeg';
                //$image_quality = isset($options['jpeg_quality']) ?
                //    $options['jpeg_quality'] : 80;
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                //$write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                //$write_image = 'imagepng';
                //$image_quality = isset($options['png_quality']) ?
                //    $options['png_quality'] : 9;
                break;
            default:
                $src_img = null;
        }

        @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, $offW, $offH,
            $width,
            $height,
            $tmpw,
            $tmph
        );
        @imagedestroy($src_img);
        return $new_img;
    }
    function getIdFromSeourl($seourl){
        $a = explode(".",$seourl);
        $l = explode("-",$a[0]);
        return end($l);
    }

}