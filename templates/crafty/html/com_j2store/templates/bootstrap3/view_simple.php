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



if ($product_type == 'bundle') {
	$query = "SELECT bs.bundle_id, a.j2store_product_id, b.title, b.introtext,  b.fulltext, e.thumb_image, e.main_image FROM `h1232_j2store_products` a 
	INNER JOIN `h1232_content` b ON a.product_source_id = b.id
	LEFT JOIN `h1232_j2store_productimages` e ON a.j2store_product_id = e.product_id
	LEFT JOIN `bundle_single` bs ON bs.single_id = b.id
	WHERE bs.bundle_id = " . $this->product->product_source_id . "
	ORDER by bs.created_on";
} else {
	//bundle's corresponding  tags and params
	$query2 = "SELECT GROUP_CONCAT( DISTINCT t.id ) as tag_ids , 
	GROUP_CONCAT( DISTINCT t.title ) as tag_titles ,  
	GROUP_CONCAT( DISTINCT t.alias ) as tag_alias,
	bi.params
	FROM h1232_contentitem_tag_map ctm
	LEFT JOIN h1232_tags t on t.id = ctm.tag_id
	LEFT JOIN `bundle_params` bi ON bi.bundle_id = ctm.content_item_id
		where ctm.content_item_id = {$this->product->product_source_id}
		and t.published = 1
		group by ctm.content_item_id;";

	$database->setQuery($query2);
	$result = $database->loadAssocList();
	$tag_ids_string = array_column($result, 'tag_ids')[0];
	$tag_titles = explode(',', $result[0]['tag_titles']);
	$tag_alias = explode(',', $result[0]['tag_alias']);

	if (isset($result[0]['params']))
		$bundle_params = json_decode($result[0]['params']);

	$query2 = "SELECT distinct jp.j2store_product_id, c.id as content_id, c.title, 
	GROUP_CONCAT( DISTINCT t.title ) as matched_tag_titles, 
	GROUP_CONCAT( DISTINCT t.alias ) as matched_tag_alias, 
	GROUP_CONCAT( DISTINCT ctm.tag_id ) as matched_tag_ids, 
	jpi.main_image as thumb_image, bi.params
	FROM sensaiho_nya.h1232_contentitem_tag_map ctm
	left join h1232_tags t on t.id = ctm.tag_id
	left JOIN `h1232_content` c ON c.id = ctm.content_item_id
	LEFT JOIN `h1232_j2store_products` jp ON jp.product_source_id = c.id
	LEFT JOIN `h1232_j2store_productimages` jpi ON jp.j2store_product_id = jpi.product_id
	RIGHT JOIN `bundle_params` bi ON bi.bundle_id = c.id
	where ctm.tag_id in ({$tag_ids_string}) and c.id != {$this->product->product_source_id}
	and c.state = 1  and t.published = 1
	group by jp.j2store_product_id;";
	$database->setQuery($query2);
	$related_bundles = $database->loadAssocList();
}
?>
<div itemscope data-sku="<?= $this->product->variants->sku ?>" itemtype="http://schema.org/Product" class="product-<?php echo $this->product->j2store_product_id; ?> <?php echo $this->product->product_type; ?>-product">
	<div class="row">
		<div class="col-sm-12 hidden-md hidden-lg">
			<?php echo $this->loadTemplate('title'); ?>
		</div>

		<div class="col-sm-12 col-md-4 col-lg-4">

			<?php include JPATH_SITE . '/php_html_templates/prod_detail/gallery.php'; ?>

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
				<div class="product_tags">
					<strong>Tags:</strong>
					<?php $i = 0;
					foreach ($tag_titles as $tag_title) {
						if ($i > 0) {
							echo ', ';
						} ?><a target="_blank" href="<?php echo JUri::base() . 'tag/' . $tag_alias[$i]; ?>"><?php echo $tag_title; ?></a><?php
																																			$i++;
																																		}
																																			?>
				</div>
				<?php if (isset($bundle_params) && property_exists($bundle_params, 'bundle_chart_imgs')) {
				?>
					<div class="selection_text">
						<strong>Option:</strong>
						<div data-option="with_chart" class="option_text selected">With our exclusive chart posters: <a href="#">Popular dog breeds</a></div>
						<div data-option="no_chart" class="option_text">Without our exclusive chart posters</div>
					</div>
					<style>
						.product_tags strong,
						.selection_text strong {
							padding-left: 2px;
							padding-bottom: 2px;
							font-weight: 700;
						}

						.selection_text div {
							display: none;
						}

						.selection_text div.selected {
							display: inline-block;
						}

						.selection_boxes {
							margin-left: -6px;
						}

						.selection_box {
							border: 1px solid #e0e0e0;
							cursor: pointer;
							display: inline-block;
							position: relative;
							margin-top: 4px;
							margin-bottom: 4px;
							padding: 0 !important;
							margin-left: 6px;
							margin-right: 0;
						}

						/* .selection_box:hover {
							border-color: #d0d0d0;
						}

						.selection_box.selected {
							border-width: 1px;
							border-color: #e47911;
						} */
						.selection_box .active,
						.selection_box .hover {
							display: none;
						}

						.selection_box.selected .default {
							display: none;
						}

						.selection_box.selected .active {
							display: inline-block;
						}

						.selection_box:hover .default,
						.selection_box:hover .active {
							display: none;
						}

						.selection_box:hover .hover {
							display: inline-block;
						}

						.selection_box.selected:hover .active {
							display: inline-block;
						}

						.selection_box.selected:hover .hover {
							display: none;
						}

						.selection_box img {
							width: 38px;
							height: auto;
						}
					</style>
					<script>
						var slider_md_2;
						var isSliderMD2Init = false;
						jQuery(function($) {
							$('.selection_box').on('click', function() {
								var selected_option = $(this).find('img').data('option');
								$('.selection_box').removeClass('selected');
								$(this).addClass('selected');

								$('.option_text').removeClass('selected');
								$('.option_text[data-option="' + selected_option + '"]').addClass('selected');

								if (selected_option == 'no_chart') {
									$('.chart_toggle_in_title').hide();
									$('.slider_md_whole_wrapper.slider_1').hide();
									$('.slider_md_whole_wrapper.slider_2').show();

									if (!isSliderMD2Init) {
										slider_md_2 = tns({
											container: '.my-slider-md_2',
											items: 1,
											navAsThumbnails: true,
											navContainer: '#slider_md_thumbnails_2',
											navPosition: 'top',
											controls: false,
											center: true,
											preventScrollOnTouch: 'auto',
											gutter: 30,
											loop: false,
											speed: 0,
											animateIn: 'no_fade',
											animateOut: 'no_fade',
											autoHeight: true,
											lazyload: true
										});
										$('.my-slider-md_2').find('img').on('load', function() {
											$(this).parents('.slider_md_wrapper').find('.image_canvas_caption .default_caption').show();
											slider_md_2.updateSliderHeight();
										});
										isSliderMD2Init = true;
									}
									slider_md_2.goTo('first');

								} else {
									$('.chart_toggle_in_title').show();
									$('.slider_md_whole_wrapper.slider_2').hide();
									$('.slider_md_whole_wrapper.slider_1').show();
								}
							})
						})
					</script>
					<div class="selection_boxes">
						<div class="selection_box selected">
							<img class="default" src="<?php echo JUri::base() . 'images/icon/bundle_default.svg'; ?>" alt="With our exclusive chart posters" data-option="with_chart">
							<img class="active" src="<?php echo JUri::base() . 'images/icon/bundle_selected.svg'; ?>" alt="With our exclusive chart posters" data-option="with_chart">
							<img class="hover" src="<?php echo JUri::base() . 'images/icon/bundle_over.svg'; ?>" alt="With our exclusive chart posters" data-option="with_chart">
						</div>
						<div class="selection_box">
							<img class="default" src="<?php echo JUri::base() . 'images/icon/plus_default.svg'; ?>" alt="Without our exclusive chart posters" data-option="no_chart">
							<img class="active" src="<?php echo JUri::base() . 'images/icon/plus_selected.svg'; ?>" alt="With our exclusive chart posters" data-option="no_chart">
							<img class="hover" src="<?php echo JUri::base() . 'images/icon/plus_over.svg'; ?>" alt="With our exclusive chart posters" data-option="no_chart">
						</div>
					</div>
				<?php } ?>
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
			if (isEdupack($product_type)) {
				include JPATH_SITE . '/php_html_templates/prod_detail/edupack_datatable2.php';
			}  ?>
		</div>

		<?php if (isset($this->product->source->event->afterDisplayContent)) : ?>
			<?php echo $this->product->source->event->afterDisplayContent; ?>
		<?php endif; ?>
	</div>
