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
							<div class="free_audio_posters_slogan">Your Free Audio ePosters Here!</div>
							<div class="fade"></div>
							<img src="<?php echo JURI::root() ?>images/page/common/header/topbar.jpg">
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
					<a class="promo_logo" href="#">
						<img class="base" src="<?php echo JURI::root() ?>images/page/common/header/app_base.svg" alt="App" />
						<img class="hover" src="<?php echo JURI::root() ?>images/page/common/header/app_over.svg" alt="App" />
						<img class="active" src="<?php echo JURI::root() ?>images/page/common/header/app_highlight.svg" alt="App" />
						<div>App</div>
					</a>
					<a class="promo_logo" href="#">
						<img class="base" src="<?php echo JURI::root() ?>images/page/common/header/pdf_base.svg" alt="High Res PDF" />
						<img class="hover" src="<?php echo JURI::root() ?>images/page/common/header/pdf_over.svg" alt="High Res PDF" />
						<img class="active" src="<?php echo JURI::root() ?>images/page/common/header/pdf_highlight.svg" alt="High Res PDF" />
						<div>High Res PDF</div>
					</a>
					<a class="promo_logo" href="#">
						<img class="base" src="<?php echo JURI::root() ?>images/page/common/header/QR-code_base.svg" alt="QR code" />
						<img class="hover" src="<?php echo JURI::root() ?>images/page/common/header/QR-code_over.svg" alt="QR code" />
						<img class="active" src="<?php echo JURI::root() ?>images/page/common/header/QR-code_highlight.svg" alt="QR code" />
						<div>QR code</div>
					</a>
					<a class="promo_logo" href="#">
						<img class="base" src="<?php echo JURI::root() ?>images/page/common/header/audio_base.svg" alt="Audio" />
						<img class="hover" src="<?php echo JURI::root() ?>images/page/common/header/audio_over.svg" alt="Audio" />
						<img class="active" src="<?php echo JURI::root() ?>images/page/common/header/audio_highlight.svg" alt="Audio" />
						<div>Audio</div>
					</a>
					<jdoc:include type="modules" name="<?php $this->_p('topbar-right') ?>" />
				</div>
			</div>
		</div>
	</div>
</nav>
<!-- //HEADER -->