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

$document = JFactory::getDocument();
$document->addStyleSheet('https://cdn.jsdelivr.net/npm/tabulator-tables@4.5.3/dist/css/tabulator.min.css');
$document->addStyleSheet('https://cdn.jsdelivr.net/npm/tiny-slider@2.9.2/dist/tiny-slider.css');
$document->addScript('https://cdn.jsdelivr.net/combine/npm/tiny-slider@2.9.2,npm/tabulator-tables@4.5.3,npm/image-map-resizer@1.0.10,npm/jquery-zoom@1.7.21,npm/lazysizes@5.2.0,npm/lazysizes@5.2.0/plugins/attrchange/ls.attrchange.min.js');
$document->addScript('/js/prod_detail.js');
$document->addScript('/js/sm_slider.js');

$query = "SELECT note FROM `h1232_content` b WHERE b.id = " . $this->product->product_source_id;

$database = JFactory::getDbo();
$database->setQuery($query);
//$result = $database->loadAssocList();
$product_type = $database->loadResult();

// echo '<pre>';
//var_dump($this->product->product_source_id);
//var_dump($this->product->j2store_product_id);

if ($product_type == 'bundle') {
	$query = "SELECT bs.bundle_id, a.j2store_product_id, b.title, b.introtext, e.thumb_image FROM `h1232_j2store_products` a 
	INNER JOIN `h1232_content` b ON a.product_source_id = b.id
	LEFT JOIN `h1232_j2store_productimages` e ON a.j2store_product_id = e.product_id
	LEFT JOIN `bundle_single` bs ON bs.single_id = b.id
	WHERE bs.bundle_id = " . $this->product->product_source_id . "
	ORDER by bs.id";
} else {
	// deco or image posters

	//bundles query
	$query2 = "SELECT b.id, a.j2store_product_id, b.title, b.introtext, e.thumb_image FROM `h1232_j2store_products` a 
	INNER JOIN `h1232_content` b ON a.product_source_id = b.id
	LEFT JOIN `h1232_j2store_productimages` e ON a.j2store_product_id = e.product_id
	WHERE b.id in (SELECT bundle_id FROM sensaiho_nya.bundle_single where single_id = " . $this->product->product_source_id . ")
	ORDER by b.id";
	$database->setQuery($query2);
	$bundles = $database->loadAssocList();
	// var_dump($bundles);

	//bundle products query
	$query = "SELECT bs.bundle_id, a.j2store_product_id, b.title, e.thumb_image FROM `h1232_j2store_products` a 
	INNER JOIN `h1232_content` b ON a.product_source_id = b.id
	LEFT JOIN `h1232_j2store_productimages` e ON a.j2store_product_id = e.product_id
	LEFT JOIN `bundle_single` bs ON bs.single_id = b.id
	WHERE bs.bundle_id in (SELECT bundle_id FROM sensaiho_nya.bundle_single where single_id = " . $this->product->product_source_id . ")
	ORDER by bs.id";
}

$database->setQuery($query);
$product_thumbs = $database->loadAssocList();
// var_dump($product_thumbs);

// echo '</pre>';

function getImgSizeUrl($url, $width = 'L')
{
	//width : XL, L, M, S, XS
	$all_sizes = array('_2000', '_1500', '_762', '_277', '_50');

	switch ($width) {
		case 'XL':
			return str_replace($all_sizes, '_2000', $url);
			break;
		case 'L':
			return str_replace($all_sizes, '_1500', $url);
			break;
		case 'M':
			return str_replace($all_sizes, '_762', $url);
			break;
		case 'S':
			return str_replace($all_sizes, '_277', $url);
			break;
		case 'XS':
			return str_replace($all_sizes, '_50', $url);
			break;
	}
	return false;
}