</div>
<style>
	@media (min-width: 992px) {
		.deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs a.img_link .img_wrapper img {
			max-width: calc((100vw - 250px) / 8);
			max-height: calc((100vw - 250px) / 8);
		}

		.img_wrapper {
			display: table-cell;
		}

		.btn2 {
			margin: 10px 0;
			width: 45%;
		}

		.btn2 .hover,
		.btn2 .focus {
			display: none;
		}

		.btn2:hover .default {
			display: none;
		}

		.btn2:hover .hover {
			display: block;
		}

		.btn2.focus .hover,
		.btn2.focus .default {
			display: none;
		}

		.btn2.focus img.focus {
			display: block;
		}

		.btn2.to_bundle {
			float: left;
		}

		.btn2.to_amz {
			float: right;
		}

	}

	.productGallery .modal-dialog .modal-content .modal-body .thumbnails li .image-wrapper .a-image-wrapper {
		text-align: center;
	}
</style>
<?php /* if ($product_type == 'bundle') { ?>

	<div class="row">
		<div class="col-xs-12 singles_wrapper">

			<div class="singles">
				<?php $i = 1;
				foreach ($product_thumbs as $product_thumb) { ?>
					<div class="single_wrapper">
						<div class="single">
							<a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $product_thumb['j2store_product_id']); ?>">
								<div class="img_wrapper">
									<img class="lazyload" data-src="/<?php echo $product_thumb['main_image']; ?>" />
								</div>
							</a>
							<div class="list_content">
								<a class="title" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $product_thumb['j2store_product_id']); ?>"><?php echo $product_thumb['title']; ?></a>
								<?php echo $product_thumb['introtext']; ?>
							</div>

						</div>
					</div>
				<?php echo ($i % 2 == 0 ?  '<div class="clearfix"></div>' : '');
					$i++;
				} ?>
			</div>

		</div>
	</div>
<?php } */ ?>

