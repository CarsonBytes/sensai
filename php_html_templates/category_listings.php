<?php 
// No direct access
defined('_JEXEC') or die;
/* 
$query = "SELECT * from h1232_bundle_single;";

$database->setQuery($query);

$result = $database->loadAssocList();

echo '<pre>';

var_dump($result);

echo '</pre>';  */
/* 
$id=16;
//echo  \Joomla\CMS\Router\Route::_('index.php?option=com_j2store&view=products&id='.$id).'<br />';
echo JRoute::link('site', 'index.php?option=com_j2store&task=view&view=products&Itemid=227&id='.$id). '<br />'; */

 /* 

 
$articleId= 21;
echo JRoute::_(ContentHelperRoute::getArticleRoute($articleId, $articleLink[$articleId])) . '<br />';
 
 

$catid = 18;
echo rtrim(JUri::base(), '/') . JRoute::_(ContentHelperRoute::getArticleRoute( $articleId, $catid )) . '<br />';
 
echo JRoute::_(JUri::root() . 'index.php?option=com_content&view=article&id=' . $articleId); */

?>
<div class="whole_content row">

    <div class="left_nav_wrapper col-sm-12">
        <div class="left_nav">
            <a class="category_btn hidden-sm hidden-lg hidden-md" href="#">
                <span>カテゴリー</span>
                <i class="fas fa-caret-right"></i>
                <i class="fas fa-caret-down"></i>
            </a>
            <div class="categories_list">
                <a href="#">
                    <h3>炊飯器・精米器</h3>
                </a>
                <ul>
                    <li><a href="#">圧力IH炊飯器</a></li>
                    <li><a href="#">IH炊飯器</a></li>
                    <li><a href="#">マイコン炊飯器</a></li>
                    <li><a href="#">電子炊飯ジャー</a></li>
                    <li><a href="#">ガス炊飯器</a></li>
                    <li><a href="#">保温ジャー</a></li>
                    <li><a href="#">精米器</a></li>
                </ul>


                <a href="#">
                    <h3>電子レンジ・オーブン</h3>
                </a>
                <ul>
                    <li><a href="#">スチームオーブン・レンジ</a></li>
                    <li><a href="#">電子レンジ</a></li>
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
    <div class="right_listings_wrapper col-sm-12">
        <h1>炊飯器・精米器</h1>
        <div class="right_listings">
            <?php for ($i = 0; $i <= 10; $i++) { ?>
                <div class="list_item_wrapper">
                    <div class="list_item">
                        <a class="img_link" href="#">
                            <div class="img_wrapper">
                                <img src="/images/sensaihonya/poster<?php echo rand(1, 4); ?>.jpg" />
                            </div>
                        </a>
                        <div class="title_wrapper">
                            <a class="title" href="#">RAIN QUEEN 絵画風 壁紙ポスター 風景 景色 おしゃれ ウォールステッカー 多用途なシール DIYシール 偽窓ステッカー 絵画風 壁紙ポスター</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>