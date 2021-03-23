<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
if (version_compare(JVERSION, '3.0', 'lt')) {
    JHtml::_('behavior.tooltip');
}
JHtml::_('behavior.formvalidation');
?>
<style>
    #member-registration fieldset {
        margin-bottom: -30px;
    }

    @media (min-width: 768px) {
        .view-registration .t3-wrapper .t3-mainbody .t3-content .registration .form-validate fieldset .form-group {
            font-size: inherit;
            color: inherit;
        }

        .view-registration .t3-wrapper .t3-mainbody .t3-content .registration .form-validate fieldset .form-group .control-label {
            text-align: right;
        }

        #member-registration {
            margin: 0 auto;
            max-width: 500px;
            border: 0;
        }

        #member-registration .form-group.form-actions div {
            padding: 0 15px !important;
        }

        #member-registration .control-label {
            padding-left: 0;
            padding-right: 0;
        }

        #member-registration legend {
            background: none;
            display: none;
        }

        #member-registration .form-group.field-spacer {
            display: none;
        }
    }
</style>
<div class="registration<?php echo $this->pageclass_sfx ?> item-page">
    <div class="page-header">
        <h2><?php echo $this->escape($this->params->get('page_heading')); ?></h2>
    </div>

    <form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal">
        <?php  // Iterate through the form fieldsets and display each one. 
        ?>
        <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
            <?php $fields = $this->form->getFieldset($fieldset->name); ?>
            <?php if (count($fields)) : ?>
                <fieldset>
                    <?php // If the fieldset has a label set, display it as the legend. 
                    ?>
                    <?php if (isset($fieldset->label)) :
                    ?>
                        <legend><?php echo JText::_($fieldset->label); ?></legend>
                    <?php endif; ?>
                    <?php // Iterate through the fields in the set and display them. 
                    ?>
                    <?php //echo JLayoutHelper::render('joomla.form.renderfield2', $fieldset->name); 
                    ?>
                    <?php echo $this->form->renderFieldset($fieldset->name); ?>
                </fieldset>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="form-group form-actions">
            <div class="col-sm-offset-5 col-sm-7">
                <button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER'); ?></button>
                <a class="btn cancel" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="registration.register" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </div>
    </form>
</div>