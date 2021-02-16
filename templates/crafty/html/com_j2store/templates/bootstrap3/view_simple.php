<?php

/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 *
 * Bootstrap 2 layout of product detail
 */
// No direct access
defined('_JEXEC') or die;

require_once JPATH_SITE . '/php_html_templates/functions.php';

$document = JFactory::getDocument();
//$document->addScript('https://cdn.jsdelivr.net/npm/jquery-migrate@3.3.1/dist/jquery-migrate.js');
$document->addStyleSheet('https://cdn.jsdelivr.net/combine/npm/tiny-slider@2.9.2/dist/tiny-slider.css,npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css');
//$document->addStyleSheet('https://cdn.jsdelivr.net/npm/mediaelement@4.2.16/build/mediaelementplayer.min.css');
//$document->addScript('https://cdn.jsdelivr.net/combine/npm/tiny-slider@2.9.2,npm/tabulator-tables@4.5.3,npm/image-map-resizer@1.0.10,npm/jquery-zoom@1.7.21,npm/mediaelement@4.2.16/build/mediaelement-and-player.min.js');
$document->addScript('https://cdn.jsdelivr.net/combine/npm/tiny-slider@2.9.2,npm/jquery-zoom@1.7.21,npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js');
$document->addScript('/js/prod_detail.js');
$document->addScript('/js/sm_slider.js');


$query = "SELECT note FROM `h1232_content` b WHERE b.id = " . $this->product->product_source_id;

$database = JFactory::getDbo();
$database->setQuery($query);
$product_type = $database->loadResult();

$params = json_decode($this->product->params);

/**
 *  there should be no bundle type, as all products are bundle now 
 * */
if ($product_type == 'chart') {

	$result = getChart($this->product->product_source_id);
	//dump($result);

	$tag_ids_string = $result->tag_ids;
	/* $tag_titles = explode(',', $result->tag_titles);
	$tag_alias = explode(',', $result->tag_alias); */

	if (isset($result->chart_params)) {
		$chart_params = json_decode($result->chart_params);
		//dump($chart_params);
	}
} else if ($product_type == 'bundle') {

	/**
	 * query for bundle's tags, charts and params
	 */
	$query2 = "SELECT GROUP_CONCAT( DISTINCT t.id ) as tag_ids, 
	/* GROUP_CONCAT( DISTINCT t.title ) as tag_titles,  
	GROUP_CONCAT( DISTINCT t.alias ) as tag_alias,  */
	bi.params as bundle_params,
	GROUP_CONCAT( DISTINCT cp.params SEPARATOR '----') as charts_params,
	GROUP_CONCAT( DISTINCT c.title  SEPARATOR '----') as charts_titles
	FROM h1232_contentitem_tag_map ctm
	LEFT JOIN h1232_tags t on t.id = ctm.tag_id
	LEFT JOIN `bundle_params` bi ON bi.bundle_id = ctm.content_item_id
	LEFT JOIN `bundles_charts` bc ON bc.bundle_id = bi.bundle_id
	LEFT JOIN `chart_params` cp ON cp.chart_id = bc.chart_id
	LEFT JOIN `h1232_content` c ON cp.chart_id = c.id
	where ctm.content_item_id = {$this->product->product_source_id}
	and t.published = 1
	group by ctm.content_item_id;";


	$database->setQuery($query2);
	$result = $database->loadAssoc();
	//dump($result);
	$tag_ids_string = $result['tag_ids'];
 	/* $tag_titles = explode(',', $result['tag_titles']);
	$tag_alias = explode(',', $result['tag_alias']); */

	if (isset($result['bundle_params']))
		$bundle_params = json_decode($result['bundle_params']);

	if (isset($result['charts_params'])) {
		$charts_params = explode('----', $result['charts_params']);
		foreach ($charts_params as $key => $value) {
			$charts_params[$key] = json_decode($value);
		}
		$charts_titles = explode('----', $result['charts_titles']);
	}
}

/* $document->setMetaData('keywords', $result['tag_titles']); */

/**
 * related bundle query
 */
$query2 = "SELECT distinct jp.j2store_product_id, c.id as content_id, c.title, 
/* GROUP_CONCAT( DISTINCT t.title ) as matched_tag_titles, 
 GROUP_CONCAT( DISTINCT t.alias ) as matched_tag_alias, 
 GROUP_CONCAT( DISTINCT ctm.tag_id ) as matched_tag_ids,  */
