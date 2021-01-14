<?php
// No direct access
defined('_JEXEC') or die;

define("IMG_XL", 2000);
define("IMG_L", 1500);
define("IMG_M", 762);
define("IMG_S", 277);
define("IMG_XS", 50);
define("BUNDLE_PATH", 'images/bundle/');

JFactory::getLanguage()->load('custom', JPATH_SITE, JFactory::getLanguage()->getTag(), true);

use Joomla\CMS\Uri\Uri;

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


function getFilePath($code)
{
	$db = JFactory::getDBO();

	$query = "SELECT fp.id, fp.code, fp.path, fp.params, 
    count(DISTINCT fd.id) AS total_download_cnt, count(DISTINCT fd2.id) AS user_download_cnt
    FROM sensaiho_nya.filepath fp
    LEFT JOIN files_downloaded fd ON fd.filepath_id = fp.id
    LEFT JOIN (SELECT * FROM files_downloaded WHERE user_id = {$db->quote(JFactory::getUser()->id)} ) fd2 ON fd2.filepath_id = fp.id
    WHERE fp.code = {$db->quote($code)}
    GROUP BY fp.id
    ORDER BY file_version_id desc
    LIMIT 1";

	//echo 'getFilePath';
	//dump($query);

	$db->setQuery($query);
	$result = $db->loadObject();

	//dump($result);
	return $result;
}

function getFilePaths()
{
    $db = JFactory::getDBO();

    $query = "SELECT fp.id, fp.file_id, fp.file_version_id, fp.code, fp.params,
	count(DISTINCT fd.id) AS total_download_cnt, count(DISTINCT fd2.id) AS user_download_cnt
	FROM filepath fp
	INNER JOIN (
		SELECT MAX(id) id, file_id, MAX(file_version_id) rev
		FROM filepath
		GROUP BY file_id
	) fp2 ON fp.id = fp2.id
	LEFT JOIN files_downloaded fd ON fd.filepath_id = fp.id
	LEFT JOIN (SELECT * FROM files_downloaded WHERE user_id = {$db->quote(JFactory::getUser()->id)} ) fd2 ON fd2.filepath_id = fp.id
	GROUP BY fp.id
	ORDER BY file_id";

    //echo 'getFilePath';
    //dump($query);

    $db->setQuery($query);
    $result = $db->loadObjectList();

    //dump($result);
    return $result;
}


function insertFilesDownloaded($user_id, $filepath_id, $filesize)
{
	$db = JFactory::getDBO();

	$values = array(
		$db->quote($user_id),
		$db->quote($filepath_id),
		$db->quote($_SERVER['REMOTE_ADDR']),
		$filesize,
		$db->quote($_SERVER['HTTP_X_FORWARDED_FOR']),
		$db->quote(date('Y-m-d H:i:s'))
	);
	$query = $db->getQuery(true);
	$query
		->insert($db->quoteName('files_downloaded'))
		->columns($db->quoteName(array('user_id', 'filepath_id', 'ip', 'bytes', 'HTTP_X_FORWARDED_FOR', 'created')))
		->values(implode(',', $values));

	/* echo 'insertBundlesCharts';
    dump($query); */

	$db->setQuery($query);

	$result = $db->execute();
	/* 
    dump($result); */
}

/**
 * case of status:
 *  0: 	user never downloaded 
 * 		=> go to transition page to download
 *  1: 	user has downloaded this file before and does not reach any quota yet 
 * 		=> prompt and download pdf immediately	
 *  2: 	user has downloaded this file and there is no quota at all
 * 		=> download pdf immediately
 * -1: 	self quota for this file reaches
 * 		=> prompt and ask whether redirection is desired , in case alternative file is there
 * -2: 	global quota for this file reaches
 * 		=> prompt and ask whether redirection is desired , in case alternative file is there
 * -3: 	user does not login in
 * -4:	1 of the quotas is reached but no alternative file is there
 * 
 * return:
 * array of status, prompt settings, etc.
 * 
 */
