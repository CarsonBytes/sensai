<?php

/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<!-- HEADER -->
<nav id="t3-topbar" class="t3-topbar">
	<div class="">
		<div class="row">
			<div class="col-lg-7 col-md-6 col-sm-9 col-xs-9 text-left <?php $this->_c('topbar-left') ?>">
				<?php if ($this->countModules('off-canvas')) : ?>
					<div class="off_canvas pull-left">
						<div class="off_canvas_wrapper">
							<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
								<?php $this->loadBlock('off-canvas') ?>
							<?php endif ?>
						</div>
					</div>
				<?php endif ?>
				<div class="top_logo pull-left">
					<a href="/" class="nav-logo-link" aria-label="Amazon" tabindex="6">
						<img src="<?php echo JURI::root() ?>images/page/common/header/logo.png" alt="精彩本屋" />
					</a>
				</div>
				<div class="top_banner_wrapper">
					<a href="#">
						<div class="top_banner">
							<div class="fade"></div>
							<img src="<?php echo JURI::root() ?>images/page/common/header/Fuji_long.jpg">
						</div>
					</a>
				</div>
				<?php /*<div class="pull-left skype">
					<jdoc:include type="modules" name="<?php $this->_p('skype') ?>" />
				</div>
				<div class="pull-left email">
					<jdoc:include type="modules" name="<?php $this->_p('email') ?>" />
				</div>
				<div class="pull-left phone">
					<jdoc:include type="modules" name="<?php $this->_p('phone') ?>" />
				</div> */ ?>
			</div>
			<div class="col-lg-5 col-md-6 col-sm-3 col-xs-3 right-topbar">
				<div class="right-topbar_inner">
					<a class="promo_logo" href="#"><img src="<?php echo JURI::root() ?>images/page/common/header/promo1-quality.png" /></a>
					<a class="promo_logo" href="#"><img src="<?php echo JURI::root() ?>images/page/common/header/promo2_paper.png" /></a>
					<a class="promo_logo" href="#"><img src="<?php echo JURI::root() ?>images/page/common/header/promo3_printing.png" /></a>
					<a class="promo_logo" href="#"><img src="<?php echo JURI::root() ?>images/page/common/header/promo4_satisfaction.png" /></a>
					<a class="promo_logo" href="#"><img src="<?php echo JURI::root() ?>images/page/common/header/promo5_freebie.png" /></a>
					<jdoc:include type="modules" name="<?php $this->_p('topbar-right') ?>" />
				</div>
			</div>
		</div>
	</div>
</nav>
<!-- //HEADER -->