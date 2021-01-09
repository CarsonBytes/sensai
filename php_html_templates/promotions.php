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
$promos = getFilePaths();
//die()
/* $freebie1 = array(
    'title' => 'Cat Poster',
    'thumb' => JUri::base() . 'images/bundle/gallery/A0B_405_2_762.jpg',
    'introtext' =>
    "<p>RSPB is giving away FREE Big Garden Birdwatch packs which contain bird charts, a calendar, recipes for bird food and more! Register now and help to support the wildlife where you live. They'll also send you emails with plenty of fun activities for kids and ideas to get the garden viable for wildlife.</p>",
    "filepath_code" => 'test'
);
$freebies = array(
    $freebie1
);
$freebie2 = array(
    'title' => 'Dog Poster',
    'thumb' => JUri::base() . 'images/bundle/gallery/A0B_405_2_762.jpg',
    'introtext' =>
    '<p>Open University is giving away free Fishing poster and if you want to get one for yourself then head over to their giveaway page and then supply your details to get it delivered right at your doorsteps. Click on “GET IT HERE” button and then follow instructions given above to get free poster.</p>',
    "filepath_code" => 'test2'
);
array_push($freebies, $freebie2); */

?>
<div class="free_items col-sm-12 col-md-12 col-lg-12">
    <div class="free_items_wrapper">
        <?php $j = 0;
        foreach ($promos as $promo) { 
            $file_params = json_decode($promo->params);    
            ?>
            <div class="free_item">
                <div class="col-xs-12 col-md-12 main_content_col">
                    <div class="main_content">
                        <h1 itemprop="name" class="product-title"><?php echo $file_params->title; ?></h1>
                        <img src="<?php echo $file_params->thumb; ?>" />
                        <?php echo $file_params->introtext; ?>
                        <div class="btn_to_amazon to_view" onclick="window.location ='<?php echo JUri::base() . 'download-promo?c='.$promo->code; ?>';">
                            <span class="a-button-inner">
                                <img src="<?php echo JUri::base() . 'images/icon/sensai_more.svg' ?>" />
                                <input title="View" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
                                <span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
                                    GET IT NOW
                                </span>
                            </span>
                        </div>
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