<?php
if ($product_type != 'bundle') { ?>
	<?php if (count($related_bundles) > 0) { ?>
		<div class="row bundles">
			<div class="col-xs-12 deco_bundles_wrapper">
				<div class="deco_bundles">
					<h2>Related Bundles</h2>
					<?php $j = 0;
					foreach ($related_bundles as $bundle) { ?>
						<div class="deco_bundle_wrapper">
							<a class="bundle_title" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $bundle['j2store_product_id']); ?>">
								<?php echo $bundle['title'];
								?>
							</a>
							<div class="matched_tags">
								<span>Matched Tags:</span>
								<?php
								$matched_tag_titles = explode(',', $bundle['matched_tag_titles']);
								$matched_tag_alias = explode(',', $bundle['matched_tag_alias']);
								$i = 0;
								foreach ($matched_tag_titles as $matched_tag_title) {
									if ($i > 0) {
										echo ', ';
									} ?><a target="_blank" href="<?php echo JUri::base() . 'tag/' . $matched_tag_alias[$i]; ?>"><?php echo $matched_tag_title; ?></a>
								<?php
									$i++;
								}
								?>
							</div>

							<div class="slider_sm_wrapper hidden-md hidden-lg">
								<div class="sm_slider" data-id="<?php echo $j ?>">

									<div><img class="tns-lazy-img" data-src="/<?php echo $bundle['thumb_image'] ?>" /></div>

									<?php
									$params = json_decode($bundle['params']);
									$img_names = $params->img_names;
									foreach ($img_names as $img_name) { ?>
										<div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" /></div>
									<?php } ?>
								</div>

								<div class="btn_to_amazon to_single">
									<?php /*<span class="a-button-inner">
										<i class="a-icon a-icon-buynow"></i>
										<input title="これを買おう" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
										<span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
											アマゾンでこれを買う
										</span>
									</span>*/ ?>
								</div>

								<div class="btn_to_amazon to_single">
								</div>
							</div>

							<div class="deco_bundle hidden-sm hidden-xs" data-id="<?php echo $bundle['content_id']; ?>">
								<div class="bundle_thumb">
									<a class="img_link" data-fancybox="gallery" href="<?php echo getImgSizeUrl($bundle['thumb_image'], 'XL'); ?>">
										<div class="img_wrapper">
											<img class="lazyload" src="https://placehold.it/183x205/FFFFFF/FFFFFF" data-src="/<?php echo $bundle['thumb_image']; ?>" />
										</div>
									</a>
									<a class="btn2 to_amz" href="#">
										<img class="default" src="<?php echo JUri::base() . 'images/icon/amazon_default.svg'; ?>" />
										<img class="hover" src="<?php echo JUri::base() . 'images/icon/amazon_over.svg'; ?>" />
										<img class="focus" src="<?php echo JUri::base() . 'images/icon/amazon_down.svg'; ?>" />
									</a>
									<a class="btn2 to_bundle" href="#">
										<img class="default" src="<?php echo JUri::base() . 'images/icon/more_default.svg'; ?>" />
										<img class="hover" src="<?php echo JUri::base() . 'images/icon/more_over.svg'; ?>" />
										<img class="focus" src="<?php echo JUri::base() . 'images/icon/more_down.svg'; ?>" />
									</a>
								</div>
								<div class="vertical_line"></div>
								<div class="col_2 hidden-sm hidden-xs">
									<div class="deco_thumbs">
										<?php
										foreach ($img_names as $img_name) {
										?>
											<a class="img_link" data-fancybox="gallery" href="<?php echo getImgSizeUrl($img_name, 'XL') ?>">
												<div class="img_wrapper">
													<img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
												</div>
											</a>
										<?php
										}
										?>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>
						</div>

						<!-- Modal -->
						<div class="modal productGallery" data-id="<?php echo $j ?>" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel" data-backdrop="false">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-body">
										<div class="back_btn_wrapper">
											<button type="button" class="btn btn-default back" data-dismiss="modal"></button>
											<div class="back_btn_text">
												<span>戻る</span>
											</div>
										</div>

										<div class="productGallery_slider" data-id="<?php echo $j ?>">
											<div><img class="lazyload" data-src="/<?php echo $bundle['thumb_image'] ?>" /></div>

											<?php foreach ($img_names as $img_name) { ?>
												<div><img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" /></div>
											<?php } ?>
										</div>
										<ul class="thumbnails slider_sm_thumbnails" data-id="<?php echo $j ?>">
											<li>
												<div class="image-wrapper">
													<div class="a-image-wrapper">
														<img class="lazyload" data-src="/<?php echo $bundle['thumb_image'] ?>" />
													</div>
												</div>
											</li>

											<?php
											foreach ($img_names as $img_name) { ?>
												<li>
													<div class="image-wrapper">
														<div class="a-image-wrapper">
															<img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
														</div>
													</div>
												</li>
											<?php
											} ?>
											<div class="clearfix"></div>
										</ul>
									</div>
								</div>
							</div>
						</div>
					<?php $j++;
					} ?>
				</div>
			</div>
		</div>
<?php }
}
