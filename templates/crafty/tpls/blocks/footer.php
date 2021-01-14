<?php

/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<!-- FOOTER -->
<footer id="t3-footer" class="wrap t3-footer">

	<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6')) : ?>
		<!-- FOOT NAVIGATION -->
		<div class="container">
			<?php $this->spotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6') ?>
		</div>
		<!-- //FOOT NAVIGATION -->
	<?php endif ?>

	<section class="t3-copyright">
		<div class="container">
			<div class="row">
				<div class="<?php echo $this->getParam('t3-rmvlogo', 1) ? 'col-md-8' : 'col-md-12' ?> copyright <?php $this->_c('footer') ?>">
					<jdoc:include type="modules" name="<?php $this->_p('footer') ?>" />

				</div>
				<?php if ($this->getParam('t3-rmvlogo', 1)) : ?>
					<div class="col-md-4 poweredby text-hide">
						<!--<a class="t3-logo t3-logo-color" href="http://t3-framework.org" title="<?php echo JText::_('T3_POWER_BY_TEXT') ?>"
						   target="_blank" <?php echo method_exists('T3', 'isHome') && T3::isHome() ? '' : 'rel="nofollow"' ?>><?php echo JText::_('T3_POWER_BY_HTML') ?></a> -->
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

</footer>
<!-- //FOOTER -->

<!-- BACK TOP TOP BUTTON -->

<div id="back-to-top" data-spy="affix" data-offset-top="300" class="back-to-top hidden-xs hidden-sm affix-top">

	<button class="btn btn-primary" title="Back to Top"><i class="fas fa-long-arrow-alt-up"></i></button>

</div>

<script type="text/javascript">
	(function($) {

		// Back to top

		$('#back-to-top').on('click', function() {

			$("html, body").animate({
				scrollTop: 0
			}, 500);

			return false;

		});

	})(jQuery);
</script>

<!-- BACK TO TOP BUTTON -->

<script src="https://cdn.jsdelivr.net/combine/npm/lazysizes@5.3.0,npm/jsrender@1.0.10"></script>
<!-- Modal -->
<script id="modal_dialog_tpl" type="text/x-jsrender">
	<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{:title}}</h5>
					<div class="close_btn_wrapper">
						<button type="button" class="btn btn-default close" data-dismiss="modal"><i class="fas fa-times"></i></button>
					</div>
					</button>
				</div>
				<div class="modal-body">
					{{:message}}
					<br />
					<br />
					<div class="btn_set">
					{{for btns }}
						<button class="{{:name}}" {{if name == 'close' || name == 'cancel'}}data-dismiss="modal"{{/if}} {{if target != null }}data-target="{{:target}}"{{/if}} {{if link != null }}data-link="{{:link}}"{{/if}}>
							<span>
								<span>
									{{:text}}
								</span>
							</span>
						</button>
					  {{/for}}
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
</script>
<div class="modal dialog fade" tabindex="-1" role="dialog"></div>