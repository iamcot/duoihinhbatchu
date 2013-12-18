<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function jupload($options=null){
	require_once("jupload/upload.class.php");
	$JU = new UploadHandler($options);
	return $JU;
}
