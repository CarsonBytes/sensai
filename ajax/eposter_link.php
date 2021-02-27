<?php
/* echo json_encode(array('result' => true));
        exit; */
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
    && (isset($_POST['id'])) && ($_POST['id'] != null) && ($_POST['id'] != '')
) {
    define('_JEXEC', 1);
    define('JPATH_BASE', dirname(__DIR__));
    define('DS', DIRECTORY_SEPARATOR);
    require_once JPATH_BASE . '/php_html_templates/functions.php';

    echo json_encode(getUserFileDownloadStatus($_POST['id']));
    exit();
}

/* define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__));
require_once JPATH_BASE . '/php_html_templates/functions.php';
use Joomla\CMS\Uri\Uri; */
/* echo Uri::getInstance()->toString();
die(); */
/* echo JUri::base() .'free-eposters';
die(); */
die();
