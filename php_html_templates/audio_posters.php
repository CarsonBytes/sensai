<?php
// No direct access
defined('_JEXEC') or die;

include JPATH_SITE . '/php_html_templates/functions.php';

?>
<style>
    .btn_to_amazon.to_view {
        text-align: center;
        float: right;
    }

    .btn_to_amazon .a-button-inner img {
        display: block;
        position: absolute;
        top: 2px;
        left: 2px;
        width: 25px;
        height: 25px;
        border-radius: 2px;
    }

    .main_content img {
        width: 150px;
        float: left;
        height: auto;
        margin-right: 30px;
    }

    .main_content p {
        text-align: justify;
    }

    h3 {
        margin: 5px 0;
    }
</style>
<?php
$charts = getCharts();
?>
<div class="audio_posters">
    <div class="audio_posters_wrapper">
        <?php $j = 0;
        foreach ($charts as $chart) {
        ?>
            <div class="audio_poster">
                <div class="main_content">
                    <a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $chart->j2_store_product_id); ?>">
                        <h3 itemprop="name" class="product-title"><?php echo $chart->audio_posters_page_title; ?></h3>
                    </a>
                    <img src="<?php echo $chart->set_img; ?>" />
                    <?php echo $chart->audio_posters_page_desc; ?>
                    <a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $chart->j2_store_product_id); ?>">
                        <div class="btn_to_amazon to_view">
                            <span class="a-button-inner">
                                <img src="<?php echo JUri::base() . 'images/icon/sensai_more.svg' ?>" />
                                <input title="View" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
                                <span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
                                    View
                                </span>
                            </span>
                        </div>
                    </a>
                </div>
                <div class="clearfix"></div>
                <hr />
            </div>
        <?php
            $j++;
        }
        ?>
    </div>
</div>
<div class="clearfix"></div>

<?php