?>
<div itemscope itemtype="http://schema.org/Product" class="product-<?php echo $this->product->j2store_product_id; ?> <?php echo $this->product->product_type; ?>-product">
	<div class="row">
		<div class="col-sm-12 hidden-md hidden-lg">
			<?php echo $this->loadTemplate('title'); ?>
		</div>

		<div class="col-sm-12 col-md-4 col-lg-4">

			<div class="slider_sm_wrapper hidden-md hidden-lg">
				<div class="my-slider1">

					<div><img src="<?php echo $this->product->main_image ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>

					<?php
					$additional_images = json_decode($this->product->additional_images);
					$additional_images_alts = (array) json_decode($this->product->additional_images_alt);
					$i = 0;
					foreach ($additional_images as $additional_image) { ?>
						<div><img src="<?php echo $additional_image ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
					<?php
						$i++;
					} ?>
				</div>
			</div>

			<div class="slider_md_whole_wrapper hidden-sm hidden-xs">

				<div class="slider_md_thumbnails_wrapper">
					<ul class="thumbnails" id="slider_md_thumbnails">
						<li>
							<div class="image-wrapper">
								<div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($this->product->main_image, 'XS') ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>
							</div>
						</li>

						<?php $i = 0;
						foreach ($additional_images as $additional_image) { ?>
							<li>
								<div class="image-wrapper">
									<div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($additional_image, 'XS') ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
								</div>
							</li>
						<?php
							$i++;
						} ?>
					</ul>
				</div>

				<div class="slider_md_wrapper">
					<div class="my-slider-md">

						<div class="image-wrapper">
							<div class="a-image-wrapper"><img data-id="main" src="<?php echo getImgSizeUrl($this->product->main_image, 'M') ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>
						</div>

						<?php
						$i = 0;
						foreach ($additional_images as $additional_image) { ?>
							<div class="image-wrapper">
								<div class="a-image-wrapper"><img data-id="additional-<?php echo $i ?>" src="/<?php echo getImgSizeUrl($additional_image, 'M') ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
							</div>
						<?php
							$i++;
						} ?>
					</div>

					<div class="image_canvas_caption">
						<div class="image_canvas_caption_wrapper">
							<span>画像にマウスを合わせると拡大されます</span>
						</div>
					</div>
				</div>

			</div>

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
				<?php echo $this->product->source->introtext; ?>
			</div>
			<div class="image_zoom_preview"></div>
		</div>
	</div>
	<?php if ($product_type == 'bundle') { ?>

		<div class="row">
			<div class="col-xs-12 singles_wrapper">

				<div class="singles">
					<?php $i = 1;
					foreach ($product_thumbs as $product_thumb) { ?>
						<div class="single_wrapper">
							<div class="single">
								<a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $product_thumb['j2store_product_id']); ?>">
									<div class="img_wrapper">
										<img src="<?php echo $product_thumb['thumb_image']; ?>" />
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
	<?php } ?>


	<?php if ($product_type == 'deco') { ?>
		<?php if (count($bundles) > 0) { ?>
			<div class="row">
				<div class="col-xs-12 deco_bundles_wrapper">
					<div class="deco_bundles">
						<h2>関連バンドル</h2>
						<?php $j = 0;
						foreach ($bundles as $bundle) { ?>
							<div class="deco_bundle_wrapper">
								<a class="bundle_title" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $bundle['j2store_product_id']); ?>">
									<?php echo $bundle['title']; ?>
								</a>

								<div class="slider_sm_wrapper hidden-md hidden-lg">
									<div class="sm_slider" data-id="<?php echo $j ?>">

										<div><img src="<?php echo $bundle['thumb_image'] ?>" /></div>

										<?php
										$bundle_id = $bundle['id'];
										$this_bundle_decos = array_filter($product_thumbs, function ($var) use ($bundle_id) {
											return ($var['bundle_id'] == $bundle_id);
										});
										foreach ($this_bundle_decos as $this_bundle_deco) { ?>
											<div><img src="<?php echo $this_bundle_deco['thumb_image'] ?>" /></div>
										<?php } ?>
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
								</div>

								<div class="deco_bundle hidden-sm hidden-xs" data-id="<?php echo $bundle['id']; ?>">
									<div class="bundle_thumb">
										<a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $bundle['j2store_product_id']); ?>">
											<div class="img_wrapper">
												<img src="<?php echo $bundle['thumb_image']; ?>" />
											</div>
										</a>
										<div class="btn_to_amazon to_single">
											<span class="a-button-inner">
												<i class="a-icon a-icon-buynow"></i>
												<input title="これを買おう" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
												<span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
													アマゾンでこれを買う
												</span>
											</span>
										</div>
									</div>
									<div class="vertical_line"></div>
									<div class="col_2 hidden-sm hidden-xs">
										<div class="deco_thumbs">
											<?php
											/* $bundle_id = $bundle['id'];
										$this_bundle_decos = array_filter($product_thumbs, function ($var) use ($bundle_id) {
											return ($var['bundle_id'] == $bundle_id);
										}); */

											foreach ($this_bundle_decos as $this_bundle_deco) {
											?>
												<a class="img_link" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $this_bundle_deco['j2store_product_id']); ?>">
													<div class="img_wrapper">
														<img src="<?php echo $this_bundle_deco['thumb_image']; ?>" />
													</div>
												</a>
											<?php
											} ?>
										</div>
										<div class="clearfix"></div>
										<div class="bundle_desc_wrapper">
											<div class="bundle_desc">
												<?php echo $bundle['introtext']; ?>
											</div>
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
												<div><img src="<?php echo $bundle['thumb_image'] ?>" /></div>

												<?php foreach ($this_bundle_decos as $this_bundle_deco) { ?>
													<div><img src="<?php echo $this_bundle_deco['thumb_image'] ?>" /></div>
												<?php } ?>
											</div>
											<ul class="thumbnails slider_sm_thumbnails" data-id="<?php echo $j ?>">
												<li>
													<div class="image-wrapper">
														<div class="a-image-wrapper"><img src="<?php echo $bundle['thumb_image'] ?>" /></div>
													</div>
												</li>

												<?php
												foreach ($this_bundle_decos as $this_bundle_deco) { ?>
													<li>
														<div class="image-wrapper">
															<div class="a-image-wrapper"><img src="<?php echo $this_bundle_deco['thumb_image'] ?>" /></div>
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
		<?php } ?>
	<?php } ?>
