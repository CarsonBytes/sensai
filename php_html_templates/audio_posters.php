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
        margin-right: 20px;
    }

    .main_content p {
        text-align: justify;
    }

    h3 {
        margin: 5px 0;
    }
</style>
<?php
//$charts = getCharts();

$charts = array();
$charts[] = (object) array(
    'params' => (object) array(
        'title' => 'Popular Cat Breeds (version 1)',
        'thumb' => 'http://on9.duckdns.org:8080/images/bundle/A0A_10630_Ed_cat_277.jpg',
        'introtext' => '<ul><li>Audio ePoster Set, pdf file for your personal decorative and learning purposes.</li>
        <li><b>Only</b> available as <b>FREE ePoster</b>. No physical merchandise prints available.</li>
        <li>You may prepare A3 or A4 physical prints by your home printer.</li>
        </ul>
        <b>Brand</b>: Sensaihonya<br />
        <b>Code</b>:	<b>P12001-cat</b><br />
        <b># of pages</b>: 2<br />
        <b># of breeds</b>: 64<br />
        <div class="clearfix"></div>
        <b>Features</b>
        <ul><li><b>QR code</b><br />
        <p>Reach the Rich Content Object page by simply scan the QR code at the top right corner of each page with mobile scanning app</p>
        </li>
        <li><b>Easy Navigation</b><br />
        <p>On the Rich Content Object page, there is a digital replica of each poster, 
        together with the corresponding Rich Content Object Table. 
        Once an object is clicked, the info line will be highlighted and the Object Table will jump to the line containing links to abundant resources.</p>
        </li>
        <li><b>Rich Content Object Table</b><br />
        <p>Well Organised web resources for easy and convenient navigation to abundant knowledge base</p>
        </li>
        <li><b>Audio Resources</b><br />
        <p>Allow kids and adults to listen to poster contents, creating an instant and convenient learning environment that can be reached at fingertips.</p>
        </li>
        </ul>
        '
    )
);
$charts[] = (object) array(
    'params' => (object) array(
        'title' => 'Popular Dog Breeds (version 1)',
        'thumb' => 'http://on9.duckdns.org:8080/images/bundle/A0B_10610_Ed_dog_277.jpg',
        'introtext' => '<ul><li>Audio ePoster Set, pdf file for your personal decorative and learning purposes.</li>
        <li><b>Only</b> available as <b>FREE ePoster</b>. No physical merchandise prints available.</li>
        <li>You may prepare A3 or A4 physical prints by your home printer.</li>
        </ul>
        <b>Brand</b>: Sensaihonya<br />
        <b>Code</b>:	<b>P12003-dog</b><br />
        <b># of pages</b>: 3<br />
        <b># of breeds</b>: 164<br />
        <div class="clearfix"></div>
        <b>Features</b>
        <ul><li><b>QR code</b><br />
        <p>Reach the Rich Content Object page by simply scan the QR code at the top right corner of each page with mobile scanning app</p>
        </li>
        <li><b>Easy Navigation</b><br />
        <p>On the Rich Content Object page, there is a digital replica of each poster, 
        together with the corresponding Rich Content Object Table. 
        Once an object is clicked, the info line will be highlighted and the Object Table will jump to the line containing links to abundant resources.</p>
        </li>
        <li><b>Rich Content Object Table</b><br />
        <p>Well Organised web resources for easy and convenient navigation to abundant knowledge base</p>
        </li>
        <li><b>Audio Resources</b><br />
        <p>Allow kids and adults to listen to poster contents, creating an instant and convenient learning environment that can be reached at fingertips.</p>
        </li>
        </ul>
        '
    )
);
$charts[] = (object) array(
    'params' => (object) array(
        'title' => 'Popular Cat Breeds (version 2)',
        'thumb' => 'http://on9.duckdns.org:8080/images/bundle/A0A_10630_Ed_cat_277.jpg',
        'introtext' => '<ul><li><b>Audio ePoster Set</b>, pdf file for your personal decorative and learning purposes.</li>
        <li><a href="#">Printed product also available</a></li>
        <li>You may prepare A3 or A4 physical prints by your home printer.</li>
        </ul>
        <b>Brand</b>: Sensaihonya<br />
        <b>Code</b>:	<b>A0A_10630_cat</b><br />
        <b># of pages</b>: 2<br />
        <div class="clearfix"></div>
        <b>Features</b>
        <ul><li><b>QR code</b><br />
        <p>Reach the Rich Content Object page by simply scan the QR code at the top right corner of each page with mobile scanning app</p>
        </li>
        <li><b>Easy Navigation</b><br />
        <p>On the Rich Content Object page, there is a digital replica of each poster, 
        together with the corresponding Rich Content Object Table. 
        Once an object is clicked, the info line will be highlighted and the Object Table will jump to the line containing links to abundant resources.</p>
        </li>
        <li><b>Rich Content Object Table</b><br />
        <p>Well Organised web resources for easy and convenient navigation to abundant knowledge base</p>
        </li>
        <li><b>Audio Resources</b><br />
        <p>Allow kids and adults to listen to poster contents, creating an instant and convenient learning environment that can be reached at fingertips.</p>
        </li>
        </ul>
        '
    )
);
$charts[] = (object) array(
    'params' => (object) array(
        'title' => 'Popular Dog Breeds (version 2)',
        'thumb' => 'http://on9.duckdns.org:8080/images/bundle/A0B_10610_Ed_dog_277.jpg',
        'introtext' => '<ul><li><b>Audio ePoster Set</b>, pdf file for your personal decorative and learning purposes.</li>
        <li><a href="#">Printed product also available</a></li>
        <li>You may prepare A3 or A4 physical prints by your home printer.</li>
        </ul>
        <b>Brand</b>: Sensaihonya<br />
        <b># of pages</b>: 2<br />
        <b>Code</b>:	<b>A0B_10610_dog</b><br />
        <div class="clearfix"></div>
        <b>Features</b>
        <ul><li><b>QR code</b><br />
        <p>Reach the Rich Content Object page by simply scan the QR code at the top right corner of each page with mobile scanning app</p>
        </li>
        <li><b>Easy Navigation</b><br />
        <p>On the Rich Content Object page, there is a digital replica of each poster, 
        together with the corresponding Rich Content Object Table. 
        Once an object is clicked, the info line will be highlighted and the Object Table will jump to the line containing links to abundant resources.</p>
        </li>
        <li><b>Rich Content Object Table</b><br />
        <p>Well Organised web resources for easy and convenient navigation to abundant knowledge base</p>
        </li>
        <li><b>Audio Resources</b><br />
        <p>Allow kids and adults to listen to poster contents, creating an instant and convenient learning environment that can be reached at fingertips.</p>
        </li>
        </ul>
        ')
);
?>
<div class="audio_posters">
    <div class="audio_posters_wrapper">
        <?php /* $j = 0;
        foreach ($charts as $chart) {
            $chart_params = json_decode($chart->params);
        ?>
            <div class="audio_poster">
                <div class="main_content">
                    <a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $chart_params->chart_j2_store_product_id); ?>">
                        <h3 itemprop="name" class="product-title"><?php echo $chart->title; ?></h3>
                    </a>
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
                <div class="clearfix"></div>
                <hr />
            </div>
        <?php
            $j++;
        } */
        ?>

        <?php
        foreach ($charts as $chart) {
            $chart_params = $chart->params;
        ?>
            <div class="audio_poster">
                <div class="main_content">
                    <a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=')  ?>">
                        <h3 itemprop="name" class="product-title"><?php echo $chart_params->title; ?></h3>
                    </a>
                    <img src="<?php echo $chart_params->thumb; ?>" />
                    <?php echo $chart_params->introtext; ?>
                    <a href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=')  ?>">
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
        }
        ?>
    </div>
</div>
<div class="clearfix"></div>

<?php
