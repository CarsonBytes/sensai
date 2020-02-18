<?php
// No direct access
defined('_JEXEC') or die;

/* 
echo '<pre>';

var_dump($this->active_menu);

echo '</pre>';  */

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
            <a class="<?php echo ($active_menu_route == 'categories/animal') ? 'active' : '' ?>" href="/categories/animal">
                <h3>動物</h3>
            </a>
            <ul>
                <li><a class="<?php echo ($active_menu_route == 'categories/animal/dog') ? 'active' : '' ?>" href="/categories/animal/dog">犬</a></li>
                <li><a class="<?php echo ($active_menu_route == 'categories/animal/horse') ? 'active' : '' ?>" href="/categories/animal/horse">馬</a></li>
                <li><a class="<?php echo ($active_menu_route == 'categories/animal/cat') ? 'active' : '' ?>" href="/categories/animal/cat">猫</a></li>
            </ul>


            <a class="<?php echo ($active_menu_route == 'categories/scenery') ? 'active' : '' ?>" href="/categories/scenery">
                <h3>風景</h3>
            </a>
            <ul>
                <li><a class="<?php echo ($active_menu_route == 'categories/scenery/nature') ? 'active' : '' ?>" href="/categories/scenery/nature">自然</a></li>
                <li><a class="<?php echo ($active_menu_route == 'categories/scenery/tourist-spot') ? 'active' : '' ?>" href="/categories/scenery/tourist-spot">観光地</a></li>
            </ul>


            <a href="#">
                <h3>ホットプレート・グリル鍋</h3>
            </a>
            <ul>
                <li><a href="#">スチームオーブン・レンジ</a></li>
                <li><a href="#">電子レンジ</a></li>
                <li><a href="#">マイコン炊飯器</a></li>
            </ul>


            <a href="#">
                <h3>電子レンジ・オーブン</h3>
            </a>
            <ul>
                <li><a href="#">スチームオーブン・レンジ</a></li>
                <li><a href="#">電子レンジ</a></li>
                <li><a href="#">マイコン炊飯器</a></li>
                <li><a href="#">電子炊飯ジャー</a></li>
                <li><a href="#">保温ジャー</a></li>
                <li><a href="#">精米器</a></li>
            </ul>
        </div>
    </div>
</div>