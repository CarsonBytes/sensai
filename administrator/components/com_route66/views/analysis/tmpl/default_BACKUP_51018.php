<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;
?>
<?php if($this->isPro): ?>
<script type="text/javascript">
<<<<<<< HEAD
jQuery(document).ready(function() {
	Route66UrlAnalyzer.start();
});
Joomla.submitbutton = function(task){
		if(!document.formvalidator.isValid(document.getElementById('adminForm'))) {
			return false;
		}
		Route66UrlAnalyzer.fetchPage();
}
=======
window.addEventListener('DOMContentLoaded', function(event) {
	Route66Analyzer.start();
	Joomla.submitbutton = function(task){
		if(!document.formvalidator.isValid(document.getElementById('adminForm'))) {
			return false;
		}
		Route66Analyzer.fetchPage();
	}
});

>>>>>>> be1d76ddc590818e7daa9d8e2f54c9cd5714abe2
</script>
<?php endif; ?>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm" id="adminForm" class="form form-horizontal">
		<div id="j-main-container">
			<?php if($this->isPro): ?>
			<?php echo $this->form->renderField('url', 'route66seo'); ?>
			<?php echo $this->form->renderField('keyword', 'route66seo'); ?>
			<div id="route66-seo-analysis-results-container">
				<?php echo $this->form->renderField('preview', 'route66seo'); ?>
				<?php echo $this->form->renderField('score', 'route66seo'); ?>
				<?php echo $this->form->renderField('analysis', 'route66seo'); ?>
			</div>
			<?php else: ?>
				<img src="<?php echo JUri::root(true) ;?>/media/route66/images/seo-analysis-screenshot.jpg" class="img-polaroid"/>
			<?php endif; ?>
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
			<?php echo Route66HelperHtml::copyrights(); ?>
		</div>
</form>