jpi.main_image as thumb_image, bi.params
FROM h1232_contentitem_tag_map ctm
left join h1232_tags t on t.id = ctm.tag_id
left JOIN `h1232_content` c ON c.id = ctm.content_item_id
LEFT JOIN `h1232_j2store_products` jp ON jp.product_source_id = c.id
LEFT JOIN `h1232_j2store_productimages` jpi ON jp.j2store_product_id = jpi.product_id
RIGHT JOIN `bundle_params` bi ON bi.bundle_id = c.id
where ctm.tag_id in ({$tag_ids_string}) and c.id != {$this->product->product_source_id}
and c.state = 1  and t.published = 1
group by jp.j2store_product_id;";

//dump($query2);

$database->setQuery($query2);
$related_bundles = $database->loadAssocList();
?>
<div itemscope data-sku="<?= $this->product->variants->sku ?>" itemtype="http://schema.org/Product" class="product-<?php echo $this->product->j2store_product_id; ?> <?php echo $this->product->product_type; ?>-product">
	<div class="row">
		<div class="col-sm-12 hidden-md hidden-lg">
			<?php echo $this->loadTemplate('title'); ?>
		</div>

		<div class="col-sm-12 col-md-4 col-lg-4">

			<?php include JPATH_SITE . '/php_html_templates/prod_detail/galleries.php'; ?>

		</div>

		<div class="col-xs-12 col-md-8 main_content_col">
			<div class="buy_box pull-right">
				<div class="buy_box_inner">
					<div class="price_delivery_intro">
						<p class="price_inside_buybox">￥2,800</p>
						<p><span class="a-text-bold">通常配送無料</span> <a href="https://www.amazon.co.jp/gp/help/customer/display.html?ie=UTF8&amp;pop-up=1&amp;nodeId=642982" target="AmazonHelp" onclick="return amz_js_PopWin(this.href,'AmazonHelp','width=550,height=550,resizable=1,scrollbars=1,toolbar=0,status=0');">詳細</a></p>
						<p id="ddmDeliveryMessage" class="a-section a-spacing-mini">注文確定時に<span class="a-text-bold">通常配送</span> を選択した場合、最短で<span class="a-text-bold">1月24日 明日 ~ 1月25日 土曜日</span>にお届け予定です。</p>
					</div>
					<div class="btn_to_amazon to_single">
						<span class="a-button-inner">
							<i class="a-icon a-icon-buynow"></i>
							<input title="これを買おう" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
							<span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
								アマゾンでこれを買う
							</span>
						</span>
					</div>

					<div class="btn_to_amazon to_bundle_categories">
						<span class="a-button-inner">
							<i class="a-icon a-icon-buynow"></i>
							<input title="カートに入れる" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
							<span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
								アマゾンでバンドルを買う
							</span>
						</span>
					</div>
					<div class="product_delivery_intro">
						<p>この商品は、<a href="#">精彩本屋</a>が販売し、Amazon.co.jp が発送します。</p>
						<p style="margin-bottom: 0;">この出品商品にはコンビニ・ATM・ネットバンキング・電子マネー払いが利用できます。</p>
					</div>
				</div>
			</div>
			<div class="clearfix hidden-md hidden-lg"></div>
			<div class="main_content_md hidden-md hidden-lg">
				<h3>この商品について</h3>
				<?php echo $this->product->source->introtext; ?>
			</div>
			<div class="hidden-sm hidden-xs main_content">
				<?php echo $this->loadTemplate('title'); ?>
				<?php
				if (isset($bundle_params) && property_exists($bundle_params, 'bundle_chart_imgs')) {
					include JPATH_SITE . '/php_html_templates/prod_detail/selection_box.php';
				} ?>
				<?php echo $this->product->source->introtext; ?>
			</div>
			<div class="image_zoom_preview">
				<div class="loader_wrapper">
					<div class="loader" style="display:none;"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-xs-12">
			<?php
			if ($product_type == 'chart') {
				include JPATH_SITE . '/php_html_templates/prod_detail/edupack_datatable.php';
			}  ?>
		</div>

		<?php if (isset($this->product->source->event->afterDisplayContent)) : ?>
			<?php echo $this->product->source->event->afterDisplayContent; ?>
		<?php endif; ?>
	</div>
</div>

<?php
include JPATH_SITE . '/php_html_templates/prod_detail/this_bundle.php';

if (isset($related_bundles) && count($related_bundles) > 0) {
	include JPATH_SITE . '/php_html_templates/prod_detail/related_bundles.php';
}