function getUserFileDownloadStatus($file_info)
{


	$is_redownload = false;
	if (!isLogin()) {
		return array(
			'status' => -3,
			'prompt' => array(
				'title' => JText::sprintf('PROMPT_NOTICE'),
				'message' => JText::sprintf('PROMPT_LOGIN'),
				'btns' => array(
					array(
						'name' => 'take_me_there',
						'text' => JText::sprintf('PROMPT_YES_TAKE_ME_THERE'),
						'link' => JUri::base() . 'login?return=' . urlencode(base64_encode(Uri::getInstance()->toString())),
						'target' => '_self'
					),
					array(
						'name' => 'cancel',
						'text' => JText::sprintf('PROMPT_CANCEL')
					)
				)
			),
			'is_redownload' => $is_redownload
		);
	}
	if ($file_info == null) {
		return false;
	}
	$file_params = json_decode($file_info->params);

	/**
	 * check if user has downloaded or not
	 */
	if ($file_info->user_download_cnt > 0) {
		$is_redownload = true;
	}
	
	/**
	 * TODO user has downloaded this file and there is no quota defined at all
	 */

	/**
	 * TODO 1 of the quota is reached but no alternative file is there
	 */

	/**
	 * check if local quota is reached 
	 */
	if ($file_info->user_download_cnt >= $file_params->total_download_limit_per_user) {

		return array(
			'status' => -1,
			'prompt' => array(
				'title' => JText::sprintf('PROMPT_NOTICE'),
				'message' => JText::sprintf('PROMPT_LOCAL_REDIRECT', $file_info->user_download_cnt, $file_params->total_download_limit_per_user),
				'btns' => array(
					array(
						'name' => 'take_me_there',
						'text' => JText::sprintf('PROMPT_YES_TAKE_ME_THERE'),
						'link' => JUri::base() . 'download-promo?c=' . $file_params->alternative_filepath_code,
						'target' => '_blank'
					),
					array(
						'name' => 'cancel',
						'text' => JText::sprintf('PROMPT_CANCEL')
					)
				)
			),
			'is_redownload' => $is_redownload
		);
	}
	/**
	 * check if global quota is reached 
	 */
	if ($file_info->total_download_cnt >= $file_params->total_download_limit) {
		return array(
			'status' => -2,
			'prompt' => array(
				'title' => JText::sprintf('PROMPT_NOTICE'),
				'message' => JText::sprintf('PROMPT_GLOBAL_REDIRECT', $file_info->user_download_cnt, $file_params->total_download_limit_per_user),
				'btns' => array(
					array(
						'name' => 'take_me_there',
						'text' => JText::sprintf('PROMPT_YES_TAKE_ME_THERE'),
						'link' => JUri::base() . 'download-promo?c=' . $file_params->alternative_filepath_code,
						'target' => '_blank'
					),
					array(
						'name' => 'cancel',
						'text' => JText::sprintf('PROMPT_CANCEL')
					)
				)
			),
			'is_redownload' => $is_redownload
		);
	}

	/**
	 * check if user has downloaded this file before 
	 */
	if ($file_info->user_download_cnt == 0) {
		return array(
			'status' => 0,
			'link' => JUri::base() . 'download-promo?d=1&c=' . $file_info->code,
			'is_redownload' => $is_redownload
		);
	}

	/**
	 * until here user has downloaded this file before and does not reach any quota yet
	 */
	return array(
		'status' => 1,
		'prompt' => array(
			'title' => JText::sprintf('PROMPT_NOTICE'),
			'message' => JText::sprintf('PROMPT_REDOWNLOAD', $file_info->user_download_cnt, $file_params->total_download_limit_per_user),
			'btns' => array(
				array(
					'name' => 'dl_anyways',
					'text' => JText::sprintf('PROMPT_DOWNLOAD_ANYWAYS'),
					'link' => JUri::base() . 'download-promo?d=1&c=' . $file_info->code
				),
				array(
					'name' => 'cancel',
					'text' => JText::sprintf('PROMPT_CANCEL')
				)
			)
		),
		'is_redownload' => $is_redownload
	);
}
