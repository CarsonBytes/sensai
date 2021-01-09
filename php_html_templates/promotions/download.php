<?php
// TODO cookies warning

// No direct access
defined('_JEXEC') or die;

//require_once(JPATH_SITE . '/php_html_templates/functions.php');
require_once(JPATH_ROOT . '/bin/cap/init.php');
//dump($_GET['c']);


if (isset($_GET['c'])) {
    // TODO: check in DB if file where code='test' exists
    $file_info = getFilePath($_GET['c']);
    if ($file_info != null) {
        $file_params = json_decode($file_info->params);

        /* dump($file_info->params);
        dump($file_info);*/
        /* dump($file_params->total_download_limit);
        dump($file_info->total_download_cnt);
        dump($file_params->total_download_limit_per_user);
        dump($file_info->user_download_cnt);
        die();  */

        //check if this file itself has exceeded total_download_limit...
        if ($file_params->total_download_limit <= $file_info->total_download_cnt) {
            //redirect to another corresponding alternative file page with download limit reached warning

            if (isset($file_params->alternative_filepath_code) && ($file_params->alternative_filepath_code != null)) {
                $_SESSION['msg'] = "total download limit of the file you requested exceeds already! You have been redirected to the following file as an alternative. ";
                header("location:" . JUri::base() . 'download-promo?c=' . $file_params->alternative_filepath_code);
                die();
            } else {
                echo "total download limit of this file exceeds!";
                die();
            }
        }
        //check if downloading this file by this user reached total_download_limit_per_user...
        if ($file_params->total_download_limit_per_user <= $file_info->user_download_cnt) {
            //redirect to another corresponding alternative file page with download limit exceeds warning

            if (isset($file_params->alternative_filepath_code) && ($file_params->alternative_filepath_code != null)) {
                $_SESSION['msg'] = "total download limit of the file you requested reached! You have been redirected to the following file as an alternative. ";
                header("location:" . JUri::base() . 'download-promo?c=' . $file_params->alternative_filepath_code);
                die();
            } else {
                echo "total download limit of this file by you reached!";
                die();
            }
        }


        //dump($file_params->title);
    } else {
        die("record not found!");
    }
} else {
    die();
}

if (isset($_GET["d"]) && $_GET["d"] == 1 && isLogin()) {
    $filepath = JPATH_ROOT . DS . $file_info->path;
    // Proceed download
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        header('Set-Cookie: fileLoading=true');
        flush(); // Flush system output buffer
        readfile($filepath);
        //TODO insert files_downloaded record with user id and file_path id
        insertFilesDownloaded(JFactory::getUser()->id, $file_info->id, filesize($filepath));

        //TODO check if to_bundle_id is defined, if so redirect to that page automatically (done in html and javascript)
        die();
    } else {
        http_response_code(404);
        die();
    }
}

$document = JFactory::getDocument();
$document->addScript('https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js');

//make redirect url for login page to redirect back to this page
$redirectUrl = urlencode(base64_encode(JUri::base() . 'download-promo?c=' . $_GET['c']));

// encode file name to download
$fileName = urlencode(JPATH_ROOT . DS . $file_info->path);
//dump($fileName);

$redirectAfterDownloadUrl = '';
if (isset($file_params->to_bundle_j2store_id_after_download) && ($file_params->to_bundle_j2store_id_after_download != null)) {
    $redirectAfterDownloadUrl = JRoute::_('index.php?option=com_j2store&view=products&task=view&id=' . $file_params->to_bundle_j2store_id_after_download);
}

if (isset($_SESSION['msg']) && $_SESSION['msg'] != null){
    JFactory::getApplication()->enqueueMessage($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>
<style>
    .view-article .t3-wrapper .t3-mainbody .t3-content .item-page .articlebody {
        padding: 0;
    }

    .page-header,
    .alert-warning {
        display: none;
    }

    .item-page {
        max-width: 700px;
        margin: 0 auto;
    }

    .main_content img {
        opacity: 0.3;
    }
</style>
<?php if (isLogin()) { ?>
    <script>
        Cookies.remove('fileLoading')
        jQuery(function($) {
            setInterval(function() {
                if (Cookies.get('fileLoading')) {
                    Cookies.remove('fileLoading')

                    location.href = $("input[name='b_id']").val();
                }
            }, 1000);
        })
    </script>
<?php } ?>
<div class="download_promo col-sm-12 col-md-12 col-lg-12">
    <div class="download_promo_wrapper">
        <div class="download_promo">
            <div class="col-xs-12 col-md-12 main_content_col">
                <div class="main_content">
                    <h1 itemprop="name" class="product-title">Download Your <?php echo $file_params->title; ?></h1>
                    <p>Click on the image below to download your free poster.</p>
                    <a href="<?php echo isLogin() ? JUri::base() . 'download-promo?c=' . $file_info->code . '&d=1' : JUri::base() . 'login?return=' . $redirectUrl; ?>"><img src="<?php echo JUri::base() . $file_params->thumb ?>" /></a>
                    <?php if ($redirectAfterDownloadUrl != '') { ?>
                        <input type="hidden" name="b_id" value="<?php echo $redirectAfterDownloadUrl; ?>" />
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php

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

function isLogin()
{
    return !JFactory::getUser()->guest;
}
