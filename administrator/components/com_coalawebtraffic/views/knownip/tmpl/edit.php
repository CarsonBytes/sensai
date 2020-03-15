<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Traffic
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL V3 or later; https://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (c) 2020 Steven Palmer All rights reserved.
 *
 * CoalaWeb Traffic is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined('_JEXEC') or die('Restricted access');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.framework', true);

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'knownip.cancel' || document.formvalidator.isValid(document.id('knownip-form')))
		{
			Joomla.submitform(task, document.getElementById('knownip-form'));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_coalawebtraffic&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="knownip-form" class="form-validate">

<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div class="form-horizontal">
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_CWTRAFFIC_NEW_IP', true) : JText::_('COM_CWTRAFFIC_EDIT_IP', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<div class="form-vertical">
        <?php echo $this->form->getControlGroup('description'); ?>
				</div>
			</div>
			<div class="span3">
				<?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
			</div>
		</div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CWTRAFFIC_SLIDER_TITLE_GENERAL', true)); ?>
			<div class="row-fluid">
                <div class="">
                    <div class="alert alert-info">
                        <span class="icon-info-circle"></span> <?php echo JText::_('COM_CWTRAFFIC_IP_OPTION_MSG'); ?>
                    </div>
                    <?php echo $this->form->getControlGroup('ip'); ?>
                    <div class="alert alert-info">
                        <span class="icon-info-circle"></span> <?php echo JText::_('COM_CWTRAFFIC_IP_OPTION_MSG'); ?>
                    </div>
                    <?php echo $this->form->getControlGroup('botname'); ?>
                    <?php echo $this->form->getControlGroup('count'); ?>
                </div>
			</div>

    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('joomla.edit.publishingdata', $this); ?>
			</div>
		</div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>


    <?php echo JHtml::_('bootstrap.endTabSet'); ?>

	</div>

	<input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>
