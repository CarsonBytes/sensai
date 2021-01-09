<?php
// No direct access
defined('_JEXEC') or die;

define("IMG_XL", 2000);
define("IMG_L", 1500);
define("IMG_M", 762);
define("IMG_S", 277);
define("IMG_XS", 50);
define("BUNDLE_PATH", 'images/bundle/');

/**
 * @deprecated
 */
function isEdupack($educational_type)
{
	return strpos($educational_type, 'educational-') !== false;
}

/**
 * @deprecated
 */
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
	if (strpos($url, JUri::base()) === false) {
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

function dump($a)
{
	$backtrace = debug_backtrace()[0];
	$fh = fopen($backtrace['file'], 'r');
	$line = 0;
	while (++$line <= $backtrace['line']) {
		$code = fgets($fh);
	}
	fclose($fh);
	preg_match('/' . __FUNCTION__ . '\s*\((.*)\)\s*;/u', $code, $name);
	ob_start();
	echo '<pre>' . trim($name[1]) . ":\n";
	var_export($a);
	echo '</pre>';
	ob_flush();
}

function isLogin()
{
	return !JFactory::getUser()->guest;
}

function getChart($id)
{
	$database = JFactory::getDbo();

	/**
	 * query for chart's tags and params
	 */
	$query = "SELECT GROUP_CONCAT( DISTINCT t.id ) as tag_ids, 
	/* GROUP_CONCAT( DISTINCT t.title ) as tag_titles,  
	GROUP_CONCAT( DISTINCT t.alias ) as tag_alias, */
	cp.params as chart_params
	FROM h1232_contentitem_tag_map ctm
	LEFT JOIN h1232_tags t on t.id = ctm.tag_id
	LEFT JOIN `chart_params` cp ON cp.chart_id = ctm.content_item_id
	LEFT JOIN `h1232_content` c ON c.id = cp.chart_id
	WHERE ctm.content_item_id = {$id} AND  t.published = 1 AND c.state = 1
	group by ctm.content_item_id;";

	$database->setQuery($query);

	return $database->loadObject();
}


function getCharts()
{
	$database = JFactory::getDbo();

	$query = "SELECT c.title, c.introtext, cp.params
	FROM chart_params cp
	LEFT JOIN `h1232_content` c ON c.id = cp.chart_id
	WHERE  c.state = 1";

	$database->setQuery($query);

	return $database->loadObjectList();
}
