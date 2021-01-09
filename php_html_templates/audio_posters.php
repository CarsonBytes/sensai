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

    .item-page {
        max-width: 1000px;
        margin: 0 auto;
    }

    .item-page .articlebody {
        padding: 0;
    }

    .main_content img {
        width: 150px;
        float: left;
        height: auto;
        margin-right: 20px;
    }

    .main_content p {
        text-align: justify;
    }
</style>
<?php
$charts = getCharts();
?>
<div class="free_items col-sm-12 col-md-12 col-lg-12">
    <div class="free_items_wrapper">
        <?php $j = 0;
        foreach ($charts as $chart) {
            $chart_params = json_decode($chart->params);
        ?>
            <div class="free_item">
                <div class="col-xs-12 col-md-12 main_content_col">
                    <div class="main_content">
                        <h1 itemprop="name" class="product-title"><?php echo $chart->title; ?></h1>
                        <img src="<?php echo $chart_params->img_names[0]; ?>" />
                        <?php echo $chart->introtext; ?>
                        <a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $chart_params->chart_j2_store_product_id); ?>">
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

function getFilePaths()
{
    $db = JFactory::getDBO();

    $query = "SELECT fp.id, fp.file_id, fp.file_version_id, fp.code, fp.params
    FROM filepath fp
    INNER JOIN (
        SELECT MAX(id) id, file_id, MAX(file_version_id) rev
        FROM filepath
        GROUP BY file_id
    ) fp2 ON fp.id = fp2.id
    order by file_id";

    //echo 'getFilePath';
    //dump($query);

    $db->setQuery($query);
    $result = $db->loadObjectList();

    //dump($result);
    return $result;
}
