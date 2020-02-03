<?php defined('_JEXEC') or die; ?>
<!doctype html>
<html lang="<?php echo $this->item->language; ?>" prefix="op: http://media.facebook.com/op#">
	<head>
		<meta charset="utf-8">
		<link rel="canonical" href="<?php echo $this->item->url; ?>">
		<meta property="op:markup_version" content="v1.0">
		<?php if (count($this->feed->dfpSlots)): ?>
		<meta property="fb:use_automatic_ad_placement" content="true">
		<?php endif; ?>
	</head>
	<body>
		<article>
			<header>
					<?php if (count($this->feed->dfpSlots)): ?>
					<section class="op-ad-template">
						<?php foreach ($this->feed->dfpSlots as $key => $slot): ?>
							<figure class="op-ad <?php if ($key == 0) { echo 'op-ad-default';} ?>">
									<iframe width="<?php echo $slot->width; ?>" height="<?php echo $slot->height; ?>" style="border:0;margin:0;padding:0;">
											 <script type="text/javascript">
											 var googletag = googletag || {};
											 googletag.cmd = googletag.cmd || [];
											 (function() {
													 var gads = document.createElement("script");
													 gads.async = true;
													 gads.type = "text/javascript";
													 var useSSL = "https: " == document.location.protocol;
													 gads.src = (useSSL ? "https:": "http:") + "//www.googletagservices.com/tag/js/gpt.js";
													 var node = document.getElementsByTagName("script")[0];
													 node.parentNode.insertBefore(gads, node);
											 })();
											 </script>
											 <script type="text/javascript">
												 googletag.cmd.push(function() {
													 googletag.defineSlot("/<?php echo $this->feed->settings->get('dfpNetwork'); ?>/<?php echo $slot->name; ?>", [[<?php echo $slot->width; ?>, <?php echo $slot->height; ?>]], "route66-dfp-ad-<?php echo $key; ?>").addService(googletag.pubads());
													 googletag.pubads().collapseEmptyDivs();
													 googletag.enableServices();
												 });
											 </script>
											 <div id="route66-dfp-ad-<?php echo $key; ?>">
												 <script type="text/javascript">
													 googletag.cmd.push(function() {
														 googletag.display("route66-dfp-ad-<?php echo $key; ?>");
													 });
												 </script>
											 </div>
									 </iframe>
						 </figure>
						<?php endforeach; ?>
				</section>
				<?php endif; ?>

					<h1><?php echo $this->item->title; ?></h1>
					<time class="op-published" datetime="<?php echo $this->item->publicationDate; ?>"><?php echo JHTML::_('date', $this->item->publish_up, JText::_('DATE_FORMAT_LC2'), true); ?></time>
					<time class="op-modified" dateTime="<?php echo $this->item->modificationDate; ?>"><?php echo JHTML::_('date', (int) $this->item->modified ? $this->item->modified : $this->item->publish_up, JText::_('DATE_FORMAT_LC2'), true); ?></time>
					<?php if ($this->item->image): ?>
					<figure><img src="<?php echo $this->item->image->src; ?>" /></figure>
					<?php if ($this->item->image->caption): ?>
					<figcaption><?php echo $this->item->image->caption; ?></figcaption>
					<?php endif; ?>
					<?php endif; ?>
					<?php if ($this->item->author): ?>
					<address><a><?php echo $this->item->author; ?></a></address>
					<?php endif; ?>
			</header>
			<?php if ($this->item->text): ?>
			<?php echo $this->item->text; ?>
			<?php endif; ?>

			<?php if ($this->item->video): ?>
			<?php if ($this->item->video->embed): ?>
			<figure class="op-interactive">
					<?php echo $this->item->video->embed; ?>
					<?php if ($this->item->video->title): ?>
							<figcaption class="op-vertical-below">
									<h1><?php echo $this->item->video->title; ?></h1>
							</figcaption>
					<?php endif; ?>
			</figure>
		<?php elseif ($this->item->video->location && $this->item->video->extension == 'mp4'): ?>
			<video><source src="<?php echo $this->item->video->location; ?>" type="video/mp4" /></video>
			<?php endif; ?>
			<?php endif; ?>

			<?php if (count($this->item->gallery)): ?>
			<figure class="op-slideshow">
			<?php foreach ($this->item->gallery as $image): ?>
					<figure>
							 <img src="<?php echo $image->url; ?>" />
							 <?php if ($image->title): ?>
									 <figcaption class="op-vertical-below">
											 <h1><?php echo $image->title ?></h1>
									 </figcaption>
							 <?php endif; ?>
					</figure>
			<?php endforeach; ?>
			</figure>
			<?php endif; ?>
			<?php if ($this->feed->settings->get('gaTrackingId')): ?>
			<figure class="op-tracker">
					<iframe>
						<script>
						(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
								(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
								m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
								})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
								ga('create', <?php echo json_encode($this->feed->settings->get('gaTrackingId')); ?>, 'auto');
								ga('require', 'displayfeatures');
								<?php if ($this->feed->settings->get('gaCampaignSource')): ?>
								ga('set', 'campaignSource', <?php echo json_encode($this->feed->settings->get('gaCampaignSource')); ?>);
								<?php endif; ?>
								<?php if ($this->feed->settings->get('gaCampaignMedium')): ?>
								ga('set', 'campaignMedium', <?php echo json_encode($this->feed->settings->get('gaCampaignMedium')); ?>);
								<?php endif; ?>
								ga('send', 'pageview', {title: <?php echo json_encode($this->item->title); ?>});
						</script>
					</iframe>
			</figure>
			<?php endif; ?>
			<footer>
					<?php if (isset($this->item->related) && count($this->item->related)): ?>
							<ul class="op-related-articles">
									<?php foreach ($this->item->related as $related): ?>
											<li><a href="<?php echo $related->url; ?>"></a></li>
									<?php endforeach; ?>
							</ul>
					<?php endif; ?>
				 <small>&copy; <?php echo $this->feed->siteName; ?></small>
			</footer>
		</article>
	</body>
</html>