</div>

<?php if ($product_type == 'image') { ?>
	<?php if ($this->params->get('item_use_tabs', 1)) : ?>
		<?php echo $this->loadTemplate('tabs'); ?>
	<?php else : ?>
		<?php echo $this->loadTemplate('notabs'); ?>
	<?php endif; ?>
<?php } ?>

<?php if (isset($this->product->source->event->afterDisplayContent)) : ?>
	<?php echo $this->product->source->event->afterDisplayContent; ?>
<?php endif; ?>

<!-- Modal -->
<div class="modal" id="productGallery" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel" data-backdrop="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
        <h4 class="modal-title" id="productGalleryLabel"></h4>
      </div>-->
			<div class="modal-body">
				<div class="back_btn_wrapper">
					<button type="button" class="btn btn-default back" data-dismiss="modal"></button>
					<div class="back_btn_text">
						<span>戻る</span>
					</div>
				</div>

				<div class="my-slider2">
					<div><img src="<?php echo $this->baseurl . $this->product->main_image ?>" src="<?php echo $this->product->main_image ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>

					<?php
					$i = 0;
					foreach ($additional_images as $additional_image) { ?>
						<div><img src="<?php echo $this->baseurl . $additional_image ?>" src="<?php echo $additional_image ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
					<?php
						$i++;
					} ?>
				</div>
				<ul class="thumbnails" id="customize-thumbnails">
					<li>
						<div class="image-wrapper">
							<div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($this->product->main_image, 'XS') ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>
						</div>
					</li>

					<?php
					$i = 0;
					foreach ($additional_images as $additional_image) { ?>
						<li>
							<div class="image-wrapper">
								<div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($additional_image, 'XS') ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
							</div>
						</li>
					<?php
						$i++;
					} ?>
				</ul>
			</div>
			<!-- <div class="modal-footer">
      </div> -->
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal" id="productGallery_m" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel_m">
	<div class="vertical_alignment_helper">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="close_btn_wrapper">
					<button type="button" class="btn btn-default close" data-dismiss="modal"><i class="fas fa-times"></i></button>
				</div>
				<div class="modal-body">
					<div class="main_wrapper">
						<div class="thumbnails_column">
							<div class="title"><?php echo $this->loadTemplate('title'); ?></div>
							<div class="thumbnails_wrapper">
								<div class="thumbnails_row_wrapper">
									<div class="image_wrapper">
										<img data-id="main" class="thumbnail_image" src="<?php echo getImgSizeUrl($this->product->main_image, 'XS') ?>" title="<?php echo $this->product->main_image_alt ?>" />
									</div>
									<?php
									$i = 0;
									//$additional_images->{2}=$additional_images->{3};
									foreach ($additional_images as $additional_image) { ?>
										<div class="image_wrapper">
											<img data-id="additional-<?php echo $i ?>" class="thumbnail_image" src="<?php echo getImgSizeUrl($additional_image, 'XS') ?>" title="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" />
										</div>
										<?php if (($i == 2) && count($additional_images) > 3) { ?>
								</div>
								<div class="thumbnails_row_wrapper">
								<?php } ?>

							<?php $i++;
									} ?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="enlarged_image_wrapper">
							<div class="table_wrapper">
								<div class="enlarged_image">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>