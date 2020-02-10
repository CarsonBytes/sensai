<?php
/**
 * ------------------------------------------------------------------------
 * TP Box template
 * ------------------------------------------------------------------------
 * Copyright (C) 2014-2022 Themeparrot.com. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: Themeparrot
 * Websites:  http://www.themeparrot.com
 * ------------------------------------------------------------------------
 */

defined('_JEXEC') or die;

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimgsm = ($logotype == 'image' && $this->params->get('enable_logoimage_sm', 0)) ? $this->params->get('logoimage_sm', T3Path::getUrl('images/logo-sm.png', '', true)) : false;

//$logoimage = $logotype == 'image' ? $this->params->get('logoimage', T3Path::getUrl('images/logo.png', '', true)) : '';
$logoimage = 'images/logo.jpg';

if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}

$logosize = 'col-lg-2 col-md-2 col-xs-4';

$mainnavsize = 'col-lg-8 col-md-8 col-xs-4';
if ($headright = $this->countModules('head-search or languageswitcherload or off-canvas')) {
	$mainnavsize = 'col-lg-8 col-md-8 col-xs-8';	
}

?>

<!-- HEADER -->
<header id="t3-header" class="wrap t3-header">
	<div class="container">
		<div class="row">
			<!-- LOGO -->
			<div class="<?php echo $logosize ?> logo">
				<div class="logo-<?php echo $logotype, ($logoimgsm ? ' logo-control' : '') ?>">
					<a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
						<?php if($logotype == 'image'): ?>
							<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
						<?php endif ?>
						<?php if($logoimgsm) : ?>
							<img class="logo-img-sm" src="<?php echo JURI::base(true) . '/' . $logoimgsm ?>" alt="<?php echo strip_tags($sitename) ?>" />
						<?php endif ?>
						<span><?php echo $sitename ?></span>
					</a>
					<small class="site-slogan"><?php echo $slogan ?></small>
				</div>
			</div>
			<!-- //LOGO -->
			
			<!-- MAIN NAVIGATION -->
			<nav id="t3-mainnav" class="<?php /* echo $mainnavsize; */ ?>">
				<?php if ($headright): ?>
					<div class="t3-nav-btn pull-right">
						
						<!-- OFFCANVAS -->
						<?php /* if ($this->countModules('off-canvas')) : ?>
							<div class="pull-right">
							<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
								<?php $this->loadBlock ('off-canvas') ?>
							<?php endif ?>
							</div>
						<?php endif */ ?>
						<!-- //OFFCANVAS -->
				
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header pull-right hidden-xs">
						
							<?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
								<?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse">
									<i class="fa fa-bars"></i>
								</button>
							<?php endif ?>
						</div>
					</div>
				<?php endif ?>
				
				<div class="navbar navbar-default t3-mainnav hidden-xs">
			
					<?php if ($this->getParam('navigation_collapse_enable')) : ?>
						<div class="t3-navbar-collapse navbar-collapse collapse"></div>
					<?php endif ?>
			
					<div class="t3-navbar navbar-collapse collapse">
						<jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
					</div>
			
				</div>
				
			</nav>
			<!-- //MAIN NAVIGATION -->
			<div class="col-lg-2 col-md-2 col-xs-12">
				<!-- HEAD SEARCH -->
				<?php if ($this->countModules('head-search')) : ?>
					<div class="dropdown nav-search <?php $this->_c('head-search') ?>">
								<jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="T3Xhtml" />
					</div>
				<?php endif ?>
				<!-- //HEAD SEARCH -->
				
			</div>
		</div>
	</div>
</header>
<!-- //HEADER -->
