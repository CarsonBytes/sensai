<?php
/**
 * have to set #__menu path to be unique field,
 * and rebuild menu from joomla backend in order to show the categories menu correctly
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

define('_JEXEC', 1);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "02 070 cat-structure bundle-cat bundle-detail bundle-tag - cat-structure.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

if (file_exists(FILE_PATH)) {
    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $all_used_cat_aliases = array();
    $level_alias = array();

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 3) {
            $level_index = array_search('level', $line[$i]);
            $alias_index = array_search('alias', $line[$i]);
            $categ_index = array_search('2 categ', $line[$i]);
        } else if ($i > 4) {

            $level_alias[$line[$i][$level_index] - 2] = $line[$i][$alias_index];
            for ($j = $line[$i][$level_index] - 1; $j < count($level_alias); $j++) {
                echo $j;
                unset($level_alias[$j]);
            }

            $cat_alias = implode('/', $level_alias);

            /*  $i++;
            continue; */

            $query = "SELECT id, title, alias from h1232_categories where path = 'poster/{$cat_alias}'";
            $db->setQuery($query);
            $cat = $db->loadAssoc();
            if ($cat != '') {
                $menu_id = createOrUpdateMenuitem(
                    'mainmenu', //menuType
                    $cat['title'], //title
                    $cat['alias'], //alias
                    'categories/' . $cat_alias, //path
                    ($line[$i][$level_index] == 2) ? 110 : $parent_menu_id, //parent_id : categories for level 2 and sub cat for level 3
                    $j + 2, //level
                    10001, //component_id
                    'index.php?option=com_j2store&view=products&catid[0]=' . $cat['id'], //url
                    '{"subtemplate":"bootstrap3", "pageclass_sfx": "category_listings"}' //params
                );
                if ($line[$i][$level_index] == 2) $parent_menu_id = $menu_id; // define parent cat id for $j==1 iteration

                dump($parent_menu_id);
                dump($menu_id);

                /**
                 * all_used_cat_aliases
                 */
                array_splice($line[$i], 0, $categ_index + 2);
                foreach ($line[$i] as $value) {
                    if ($value == 'Y') {
                        if (count($level_alias) > 1) $all_used_cat_aliases[] =  'categories/' . $level_alias[0];
                        $all_used_cat_aliases[] =  'categories/' . $cat_alias;
                        dump($all_used_cat_aliases);
                        continue;
                    }
                }
                dump($cat_alias);
            } else {
                echo '<pre>';
                var_dump('no cat id is found:');
                var_dump($cat);
                echo '</pre>';
                /* continue; */
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
} else {
    echo 'file not found';
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
