<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

/**
 * add menu items
 */
/* createOrUpdateMenuitem(
    'mainmenu', //menuType
    'Castle', //title
    'castle', //alias
    'categories/abstract/castle', //path
    323, //parent_id
    3, //level
    10001, //component_id
    'index.php?option=com_j2store&view=products&catid[0]=63', //url
    '{"subtemplate":"bootstrap3", "pageclass_sfx": "category_listings"}' //params
);

die(); */

$filename = "calc data - bundle_params (4).csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

if (file_exists(FILE_PATH)) {
    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $all_used_cat_aliases = array();
    $cat_alias = array();

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $cat1_index = array_search('cat1', $line[$i]);
            $cat2_index = array_search('cat2', $line[$i]);
            /* $category_alias_to_replace_index = array_search('category alias to replace', $line[$i]); */
        } else {
            // all lines
            $cat_alias[0] = $line[$i][$cat1_index];
            $cat_alias[1] = $cat_alias[0] . '/' . $line[$i][$cat2_index];
            /* if ($line[$i][$category_alias_to_replace_index] != '') {
                $cat_alias[1] = $line[$i][$category_alias_to_replace_index];
                $cat_alias[0] = explode('/', $cat_alias[1])[0];
            } */
            $all_used_cat_aliases[] =  'categories/' . $cat_alias[0];
            $all_used_cat_aliases[] =  'categories/' . $cat_alias[1];

            for ($j = 0; $j < 2; $j++) {
                $query = "SELECT id, title, alias from h1232_categories where path = 'poster/{$cat_alias[$j]}'";
                $db->setQuery($query);
                $cat = $db->loadAssoc();
                if ($cat != '') {
                    $menu_id = createOrUpdateMenuitem(
                        'mainmenu', //menuType
                        $cat['title'], //title
                        $cat['alias'], //alias
                        'categories/' . $cat_alias[$j], //path
                        ($j == 0) ? 110 : $parent_menu_id, //parent_id : categories for level 2 and sub cat for level 3
                        $j + 2, //level
                        10001, //component_id
                        'index.php?option=com_j2store&view=products&catid[0]=' . $cat['id'], //url
                        '{"subtemplate":"bootstrap3", "pageclass_sfx": "category_listings"}' //params
                    );
                    if ($j == 0) $parent_menu_id = $menu_id; // define parent cat id for $j==1 iteration

                } else {
                    echo '<pre>';
                    var_dump('no cat id is found:');
                    var_dump($cat);
                    echo '</pre>';
                    continue;
                }
            }
        }
        $i++;
    }

    /**
     * unpublished all published menu item with no bundle at all
     */
    $all_used_cat_aliases = "'" . implode("','", $all_used_cat_aliases) . "'";
    $qry = "UPDATE `#__menu` SET published = 0 WHERE path not in ({$all_used_cat_aliases}) and path like 'categories/%' and published = 1";
    $db->setQuery($qry);
    $db->execute();
}

function createOrUpdateMenuitem(
    $menuType,
    $title,
    $alias,
    $path,
    $parent_id,
    $level,
    $component_id,
    $url = '',
    $params = ''
) {
    global $db;
    $qry = "INSERT INTO `#__menu` (`menutype`, `title`, `alias`, `path`, `link`, `type`, 
    `published`, `parent_id`, `level`, `component_id`, 
    `checked_out`, `checked_out_time`, `access`, img, `params`, `language`) 
    VALUES ( {$db->quote($menuType)}, {$db->quote($title)}, {$db->quote($alias)}, {$db->quote($path)}, {$db->quote($url)}, 'component', 
    '1', {$db->quote($parent_id)}, {$db->quote($level)},  {$db->quote($component_id)}, 
    '0',{$db->quote(date('Y-m-d H:i:s'))}, '1', '', {$db->quote($params)}, '*')
    ON DUPLICATE KEY UPDATE menutype = {$db->quote($menuType)}, title = {$db->quote($title)}, path = {$db->quote($path)}, 
    link = {$db->quote($url)}, checked_out_time={$db->quote(date('Y-m-d H:i:s'))}, type = 'component', level = {$db->quote($level)}, 
    component_id = {$db->quote($component_id)},  params = {$db->quote($params)}, published = 1";
    $db->setQuery($qry);
    $db->query();


    $qry = "SELECT id FROM `#__menu` WHERE parent_id = {$db->quote($parent_id)} AND alias = {$db->quote($alias)}";
    $db->setQuery($qry);

    return $db->loadResult();
}
