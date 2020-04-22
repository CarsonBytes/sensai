<?php
// No direct access
defined('_JEXEC') or die;
define('JPATH_BASE', dirname(__DIR__) . '/..');
define('DS', DIRECTORY_SEPARATOR);
require_once(JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once(JPATH_BASE . DS . 'includes' . DS . 'framework.php');

use Joomla\CMS\Factory;

$app = Factory::getApplication('site');

$menu = $app->getMenu();
$parent_menuitem = $menu->getItems(
    array('menutype', 'alias'),
    array('mainmenu', 'categories')
);

$child_menuitems1 = $menu->getItems(
    array('menutype', 'parent_id', 'level'),
    array('mainmenu', $parent_menuitem[0]->id, 2)
);

$child_menuitem2 = $menu->getItems(
    array('menutype', 'parent_id', 'level'),
    array('mainmenu', $child_menuitem1[0]->id, 3)
);

if (!isset($active_menu_route)) {
    $active_menu_route = '';
}
?>

<div class="left_nav_wrapper col-sm-12">
    <div class="left_nav">
        <a class="category_btn hidden-sm hidden-lg hidden-md" href="#">
            <span>カテゴリー</span>
            <i class="fas fa-caret-right"></i>
            <i class="fas fa-caret-down"></i>
        </a>
        <div class="categories_list">

            <?php foreach ($child_menuitems1 as $child_menuitem1) { ?>
                <a class="<?php echo ($active_menu_route == 'categories/' . $child_menuitem1->alias) ? 'active' : '' ?>" href="/categories/<?php echo $child_menuitem1->alias ?>">
                    <h3><?php echo $child_menuitem1->title ?></h3>
                </a>

                <ul>
                    <?php
                    $child_menuitems2 = $menu->getItems(
                        array('menutype', 'parent_id', 'level'),
                        array('mainmenu', $child_menuitem1->id, 3)
                    );
                    foreach ($child_menuitems2 as $child_menuitem2) { ?>
                        <li><a class="<?php echo ($active_menu_route == 'categories/' . $child_menuitem1->alias . '/' . $child_menuitem2->alias) ? 'active' : '' ?>" href="/categories/<?php echo $child_menuitem1->alias . '/' . $child_menuitem2->alias ?>"><?php echo $child_menuitem2->title ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>