<?php
// No direct access
defined('_JEXEC') or die;

if (!isset($active_menu_route)) {
    $active_menu_route = '';
}

$lang = JFactory::getLanguage();

?>
<div class="home_categories">
    <div class="section-title">
        <h2><span><?php echo ($lang->getTag() == 'ja-JP') ? '新商品特集 人気アイテムが勢ぞろい' : 'Trended Posters' ?></span></h2>
    </div>

    <div class="thumbnail_list">
        <?php for ($i = 0; $i <= 4; $i++) { ?>
            <div class="list_item_wrapper">
                <div class="list_border">
                    <div class="list_item">
                        <a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . rand(36, 56)); ?>">
                            <div class="img_wrapper">
                                <img src="/images/themeparrot/products/green_bag.jpg" />
                            </div>
                        </a>
                        <div class="title_wrapper">
                            <a class="title" href="#">RAIN QUEEN 絵画風 壁紙ポスター 風景 景色 おしゃれ ウォールステッカー 多用途なシール DIYシール 偽窓ステッカー 絵画風 壁紙ポスター</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div>
    <?php /*  $lang = JFactory::getLanguage();
    echo 'Current language is: ' . $lang->getName();
    echo 'Current tag is: ' . $lang->getTag();
    echo '<pre>';
    var_dump($lang);
    echo '</pre>';  */ ?>
</div>