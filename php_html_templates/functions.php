<?php
// No direct access
defined('_JEXEC') or die;

define("IMG_XL", 2000);
define("IMG_L", 1500);
define("IMG_M", 762);
define("IMG_S", 277);
define("IMG_XS", 50);
define("BUNDLE_PATH", 'images/bundle/');
define("user_24h_download_limit", 5);
define("eposters_page_link", 'free-eposters');

defined('JPATH_BASE') or define('JPATH_BASE', realpath(dirname(__FILE__) . '/../'));
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';

/* Create the Application */
$mainframe = JFactory::getApplication('site');

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

	$user_clause = '';
	if (JFactory::getUser()->id != 0) {
		$user_clause = "WHERE user_id = {$db->quote(JFactory::getUser()->id)}";
	}

	$query = "SELECT fp.id, fp.code, fp.path, fp.params, 
    count(DISTINCT fd.id) AS total_download_cnt, count(DISTINCT fd2.id) AS user_download_cnt
    FROM filepath fp
    LEFT JOIN files_downloaded fd ON fd.filepath_id = fp.id
    LEFT JOIN (SELECT * FROM files_downloaded $user_clause ) fd2 ON fd2.filepath_id = fp.id
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

	$user_clause = '';
	if (JFactory::getUser()->id != 0) {
		$user_clause = "WHERE user_id = {$db->quote(JFactory::getUser()->id)}";
	}

	$query = "SELECT fp.id, fp.file_id, fp.file_version_id, fp.code, fp.path, title, thumb, introtext
			FROM filepath fp
			INNER JOIN (
				SELECT MAX(id) id, file_id, MAX(file_version_id) rev
				FROM filepath
				GROUP BY file_id
			) fp2 ON fp.id = fp2.id
			GROUP BY fp.id
			ORDER BY id";
	/* $query = "SELECT fp.id, fp.file_id, fp.file_version_id, fp.code, fp.params,
	count(DISTINCT fd.id) AS total_download_cnt, count(DISTINCT fd2.id) AS user_download_cnt
	FROM filepath fp
	INNER JOIN (
		SELECT MAX(id) id, file_id, MAX(file_version_id) rev
		FROM filepath
		GROUP BY file_id
	) fp2 ON fp.id = fp2.id
	LEFT JOIN files_downloaded fd ON fd.filepath_id = fp.id
	LEFT JOIN (SELECT * FROM files_downloaded $user_clause ) fd2 ON fd2.filepath_id = fp.id
	GROUP BY fp.id
	ORDER BY id"; */

	/* echo 'getFilePath';
    dump($query); */

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

function getUser24hDownloadCnt($user_id)
{
	$db = JFactory::getDBO();

	$query = "SELECT count(*) FROM files_downloaded 
	WHERE user_id = {$db->quote($user_id)} AND 
	created > ({$db->quote(date('Y-m-d H:i:s'))} - INTERVAL 24 HOUR);";

	$db->setQuery($query);

	$result = $db->loadResult();

	//dump($result);
	return $result;
}

function getThisFileUserDownloadCnt($filepath_id, $user_id)
{
	$db = JFactory::getDBO();

	$query = "SELECT count(*) FROM files_downloaded 
	where filepath_id = {$db->quote($filepath_id)} and user_id = {$db->quote($user_id)}";

	$db->setQuery($query);

	$result = $db->loadResult();

	return $result;
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
 * -5: user_24h_download_limit reaches
 * 		=> just warn without any alternatives given
 * 
 * return:
 * array of status, prompt settings, etc.
 * 
 */
function getUserFileDownloadStatus(/* $file_info */$filepath_id)
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
						'link' => JUri::base() . 'login?return=' . urlencode(base64_encode(JUri::base() . eposters_page_link)),
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


	/* if ($file_info == null) {
		return false;
	} 
	$file_params = json_decode($file_info->params);*/

	/**
	 * check if user has downloaded or not
	 */
	$user_this_file_dl_cnt = getThisFileUserDownloadCnt($filepath_id, JFactory::getUser()->id);
	if ($user_this_file_dl_cnt > 0) {
		$is_redownload = true;
	}

	/**
	 * @deprecated when status=2: user has downloaded this file and there is no quota defined at all
	 */

	/**
	 * @deprecated when status=-4: 1 of the quota is reached but no alternative file is there
	 */

	/**
	 * @deprecated non commercial download should be unlimited
	 * check if local quota is reached , or if total_download_limit_per_user is 0, skip checking
	 */
	/* if ($file_info->user_download_cnt >= $file_params->total_download_limit_per_user && $file_params->total_download_limit_per_user != 0) {

		return array(
			'status' => -1,
			'prompt' => array(
				'title' => JText::sprintf('PROMPT_NOTICE'),
				'message' => JText::sprintf('PROMPT_LOCAL_REDIRECT'),
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
	} */

	/**
	 * @deprecated non commercial download should be unlimited
	 * check if global quota is reached , or if total_download_limit is 0, skip checking
	 */
	/* if ($file_info->total_download_cnt >= $file_params->total_download_limit  && $file_params->total_download_limit != 0) {
		return array(
			'status' => -2,
			'prompt' => array(
				'title' => JText::sprintf('PROMPT_NOTICE'),
				'message' => JText::sprintf('PROMPT_GLOBAL_REDIRECT'),
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
	} */

	/**
	 * check if user download quota over 24h reaches , or if user_24h_download_limit is 0, skip checking
	 */
	$user_24h_download_cnt = getUser24hDownloadCnt(JFactory::getUser()->id);
	if ($user_24h_download_cnt >= user_24h_download_limit  && user_24h_download_limit != 0) {
		return array(
			'status' => -5,
			'prompt' => array(
				'title' => JText::sprintf('PROMPT_NOTICE'),
				'message' => JText::sprintf('PROMPT_USER_24H_DL_REACHES'),
				'btns' => array(
					array(
						'name' => 'cancel',
						'text' => JText::sprintf('PROMPT_OK')
					)
				)
			),
			'is_redownload' => $is_redownload
		);
	}

	/**
	 * if user download quota over 24h == 0, proceed download right away
	 */
	if ($user_24h_download_cnt == 0) {
		return array(
			'status' => 0,
			'link' => JUri::base() . 'download-promo?c=', //to be appended with code in frontend js
			'is_redownload' => $is_redownload
		);
	}

	/**
	 * until here user download quota is over 24h > 0
	 */
	return array(
		'status' => 1,
		'prompt' => array(
			'title' => JText::sprintf('PROMPT_NOTICE'),
			'message' => JText::sprintf('PROMPT_REDOWNLOAD', $user_24h_download_cnt, user_24h_download_limit),
			'btns' => array(
				array(
					'name' => 'dl_the_file',
					'text' => JText::sprintf('PROMPT_DOWNLOAD_THIS_FILE'),
					'link' => JUri::base() . 'download-promo?c=' //to be appended with code in frontend js
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
