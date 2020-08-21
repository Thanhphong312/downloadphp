
<?php
if(!empty($_GET['url']) && !empty($_GET['title']) && !empty($_GET['mime']) && !empty($_GET['ext'])) {
	$url   = base64_decode($_GET['url']);
	$title = filter_var($_GET['title']);
	$mime  = filter_var($_GET['mime']);
	$ext   = filter_var($_GET['ext']);
	$size  = filter_var($_GET['size']);
	$act = 0;
	if ($url) {

			sheader('Content-Description: File Transfer');
			header('Content-Type: application/force-download');
			header('Content-Disposition: attachment; filename="' . $title .".". $ext . '"');
			header("Content-Transfer-Encoding: binary");
			header('Expires: 0');
			header('Cache-Control: no-store');
			header('Pragma: public');
			$act = 1;
		readfile($url);
		exit();
	}
}
?>

