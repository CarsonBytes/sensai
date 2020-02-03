<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if ($this->countModules('slider')) : ?>
	<!-- t3-slider -->
	<div class="wrap t3_slider">
		<div class="row">
			<div class="col-md-5 col-xs-12 col-sm-5">
				<jdoc:include type="modules" name="<?php $this->_p('slider-left') ?>" />
			</div>
			<div class="col-md-7 col-xs-12 col-sm-7">
				<jdoc:include type="modules" name="<?php $this->_p('slider-right') ?>" />
			</div>
		</div>
	</div>
	<!-- //t3-slider  -->
<?php endif ?>
