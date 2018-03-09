<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
$request = $_B['r'];
$mW      = new Watermark;
/* [type] => 1
[text_watermark] => Code by Nguyen Xuan Truong
[text_color] => #FFFF
[text_size] => 12
[font] => Arial
[rotate] => 0
[opacity] => 1
[posx] => 0
[posy] => 0
[width] => 0
[height] => 0
[action] => addAudio
[lang] => vi
[continue] =>
 */
$type           = $request->get_int('type', 'POST');
$text_watermark = $request->get_string('text_watermark', 'POST');
$text_color     = $request->get_string('text_color', 'POST');
$text_size      = $request->get_int('text_size', 'POST');
$font           = $request->get_string('font', 'POST');
$rotate         = $request->get_int('rotate', 'POST');
$opacity        = $request->get_string('opacity', 'POST');

$posx   = $request->get_int('posx', 'POST');
$posy   = $request->get_int('posy', 'POST');
$width  = $request->get_int('width', 'POST');
$height = $request->get_int('height', 'POST');

$ori_img = $request->get_string('ori_img', 'POST');

$data = array(
	'type'     => $type, //1=text, 2 image, 0 = ko
	'text'     => $text_watermark,
	'color'    => $text_color,
	'size'     => $text_size,
	'font'     => $font,
	'rotate'   => $rotate,
	'opacity'  => $opacity,
	'x'        => $posx,
	'y'        => $posy,
	'width'    => $width,
	'height'   => $height,
	'position' => '',
);
//xu ly upload anh
include DIR_HELPER_UPLOAD;
$options = array('max_size' => 1600, 'write_file' => true);
$upload  = new BncUpload($options);
if ($type == 2) {

	if (isset($_FILES['image_watermark']) && $_FILES['image_watermark']['error'] == 0) {
        $path = DIR_MODULES_FRONTEND . 'template/watermark/' . $_B['web']['idw'] . '/';
       	if(!file_exists($path)){
       		$mW->rmkdir($path);
       	}else{
       		$scan_dir=scandir($path);       		
            foreach ($scan_dir as $v) {
                if($v!='.' && $v!='..'){
                    @unlink($path.$v);
                }
            }
       	}
       
        $file=$_FILES['image_watermark'];
        $mimes=array(
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/x-ms-bmp',
        );
        if(!in_array($file['type'],$mimes)){
            die('Định dạng không được hỗ trợ');
        }
        //Upload
        $move=move_uploaded_file($file['tmp_name'], $path.$file['name']);
        $up_img = $ori_img = $file['name'];
        // //$up_img  = $_FILES['image_watermark']['name'];
        //$up_img = 'http://upload2.webbnc.vn/view.php?image=' . $up_img . '&mode=resize&size=' . $width . 'x' . $height . '';
    } else {

        if ($ori_img != '') {
            $up_img = $ori_img;
            //$up_img = 'http://upload2.webbnc.vn/view.php?image=' . $ori_img . '&mode=resize&size=' . $width . 'x' . $height . '';
        } else {
            $up_img  = '';
            $ori_img = '';
        }
    }
	$data['image']   = $up_img;
	$data['ori_img'] = $ori_img;
} else {
	$data['image']   = '';
	$data['ori_img'] = '';
}
$data_ok = json_encode($data);


$result = $upload->writeFile($_B['web']['idw'], 'setting.txt', $data_ok, 'WRITE');
// var_dump($result);
if ($result == true) {
	header('Location:/template-template-lang-vi#tab_6');
}

?>