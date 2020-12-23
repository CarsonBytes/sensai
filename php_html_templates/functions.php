<?php
// No direct access
defined('_JEXEC') or die;

define("IMG_XL", 2000);
define("IMG_L", 1500);
define("IMG_M", 762);
define("IMG_S", 277);
define("IMG_XS", 50);
define("BUNDLE_PATH", 'images/bundle/');

function isEdupack($educational_type)
{
	return strpos($educational_type, 'educational-') !== false;
}
function getEdupackInfo($educational_type)
{
	if (!isEdupack($educational_type)) return false;
	switch ($educational_type) {
		case 'educational-dog':
			$edupack_img_path = '/images/poster/edupack/dog/dog_edupack.jpg';
			$handbook_page_path = '/promotional-items#dog_handbook';
			$handbook_page_img_path = '/images/page/promotional_items/dog/dog_277_1.jpg';
			break;
		case 'educational-cat':
			$edupack_img_path = '/images/poster/edupack/cat/cat_edupack.jpg';
			$handbook_page_path = '/promotional-items#cat_handbook';
			$handbook_page_img_path = '/images/page/promotional_items/cat/cat_277_1.jpg';
			break;
	}
	return array(
		'edupack_img_path' => $edupack_img_path,
		'handbook_page_path' => $handbook_page_path,
		'handbook_page_img_path' => $handbook_page_img_path
	);
}

/**
 * to be refactored
 */
function getImgSizeUrl($url, $width = 'L')
{

	//add base url
	if(strpos($url, JUri::base()) === false){
		$url = JUri::base() . $url;
	}

	//width : XL, L, M, S, XS
	$all_sizes = array('_2000.', '_1500.', '_762.', '_277.', '_50.');

	switch ($width) {
		case 'XL':
			return str_replace($all_sizes, '_2000.', $url);
			break;
		case 'L':
			return str_replace($all_sizes, '_1500.', $url);
			break;
		case 'M':
			return str_replace($all_sizes, '_762.', $url);
			break;
		case 'S':
			return str_replace($all_sizes, '_277.', $url);
			break;
		case 'XS':
			return str_replace($all_sizes, '_50.', $url);
			break;
	}
	return false;
}