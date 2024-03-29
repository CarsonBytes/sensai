<?php
/**
 * BreezingForms - A Joomla Forms Application
 * @version 1.9
 * @package BreezingForms
 * @copyright (C) 2008-2020 by Markus Bopp
 * @license Released under the terms of the GNU General Public License
 **/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

JToolBarHelper::title('<img src="'. JURI::root() . 'administrator/components/com_breezingforms/libraries/jquery/themes/easymode/i/logo-breezingforms.png'.'" align="top"/>');

jimport('joomla.version');
$version = new JVersion();

if(version_compare($version->getShortVersion(), '1.6', '>=')){

	echo '<link rel="stylesheet" href="'.JURI::root(true).'/administrator/components/com_breezingforms/admin/bluestork.fix.css" type="text/css" />';

}

class HTML_facileFormsForm
{
	static function edit($option, $tabpane, $pkg, &$row, &$lists, $caller)
	{
		global $ff_mossite, $ff_admsite, $ff_config;
		$action = $row->id ? BFText::_('COM_BREEZINGFORMS_FORMS_EDIT') : BFText::_('COM_BREEZINGFORMS_FORMS_ADD');
		?>
        <script type="text/javascript" src="<?php echo $ff_admsite; ?>/admin/areautils.js"></script>
        <script type="text/javascript">
            <!--
            function checkNumber(value, msg1, msg2)
            {
                var nonDigits = /\D/;
                var error = '';
                if (value == '')
                    error += msg1;
                else
                if (nonDigits.test(value))
                    error += msg2;
                return error;
            } // checkNumber

            function checkIdentifier(value, msg1, msg2)
            {
                var invalidChars = /\W/;
                var error = '';
                if (value == '')
                    error += msg1;
                else
                if (invalidChars.test(value))
                    error += msg2;
                return error;
            } // checkIdentifier

            var bf_submitbutton = function(pressbutton)
            {
                var form = document.adminForm;
                var error = '';
                if (pressbutton != 'cancel') {
                    if (form.title.value == '')
                        error += "<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TITLEEMPTY'); ?>\n";
                    error += checkIdentifier(
                        form.name.value,
                        "<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NAMEEMPTY'); ?>\n",
                        "<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NAMEIDENT'); ?>\n"
                    );
                    error += checkNumber(
                        form.width.value,
                        "<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_WIDTHEMPTY'); ?>\n",
                        "<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_WIDTHNUMBER'); ?>\n"
                    );
                    error += checkNumber(
                        form.height.value,
                        "<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_HEIGHTEMPTY'); ?>\n",
                        "<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_HEIGHTNUMBER'); ?>\n"
                    );
                } // if
                if (error != '')
                    alert(error);
                else{
                    submitform( pressbutton );
                }
            }; // submitbutton

            if(typeof Joomla != 'undefined'){
                Joomla.submitbutton = bf_submitbutton;
            }

            submitbutton = bf_submitbutton;

            function createInitCode()
            {
                form = document.adminForm;
                name = form.name.value;
                if (name=='') {
                    alert("<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ENTNAMEFIRST'); ?>");
                    return;
                } // if
                if (!confirm("<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CREATEINITNOW'); ?>\n<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_EXISTINGAPPENDED'); ?>")) return;
                code =
                    "function ff_"+name+"_init()\n"+
                    "{\n"+
                    "} // ff_"+name+"_init\n";
                oldcode = form.script1code.value;
                if (oldcode != '')
                    form.script1code.value =
                        code+
                        "\n// -------------- <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_OLDCODEBELOW'); ?> --------------\n\n"+
                        oldcode;
                else
                    form.script1code.value = code;
                codeAreaChange(form.script1code);
            } // createInitCode

            function createSubmittedCode()
            {
                form = document.adminForm;
                name = form.name.value;
                if (name=='') {
                    alert("<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ENTNAMEFIRST'); ?>");
                    return;
                } // if
                if (!confirm("<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CREATESUBMITTEDNOW'); ?>\n<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_EXISTINGAPPENDED'); ?>")) return;
                code =
                    "function ff_"+name+"_submitted(status, message)\n"+
                    "{\n"+
                    "    switch (status) {\n"+
                    "        case FF_STATUS_OK:\n"+
                    "           // do whatever desired on success\n"+
                    "           break;\n"+
                    "        case FF_STATUS_UNPUBLISHED:\n"+
                    "        case FF_STATUS_SAVERECORD_FAILED:\n"+
                    "        case FF_STATUS_SAVESUBRECORD_FAILED:\n"+
                    "        case FF_STATUS_UPLOAD_FAILED:\n"+
                    "        case FF_STATUS_ATTACHMENT_FAILED:\n"+
                    "        case FF_STATUS_SENDMAIL_FAILED:\n"+
                    "        default:\n"+
                    "           alert(message);\n"+
                    "    } // switch\n"+
                    "} // ff_"+name+"_submitted\n";
                oldcode = form.script2code.value;
                if (oldcode != '')
                    form.script2code.value =
                        code+
                        "\n// -------------- <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_OLDCODEBELOW'); ?> --------------\n\n"+
                        oldcode;
                else
                    form.script2code.value = code;
                codeAreaChange(form.script2code);
            } // createSubmittedCode

            function dispheight(value)
            {
                switch (value) {
                    case '0':
                        document.getElementById('heightmargin').style.display = 'none';
                        break;
                    default:
                        document.getElementById('heightmargin').style.display = '';
                } // switch
            } // dispheight

            function dispprevwidth()
            {
                var form = document.adminForm;
                if (form.widthmode.value=='0' || form.prevmode.value=='0')
                    document.getElementById('prevwidthvalue').style.display = 'none';
                else
                    document.getElementById('prevwidthvalue').style.display = '';
            } // dispprevwidth

            function dispinit(value)
            {
                if(document.getElementById) {
                    switch (value) {
                        case '1':
                            document.getElementById('initlib').style.display = '';
                            document.getElementById('initcode').style.display = 'none';
                            break;
                        case '2':
                            document.getElementById('initlib').style.display = 'none';
                            document.getElementById('initcode').style.display = '';
                            break;
                        default:
                            document.getElementById('initlib').style.display = 'none';
                            document.getElementById('initcode').style.display = 'none';
                    } // switch
                } // if
            } // dispinit

            function dispsubmitted(value)
            {
                if(document.getElementById) {
                    switch (value) {
                        case '1':
                            document.getElementById('submittedlib').style.display = '';
                            document.getElementById('submittedcode').style.display = 'none';
                            break;
                        case '2':
                            document.getElementById('submittedlib').style.display = 'none';
                            document.getElementById('submittedcode').style.display = '';
                            break;
                        default:
                            document.getElementById('submittedlib').style.display = 'none';
                            document.getElementById('submittedcode').style.display = 'none';
                    } // switch
                } // if
            } // dispsubmitted

            function dispemail(value)
            {
                if(document.getElementById) {
                    switch (value) {
                        case '0':
                            document.getElementById('emaillogging').style.display = 'none';
                            document.getElementById('emailattachment').style.display = 'none';
                            document.getElementById('emailaddress').style.display = 'none';
                            break;
                        case '1':
                            document.getElementById('emaillogging').style.display = '';
                            document.getElementById('emailattachment').style.display = '';
                            document.getElementById('emailaddress').style.display = 'none';
                            break;
                        default:
                            document.getElementById('emaillogging').style.display = '';
                            document.getElementById('emailattachment').style.display = '';
                            document.getElementById('emailaddress').style.display = '';
                    } // switch
                } // if
            } // dispemail

            function dispp1(value)
            {
                if(document.getElementById) {
                    switch (value) {
                        case '1':
                            document.getElementById('p1lib').style.display = '';
                            document.getElementById('p1code').style.display = 'none';
                            break;
                        case '2':
                            document.getElementById('p1lib').style.display = 'none';
                            document.getElementById('p1code').style.display = '';
                            break;
                        default:
                            document.getElementById('p1lib').style.display = 'none';
                            document.getElementById('p1code').style.display = 'none';
                    } // switch
                } // if
            } // dispp1

            function dispp2(value)
            {
                if(document.getElementById) {
                    switch (value) {
                        case '1':
                            document.getElementById('p2lib').style.display = '';
                            document.getElementById('p2code').style.display = 'none';
                            break;
                        case '2':
                            document.getElementById('p2lib').style.display = 'none';
                            document.getElementById('p2code').style.display = '';
                            break;
                        default:
                            document.getElementById('p2lib').style.display = 'none';
                            document.getElementById('p2code').style.display = 'none';
                    } // switch
                } // if
            } // dispp2

            function dispp3(value)
            {
                if(document.getElementById) {
                    switch (value) {
                        case '1':
                            document.getElementById('p3lib').style.display = '';
                            document.getElementById('p3code').style.display = 'none';
                            break;
                        case '2':
                            document.getElementById('p3lib').style.display = 'none';
                            document.getElementById('p3code').style.display = '';
                            break;
                        default:
                            document.getElementById('p3lib').style.display = 'none';
                            document.getElementById('p3code').style.display = 'none';
                    } // switch
                } // if
            } // dispp3

            function dispp4(value)
            {
                if(document.getElementById) {
                    switch (value) {
                        case '1':
                            document.getElementById('p4lib').style.display = '';
                            document.getElementById('p4code').style.display = 'none';
                            break;
                        case '2':
                            document.getElementById('p4lib').style.display = 'none';
                            document.getElementById('p4code').style.display = '';
                            break;
                        default:
                            document.getElementById('p4lib').style.display = 'none';
                            document.getElementById('p4code').style.display = 'none';
                    } // switch
                } // if
            } // dispp4

            onload = function()
            {
				<?php
				if ($row->script1cond!=0) echo "\t\t\tdispinit('".$row->script1cond."');\n";
				if ($row->script2cond!=0) echo "\t\t\tdispsubmitted('".$row->script2cond."');\n";
				if ($row->piece1cond !=0) echo "\t\t\tdispp1('".$row->piece1cond."');\n";
				if ($row->piece2cond !=0) echo "\t\t\tdispp2('".$row->piece2cond."');\n";
				if ($row->piece3cond !=0) echo "\t\t\tdispp3('".$row->piece3cond."');\n";
				if ($row->piece4cond !=0) echo "\t\t\tdispp4('".$row->piece4cond."');\n";
				switch ($tabpane) {
					case 1:
					case 2:
					case 3:
						echo "\t\t\ttabPane1.setSelectedIndex($tabpane);\n";
						break;
					default:
						echo "\t\t\tdocument.adminForm.title.focus();\n";
				} // switch
				?>
                codeAreaAdd('script1code', 'script1lines');
                codeAreaAdd('script2code', 'script2lines');
                codeAreaAdd('piece1code',  'piece1lines');
                codeAreaAdd('piece2code',  'piece2lines');
                codeAreaAdd('piece3code',  'piece3lines');
                codeAreaAdd('piece4code',  'piece4lines');
            } // onload
            //-->
        </script>
		<?php
		jimport('joomla.version');
		$version = new JVersion();

		if(version_compare($version->getShortVersion(), '3.0', '>=')){
			?>
            <style type="text/css">
                #bftab {
                    float: left !important;
                    margin-right: 20px !important;
                    margin-top: -20px !important;
                }
                .adminlist{
                    width: 70% !important;
                }
            </style>
			<?php
		}
		?>
        <fieldset><legend><?php echo JText::_('COM_BREEZINGFORMS_FORMSETUP');?>: <?php echo htmlentities($row->title, ENT_QUOTES, 'UTF-8')?></legend>
            <div style="float: right;">
                <input class="btn btn-primary" onclick="submitbutton('save');" type="submit" value="<?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_SAVE'), ENT_QUOTES, 'UTF-8'); ?>"/>
                &nbsp;&nbsp;
                <input class="btn btn-primary" onclick="submitbutton('cancel');" type="submit" value="<?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_CANCEL'), ENT_QUOTES, 'UTF-8'); ?>"/>
            </div>
            <div style="clear:both;"></div>
            <form action="index.php?format=html" method="post" name="adminForm" id="adminForm" class="adminForm">
                <table cellpadding="4" cellspacing="1" border="0" style="width: 100%;" width="100%">
                    <tr><td colspan="3" class="title"></td></tr>
                    <tr>
                        <td></td>
                        <td width="100%">
							<?php
							$tabs = new BFTabs(0);
							$tabs->startPane('editPane');
							$tabs->startTab(BFText::_('COM_BREEZINGFORMS_FORMS_SETTINGS'),'tab_settings');
							?>                      <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SETTINGS'); ?></legend>
                                <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                    <tr>
                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TITLE'); ?></td>
                                        <td valign="top">
                                            <input type="text" size="30" maxlength="50" name="title" value="<?php echo $row->title; ?>" class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PACKAGE'); ?></td>
                                        <td valign="top">
                                            <input type="text" size="30" maxlength="30" id="package" name="package" value="<?php echo $row->package; ?>" class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NAME'); ?></td>
                                        <td valign="top">
                                            <input type="text" size="30" maxlength="30" name="name" value="<?php echo $row->name; ?>" class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CLASSFOR'); ?> &lt;div&gt;</td>
                                        <td valign="top">
                                            <input type="text" size="30" maxlength="30" name="class1" value="<?php echo $row->class1; ?>" class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CLASSFOR'); ?> &lt;form&gt;</td>
                                        <td valign="top">
                                            <input type="text" size="30" maxlength="30" name="class2" value="<?php echo $row->class2; ?>" class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ORDERING'); ?></td>
                                        <td valign="top"><?php echo $lists['ordering']; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PUBLISHED'); ?></td>
                                        <td valign="top"><?php echo JHTML::_('select.booleanlist',  "published", "", $row->published); ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_RUNMODE'); ?></td>
                                        <td valign="top">
                                            <select name="runmode" size="1" class="inputbox">
                                                <option value="0"<?php if ($row->runmode==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ANY'); ?></option>
                                                <option value="1"<?php if ($row->runmode==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_FRONTEND'); ?></option>
                                                <option value="2"<?php if ($row->runmode==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_BACKEND'); ?></option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_WIDTH'); ?></td>
                                        <td valign="top">
                                            <input type="text" size="6" maxlength="6" name="width" value="<?php echo $row->width; ?>" class="inputbox" />
                                            <br/>
                                            <select name="widthmode" size="1" onchange="dispprevwidth();" class="inputbox">
                                                <option value="0"<?php if ($row->widthmode==0) echo ' selected="selected"'; ?>>px</option>
                                                <option value="1"<?php if ($row->widthmode==1) echo ' selected="selected"'; ?>>%</option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_HEIGHT'); ?></td>
                                        <td valign="top">
                                            <input type="text" size="6" maxlength="6" name="height" value="<?php echo $row->height; ?>" class="inputbox"/> px
											<?php
											if($row->template_code_processed != 'QuickMode'){
												?>
                                                <br/>
                                                <select name="heightmode" size="1" onchange="dispheight(this.value);" class="inputbox">
                                                    <option value="0"<?php if ($row->heightmode==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_FIXED'); ?></option>
                                                    <option value="1"<?php if ($row->heightmode==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_AUTO'); ?></option>
                                                    <option value="2"<?php if ($row->heightmode==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_AUTOMAX'); ?></option>
                                                </select><span id="heightmargin"<?php if ($row->heightmode==0) echo ' style="display:none;"'; ?>>
					</span>
												<?php
											} else {
												?>
                                                <input type="hidden" name="heightmode" value="0"/>
												<?php
											}
											?>
                                        </td>
                                        <td></td>
                                    </tr>
									<?php
									if($row->template_code_processed == 'QuickMode' || $row->template_code != '' ){
										?>
                                        <tr>
                                            <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_AUTOHEIGHT'); ?></td>
                                            <td valign="top">
                                                <select name="autoheight" class="inputbox">
                                                    <option value="0"<?php if ($row->autoheight==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_AUTOHEIGHT_OFF'); ?></option>
                                                    <option value="1"<?php if ($row->autoheight==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_AUTOHEIGHT_ON'); ?></option>
                                                </select>
                                                <br/>
                                                <i><?php echo BFText::_('COM_BREEZINGFORMS_AUTOHEIGHT_INFO'); ?></i>
                                            </td>
                                            <td></td>
                                        </tr>
										<?php
									}
									?>
									<?php
									if($row->template_code == ''){
										?>
                                        <tr>
                                            <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PREVMODE'); ?></td>
                                            <td valign="top">
                                                <select name="prevmode" size="1" onchange="dispprevwidth();" class="inputbox">
                                                    <option value="0"<?php if ($row->prevmode==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONE'); ?></option>
                                                    <option value="1"<?php if ($row->prevmode==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_BELOW'); ?></option>
                                                    <option value="2"<?php if ($row->prevmode==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_OVERLAYED'); ?></option>
                                                </select>
                                                <span id="prevwidthvalue"<?php if ($row->widthmode==0 || $row->prevmode==0) echo ' style="display:none;"'; ?>>
						&nbsp;&nbsp;&nbsp;&nbsp;<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_WIDTH'); ?>: <input size="6" maxlength="6" name="prevwidth" value="<?php echo $row->prevwidth; ?>" class="inputbox" /> px
					</span>
                                            </td>
                                            <td></td>
                                        </tr>
										<?php
									}
									?>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_LOGTODB'); ?></td>
                                        <td valign="top">
                                            <select name="dblog" size="1" class="inputbox">
                                                <option value="0"<?php if ($row->dblog==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NO'); ?></option>
                                                <option value="1"<?php if ($row->dblog==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONEMPTY'); ?></option>
                                                <option value="2"<?php if ($row->dblog==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ALLVALS'); ?></option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_DOUBLE_OPT'); ?></td>
                                        <td valign="top"><?php echo JHTML::_('select.booleanlist',  "double_opt", "", $row->double_opt); ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_OPT_IN_MAIL_NAME'); ?></td>
                                        <td valign="top">
                                            <input type="text" size="30" maxlength="30" name="opt_mail" value="<?php echo $row->opt_mail; ?>" class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>


                                    <tr>
                                        <td colspan="2" valign="top">
											<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_DESCRIPTION'); ?>
                                            <a href="#" onClick="textAreaResize('description',<?php echo $ff_config->areasmall; ?>);">[<?php echo $ff_config->areasmall; ?>]</a>
                                            <a href="#" onClick="textAreaResize('description',<?php echo $ff_config->areamedium; ?>);">[<?php echo $ff_config->areamedium; ?>]</a>
                                            <a href="#" onClick="textAreaResize('description',<?php echo $ff_config->arealarge; ?>);">[<?php echo $ff_config->arealarge; ?>]</a>
                                            <br/>
                                            <textarea wrap="off" name="description" style="width:100%;" rows="<?php echo $ff_config->areasmall; ?>" class="inputbox"><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></textarea>
                                        </td>
                                        <td></td>
                                    </tr>

                                </table>
                            </fieldset>
							<?php

							$tabs->endTab();
							jimport('joomla.version');
							$version = new JVersion();
							if(version_compare($version->getShortVersion(), '3.1', '>=')){
								$tabs->startTab(BFText::_('COM_BREEZINGFORMS_TAGS_AND_CONTENT'),'tab_tags');
								JHtml::_('tag.ajaxfield', '#tags_form',  true);
								JHtml::_('tag.ajaxfield', '#tags_content',  true);
								$tags = JHtml::_('tag.options');
								// incredible....
								foreach($tags As $tag){
									JFactory::getDbo()->setQuery("Select path From #__tags Where id = " . intval($tag->value));
									$tag->path = JFactory::getDbo()->loadResult();
								}
								$tags = JHelperTags::convertPathsToNames($tags);
								?>              <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_TAGS_AND_CONTENT'); ?></legend>
                                    <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                        <tr>
                                            <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_TAG_FORM'); ?></td>
                                            <td valign="top"><select id="tags_form" name="tags_form[]" class="inputbox" multiple="multiple"><?php
													$saved_tags = explode(',', $row->tags_form);
													foreach($tags As $tag){
														if(in_array(intval($tag->value), $saved_tags)){
															?>
                                                            <option selected="selected" value="<?php echo intval($tag->value);?>"><?php echo htmlentities($tag->text, ENT_QUOTES, 'UTF-8');?></option>
															<?php
														}
													}
													?></select>
                                                <input type="hidden" name="tags_form_oldname" value="<?php echo $row->name?>"/></td>
                                        </tr>
                                        <tr>
                                            <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_TAG_CONTENT'); ?></td>
                                            <td valign="top"><select id="tags_content" name="tags_content[]" class="inputbox" multiple="multiple"><?php
													$saved_tags = explode(',', $row->tags_content);
													foreach($tags As $tag){
														if(in_array(intval($tag->value), $saved_tags)){
															?>
                                                            <option selected="selected" value="<?php echo intval($tag->value);?>"><?php echo htmlentities($tag->text, ENT_QUOTES, 'UTF-8');?></option>
															<?php
														}
													}
													?></select></td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <label for="tags_content_template_selector"><?php echo BFText::_('COM_BREEZINGFORMS_TAG_CONTENT_TEMPLATE_CLICKTOADD'); ?></label>
                                                <div style="height: 600px; width: 190px; overflow: auto;" id="tags_content_template_selector">
												<?php
												jimport( 'joomla.html.editor' );
												$editor = JFactory::getEditor();
												echo bf_getFieldSelectorListHTML($row->id,$editor,'tags_content_template');?></td>
                                            </div>
                                            <td valign="top">
                                                <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_TAG_CONTENT_TEMPLATE'); ?></legend>
													<?php
													JFactory::getDbo()->setQuery("Select `id`, `title` From #__facileforms_elements Where form = " . intval($row->id) . " And `name` Not In ('bfFakeName','bfFakeName2','bfFakeName3','bfFakeName4','bfFakeName5','bfFakeName6') Order by `ordering`");
													$elements = JFactory::getDbo()->loadAssocList();
													?>
                                                    <select style="width: 100%;" name="tags_content_template_default_element" id="tags_content_template_default_element">
                                                        <option value="0"><?php echo BFText::_('COM_BREEZINGFORMS_TAG_CONTENT_TEMPLATE_CHOOSEDEFAULTELEMENT'); ?></option>
														<?php
														foreach($elements As $element){
															?>
                                                            <option value="<?php echo $element['id'];?>"<?php echo $row->tags_content_template_default_element == $element['id'] ? ' selected="selected"' : '';?>><?php echo htmlentities($element['title'], ENT_QUOTES, 'UTF-8');?></option>
															<?php
														}
														?>
                                                    </select>
                                                    <br/><br/>
													<?php
													echo $editor->display("tags_content_template",htmlentities($row->tags_content_template, ENT_QUOTES, 'UTF-8'),'100%',500,40,20,1)
													?>
                                                </fieldset>
                                                <fieldset><legend><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_CONTENT_DEFAULTS'), ENT_QUOTES, 'UTF-8');?></legend>

                                                    <label for="tags_content_default_category"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_CATEGORIES'), ENT_QUOTES, 'UTF-8');?></label>
													<?php
													$categories = facileFormsForm::getCategories();
													?>
                                                    <select style="width: 100%;" name="tags_content_default_category" id="tags_content_default_category">
                                                        <option value="1"><?php echo BFText::_('COM_BREEZINGFORMS_TAG_CONTENT_TEMPLATE_CHOOSEDEFAULTCATEGORY'); ?></option>
														<?php
														foreach($categories As $category){
															?>
                                                            <option value="<?php echo $category->value;?>"<?php echo $row->tags_content_default_category == $category->value ? ' selected="selected"' : '';?>><?php echo htmlentities($category->text, ENT_QUOTES, 'UTF-8');?></option>
															<?php
														}
														?>
                                                    </select>
                                                    <br/><br/>
                                                    <label for="tags_content_default_state"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_STATUS'), ENT_QUOTES, 'UTF-8');?></label>
                                                    <select style="width: 100%;" name="tags_content_default_state" id="tags_content_default_state">
                                                        <option value="1"<?php echo $row->tags_content_default_state == 1 ? ' selected="selected"' : '';?>><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_PUBLISHED'), ENT_QUOTES, 'UTF-8');?></option>
                                                        <option value="0"<?php echo $row->tags_content_default_state == 0 ? ' selected="selected"' : '';?>><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_UPUBLISHED'), ENT_QUOTES, 'UTF-8');?></option>
                                                        <option value="2"<?php echo $row->tags_content_default_state == 2 ? ' selected="selected"' : '';?>><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_ARCHIVED'), ENT_QUOTES, 'UTF-8');?></option>
                                                        <option value="-2"<?php echo $row->tags_content_default_state == -2 ? ' selected="selected"' : '';?>><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_TRASHED'), ENT_QUOTES, 'UTF-8');?></option>
                                                    </select>
                                                    <br/><br/>
                                                    <label for="tags_content_default_access"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_ACCESS'), ENT_QUOTES, 'UTF-8');?></label>
													<?php echo JHtml::_('access.level', 'tags_content_default_access', $row->tags_content_default_access, 'style="width: 100%"', array(), 'tags_content_default_access');?>
                                                    <br/><br/>
                                                    <label for="tags_content_default_language"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_LANGUAGE'), ENT_QUOTES, 'UTF-8');?></label>
                                                    <select style="width: 100%;" name="tags_content_default_language" id="tags_content_default_language">
                                                        <option value="*"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_LANGUAGES_ALL'), ENT_QUOTES, 'UTF-8');?></option>
														<?php
														JFactory::getDbo()->setQuery("Select lang_code From #__languages Where published = 1 Order By ordering");
														$langs = JFactory::getDbo()->loadColumn();
														foreach($langs As $lang){
															?>
                                                            <option value="<?php echo $lang?>"<?php echo $row->tags_content_default_language == $lang ? ' selected="selected"' : '';?>><?php echo htmlentities($lang, ENT_QUOTES, 'UTF-8');?></option>
															<?php
														}
														?>
                                                    </select>
                                                    <br/><br/>
                                                    <label for="tags_content_default_featured"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_FEATURED'), ENT_QUOTES, 'UTF-8');?></label>
                                                    <br/>
                                                    <input type="radio" name="tags_content_default_featured" id="tags_content_default_featured" value="1"<?php echo $row->tags_content_default_featured == 1 ? ' checked="checked"' : '';?>/> <label for="tags_content_default_featured"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_YES'), ENT_QUOTES, 'UTF-8');?></label>
                                                    <input type="radio" name="tags_content_default_featured" id="tags_content_default_featured1" value="0"<?php echo $row->tags_content_default_featured == 0 ? ' checked="checked"' : '';?>/> <label for="tags_content_default_featured1"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_NO'), ENT_QUOTES, 'UTF-8');?></label>
                                                    <br/><br/>
                                                    <label for="tags_content_default_publishup"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_PUBLISHUP'), ENT_QUOTES, 'UTF-8');?></label>
													<?php
													echo JHTML::_('calendar', $row->tags_content_default_publishup, 'tags_content_default_publishup','tags_content_default_publishup','%Y-%m-%d %H:%M:%S','style="margin-top: 5px; width: 80%" ');
													?>
                                                    <label for="tags_content_default_publishdown"><?php echo htmlentities(JText::_('COM_BREEZINGFORMS_PUBLISHDOWN'), ENT_QUOTES, 'UTF-8');?></label>
													<?php
													echo JHTML::_('calendar', $row->tags_content_default_publishdown, 'tags_content_default_publishdown','tags_content_default_publishdown','%Y-%m-%d %H:%M:%S','style="margin-top: 5px; width: 80%" ');
													?>
                                                </fieldset>
                                        </tr>
                                    </table>
                                </fieldset>
								<?php

								$tabs->endTab();
							}
							$tabs->startTab(BFText::_('COM_BREEZINGFORMS_ADMIN_EMAILS'),'tab_admin_emails');
							?>
                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_ADMIN_EMAILS'); ?></legend>
                                <table width="80%" cellpadding="4" cellspacing="1" border="0">
                                    <tr>

                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_EMAILNOTIFY'); ?></td>
                                        <td valign="top">
                                            <select style="width: 335px;" name="emailntf" size="1" onchange="dispemail(this.value);" class="inputbox">
                                                <option value="0"<?php if ($row->emailntf==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NO'); ?></option>
                                                <option value="1"<?php if ($row->emailntf==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_DEFADDR'); ?></option>
                                                <option value="2"<?php if ($row->emailntf==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CUSTADDR'); ?></option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"></td>
                                        <td valign="top">
                                            <table cellpadding="4" cellspacing="4" border="0">
                                                <tr id="emailaddress"<?php if ($row->emailntf!=2) echo ' style="display:none;"'; ?>>
                                                    <td><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_EMAIL'); ?></td>
                                                    <td><input type="text" size="30" name="emailadr" value="<?php echo $row->emailadr; ?>" class="inputbox"/></td>
                                                </tr>
                                                <tr id="emaillogging"<?php if ($row->emailntf==0) echo ' style="display:none;"'; ?>>
                                                    <td><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_REPORT'); ?></td>
                                                    <td>
                                                        <select name="emaillog" size="1" class="inputbox">
                                                            <option value="0"<?php if ($row->emaillog==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_HDRONLY'); ?></option>
                                                            <option value="1"<?php if ($row->emaillog==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONEMPTY'); ?></option>
                                                            <option value="2"<?php if ($row->emaillog==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ALLVALS'); ?></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="emailattachment"<?php if ($row->emailntf==0) echo ' style="display:none;"'; ?>>
                                                    <td><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ATTACHMENT'); ?> </td>
                                                    <td>
                                                        <select name="emailxml" size="1" class="inputbox">
                                                            <option value="0"<?php if ($row->emailxml==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NO'); ?></option>
                                                            <option value="1"<?php if ($row->emailxml==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_XML'); ?></option>
                                                            <!--<option value="2"<?php if ($row->emailxml==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_XML_ALLVALS'); ?></option>-->
                                                            <option value="3"<?php if ($row->emailxml==3) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_CSV'); ?></option>
                                                            <option value="4"<?php if ($row->emailxml==4) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_PDF'); ?></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>

                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_ALT_MAILFROM'); ?></td>
                                        <td valign="top">
                                            <input type="text" name="alt_mailfrom"  value="<?php echo $row->alt_mailfrom; ?>" size="50"  class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>

                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_ALT_FROMNAME'); ?></td>
                                        <td valign="top">
                                            <input type="text" name="alt_fromname"  value="<?php echo $row->alt_fromname; ?>" size="50"  class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>

                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_CUSTOM_MAIL_SUBJECT'); ?></td>
                                        <td valign="top">
                                            <input type="text" name="custom_mail_subject"  value="<?php echo $row->custom_mail_subject; ?>" size="50"  class="inputbox"/>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td valign="top" nowrap><?php echo BFText::_('COM_BREEZINGFORMS_EDIT_EMAILS'); ?>
                                            <br/>
                                            <br/>
                                            <div style="height: 250px; overflow: auto;<?php echo $row->email_type == 0 ? ' display: none;' : '' ?>" id="email_custom_template_picker">
                                                <?php
                                                jimport( 'joomla.html.editor' );
                                                $editor = JFactory::getEditor();
                                                echo bf_getFieldSelectorListEditor($row->id, $editor, 'email_custom_template');?>
                                            </div>
                                        </td>
                                        <td valign="top">
                                            <input onclick="document.getElementById('email_custom_template_div').style.display='none';document.getElementById('email_custom_template_picker').style.display='none';" type="radio" name="email_type" value="0"<?php echo $row->email_type == 0 ? ' checked="checked"' : ''?>/> <?php echo BFText::_('COM_BREEZINGFORMS_EMAIL_TYPE_DEFAULT');?>
                                            <input onclick="document.getElementById('email_custom_template_div').style.display='';document.getElementById('email_custom_template_picker').style.display='';" type="radio" name="email_type" value="1"<?php echo $row->email_type == 1 ? ' checked="checked"' : ''?>/> <?php echo BFText::_('COM_BREEZINGFORMS_EMAIL_TYPE_CUSTOM');?>
                                            <div id="email_custom_html" style="display: none;">
                                                <br/>
												<?php echo BFText::_('COM_BREEZINGFORMS_EMAIL_CUSTOM_HTML');?>
                                                <input type="radio" name="email_custom_html" value="0" /> <?php echo BFText::_('COM_BREEZINGFORMS_NO');?>
                                                <input type="radio" name="email_custom_html" value="1" checked="checked" /> <?php echo BFText::_('COM_BREEZINGFORMS_YES');?>
                                            </div>
                                            <br/>
                                            <div id="email_custom_template_div" <?php echo $row->email_type == 0 ? 'style="display: none;"' : '' ?>>
                                                <p>If you want to use HTML in mail, please enter it through Tools &gt; Source Code in Editor</p>
												<?php $editor = JFactory::getConfig()->get('editor');
												$editor = JEditor::getInstance($editor);
												echo $editor->display('email_custom_template', htmlentities($row->email_custom_template, ENT_QUOTES, 'UTF-8'), '100%', '500px', '20', '20', true, null, null, null, array());
												?>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                            </fieldset>

							<?php

							$tabs->endTab();
							$tabs->startTab(BFText::_('COM_BREEZINGFORMS_MAILBACK_EMAILS'),'tab_mailback_emails');
							?>
                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_MAILBACK_EMAILS'); ?></legend>
                                <table width="80%" cellpadding="4" cellspacing="1" border="0">
                                    <tr>
                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_EMAILNOTIFY'); ?></td>

                                        <td valign="top">
                                            <table cellpadding="4" cellspacing="1" border="0">
                                                <tr id="bf_emaillogging"<?php if ($row->mb_emailntf==0) echo ' style="display:none;"'; ?>>
                                                    <td><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_REPORT'); ?></td>
                                                    <td>
                                                        <select name="mb_emaillog" size="1" class="inputbox">
                                                            <option value="0"<?php if ($row->mb_emaillog==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_HDRONLY'); ?></option>
                                                            <option value="1"<?php if ($row->mb_emaillog==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONEMPTY'); ?></option>
                                                            <option value="2"<?php if ($row->mb_emaillog==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ALLVALS'); ?></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="bf_emailattachment"<?php if ($row->mb_emailntf==0) echo ' style="display:none;"'; ?>>
                                                    <td><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ATTACHMENT'); ?> </td>
                                                    <td>
                                                        <select name="mb_emailxml" size="1" class="inputbox">
                                                            <option value="0"<?php if ($row->mb_emailxml==0) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NO'); ?></option>
                                                            <option value="1"<?php if ($row->mb_emailxml==1) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_XML'); ?></option>
                                                            <!--<option value="2"<?php if ($row->mb_emailxml==2) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_XML_ALLVALS'); ?></option>-->
                                                            <option value="3"<?php if ($row->mb_emailxml==3) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_CSV'); ?></option>
                                                            <option value="4"<?php if ($row->mb_emailxml==4) echo ' selected="selected"'; ?>><?php echo BFText::_('COM_BREEZINGFORMS_PDF'); ?></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td valign="top"></td>
                                    </tr>
                                    <tr>

                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_ALT_MAILFROM'); ?></td>
                                        <td>
                                            <input type="text" name="mb_alt_mailfrom"  value="<?php echo $row->mb_alt_mailfrom; ?>" size="50"  class="inputbox"/>
                                        </td>
                                        <td valign="top"></td>
                                    </tr>
                                    <tr>

                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_ALT_FROMNAME'); ?></td>
                                        <td>
                                            <input type="text" name="mb_alt_fromname"  value="<?php echo $row->mb_alt_fromname; ?>" size="50"  class="inputbox"/>
                                        </td>
                                        <td valign="top"></td>
                                    </tr>
                                    <tr>

                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_CUSTOM_MAIL_SUBJECT'); ?></td>
                                        <td>
                                            <input type="text" name="mb_custom_mail_subject"  value="<?php echo $row->mb_custom_mail_subject; ?>" size="50"  class="inputbox"/>
                                        </td>
                                        <td valign="top"></td>
                                    </tr>

                                    <tr>
                                        <td valign="top" nowrap><?php echo BFText::_('COM_BREEZINGFORMS_EDIT_EMAILS'); ?>
                                            <br/>
                                            <br/>
                                            <div style="height: 250px; overflow: auto;<?php echo $row->mb_email_type == 0 ? ' display: none;' : '' ?>" id="mb_email_custom_template_picker">
                                                <?php
                                                jimport( 'joomla.html.editor' );
                                                $editor = JFactory::getEditor();
                                                echo bf_getFieldSelectorListEditor($row->id, $editor, 'mb_email_custom_template');?>
                                            </div>
                                        </td>
                                        <td valign="top">
                                            <input onclick="document.getElementById('mb_email_custom_template_div').style.display='none';document.getElementById('mb_email_custom_template_picker').style.display='none';" type="radio" name="mb_email_type" value="0"<?php echo $row->mb_email_type == 0 ? ' checked="checked"' : ''?>/> <?php echo BFText::_('COM_BREEZINGFORMS_EMAIL_TYPE_DEFAULT');?>
                                            <input onclick="document.getElementById('mb_email_custom_template_div').style.display='';document.getElementById('mb_email_custom_template_picker').style.display='';" type="radio" name="mb_email_type" value="1"<?php echo $row->mb_email_type == 1 ? ' checked="checked"' : ''?>/> <?php echo BFText::_('COM_BREEZINGFORMS_EMAIL_TYPE_CUSTOM');?>
                                            <div id="mb_email_custom_html" style="display: none;">
                                                <br/>
												<?php echo BFText::_('COM_BREEZINGFORMS_EMAIL_CUSTOM_HTML');?>
                                                <input type="radio" name="mb_email_custom_html" value="0" /> <?php echo BFText::_('COM_BREEZINGFORMS_NO');?>
                                                <input type="radio" name="mb_email_custom_html" value="1" checked="checked"/> <?php echo BFText::_('COM_BREEZINGFORMS_YES');?>
                                            </div>
                                            <br/>
                                            <div id="mb_email_custom_template_div" <?php echo $row->mb_email_type == 0 ? 'style="display: none;"' : '' ?>>
                                                <p>If you want to use HTML in mail, please enter it through Tools &gt; Source Code in Editor</p>
												<?php $editor = JFactory::getConfig()->get('editor');
												$editor = JEditor::getInstance($editor);
												echo $editor->display('mb_email_custom_template', htmlentities($row->mb_email_custom_template, ENT_QUOTES, 'UTF-8'), '100%', '500px', '20', '20', true, null, null, null, array());
												?>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>

                                </table>
                            </fieldset>

							<?php
							if($row->template_code != '' ){
								?>
                                <input type="hidden" name="prevmode" value="2"/>
                                <input type="hidden" name="nonclassic" value="1"/>
                                <input type="hidden" name="quickmode" value="<?php echo $row->template_code_processed == 'QuickMode' ? '1' : '0'?>"/>
								<?php
							}

							$tabs->endTab();
							$tabs->startTab(BFText::_('COM_BREEZINGFORMS_FORMS_SCRIPTS'),'tab_scripts');
							$subsize = $initsize = $ff_config->areasmall;
							if ($row->script1cond==2)
								$initsize = $ff_config->areamedium;
							else
								if ($row->script2cond==2)
									$subsize = $ff_config->areamedium;
							?>
                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SCRIPTS'); ?></legend>
                                <table width="80%" cellpadding="4" cellspacing="1" border="0">
                                    <tr>
                                        <td valign="top"></td>
                                        <td valign="top">
                                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_INITSCRIPT'); ?></legend>
                                                <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                                    <tr>
                                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TYPE'); ?></td>
                                                        <td valign="top">
                                                            <input type="radio" id="script1cond1" name="script1cond" value="0" onclick="dispinit(this.value)"<?php if ($row->script1cond==0) echo ' checked="checked"'; ?> /><label for="script1cond1"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONE'); ?></label>
                                                            <input type="radio" id="script1cond2" name="script1cond" value="1" onclick="dispinit(this.value)"<?php if ($row->script1cond==1) echo ' checked="checked"'; ?> /><label for="script1cond2"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_LIBRARY'); ?></label>
                                                            <input type="radio" id="script1cond3" name="script1cond" value="2" onclick="dispinit(this.value)"<?php if ($row->script1cond==2) echo ' checked="checked"'; ?> /><label for="script1cond3"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CUSTOM'); ?></label>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="initlib" style="display:none;">
                                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SCRIPT'); ?></td>
                                                        <td valign="top">
                                                            <select name="script1id" class="inputbox">
																<?php
																$scripts = $lists['init'];
																for ($i = 0; $i < count($scripts); $i++) {
																	$script = $scripts[$i];
																	$selected = '';
																	if ($script->id == $row->script1id) $selected = ' selected';
																	echo '<option value="'.$script->id.'"'.$selected.'>'.$script->text.'</option>';
																} // for
																?>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="initcode" style="display:none;">
                                                        <td valign="top" colspan="2">
                                                            <a href="#" onClick="codeAreaResize('script1code',<?php echo $ff_config->areasmall; ?>);">[<?php echo $ff_config->areasmall; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('script1code',<?php echo $ff_config->areamedium; ?>);">[<?php echo $ff_config->areamedium; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('script1code',<?php echo $ff_config->arealarge; ?>);">[<?php echo $ff_config->arealarge; ?>]</a>
                                                            <a href="#" onClick="createInitCode();"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CREATEFRAME'); ?></a>

                                                            <br />
                                                            <textarea onFocus="codeAreaFocus(this);" readonly="readonly" wrap="off" name="script1lines" style="display: none; width:60px;" rows="<?php echo $initsize; ?>" class="inputbox"></textarea>
                                                            <textarea onFocus="codeAreaFocus(this);" onKeyUp="codeAreaChange(this,event);" wrap="off" name="script1code" style="width:100%;" rows="<?php echo $initsize; ?>" class="inputbox"><?php echo htmlspecialchars($row->script1code, ENT_QUOTES); ?></textarea>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SUBMITTEDSCRIPT'); ?></legend>
                                                <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                                    <tr>
                                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TYPE'); ?></td>
                                                        <td valign="top">
                                                            <input type="radio" id="script2cond1" name="script2cond" value="0" onclick="dispsubmitted(this.value)"<?php if ($row->script2cond==0) echo ' checked="checked"'; ?> /><label for="script2cond1"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONE'); ?></label>
                                                            <input type="radio" id="script2cond2" name="script2cond" value="1" onclick="dispsubmitted(this.value)"<?php if ($row->script2cond==1) echo ' checked="checked"'; ?> /><label for="script2cond2"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_LIBRARY'); ?></label>
                                                            <input type="radio" id="script2cond3" name="script2cond" value="2" onclick="dispsubmitted(this.value)"<?php if ($row->script2cond==2) echo ' checked="checked"'; ?> /><label for="script2cond3"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CUSTOM'); ?></label>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="submittedlib" style="display:none;">
                                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SCRIPT'); ?></td>
                                                        <td valign="top">
                                                            <select name="script2id" class="inputbox" size="1">
																<?php
																$scripts = $lists['submitted'];
																for ($i = 0; $i < count($scripts); $i++) {
																	$script = $scripts[$i];
																	$selected = '';
																	if ($script->id == $row->script2id) $selected = ' selected';
																	echo '<option value="'.$script->id.'"'.$selected.'>'.$script->text.'</option>';
																} // for
																?>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="submittedcode" style="display:none;">
                                                        <td valign="top" colspan="2">
                                                            <a href="#" onClick="codeAreaResize('script2code',<?php echo $ff_config->areasmall; ?>);">[<?php echo $ff_config->areasmall; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('script2code',<?php echo $ff_config->areamedium; ?>);">[<?php echo $ff_config->areamedium; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('script2code',<?php echo $ff_config->arealarge; ?>);">[<?php echo $ff_config->arealarge; ?>]</a>
                                                            <a href="#" onClick="createSubmittedCode();"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CREATEFRAME'); ?></a>
                                                            <br />
                                                            <textarea onFocus="codeAreaFocus(this);" readonly="readonly" wrap="off" name="script2lines" style="display:none; width:60px;" rows="<?php echo $subsize; ?>" class="inputbox"></textarea>
                                                            <textarea onFocus="codeAreaFocus(this);" onKeyUp="codeAreaChange(this,event);" wrap="off" name="script2code" style="width:100%;" rows="<?php echo $subsize; ?>" class="inputbox"><?php echo htmlspecialchars($row->script2code, ENT_QUOTES); ?></textarea>
                                                        </td>
                                                        <td valign="top"></td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                            </fieldset>
							<?php
							$tabs->endTab();
							$tabs->startTab(BFText::_('COM_BREEZINGFORMS_FORMS_FORMPIECES'),'tab_formpieces');
							$p1size = $p2size = $ff_config->areasmall;
							if ($row->piece1cond==2)
								$p1size = $ff_config->areamedium;
							else
								if ($row->piece2cond==2)
									$p2size = $ff_config->areamedium;
							?>
                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_FORMPIECES'); ?></legend>
                                <table width="80%" cellpadding="4" cellspacing="1" border="0">
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_BEFOREFORM'); ?></legend>
                                                <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                                    <tr>
                                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TYPE'); ?></td>
                                                        <td valign="top">
                                                            <input type="radio" id="piece1cond0" name="piece1cond" value="0" onclick="dispp1(this.value)"<?php if ($row->piece1cond==0) echo ' checked="checked"'; ?> /><label for="piece1cond0"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONE'); ?></label>
                                                            <input type="radio" id="piece1cond1" name="piece1cond" value="1" onclick="dispp1(this.value)"<?php if ($row->piece1cond==1) echo ' checked="checked"'; ?> /><label for="piece1cond1"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_LIBRARY'); ?></label>
                                                            <input type="radio" id="piece1cond2" name="piece1cond" value="2" onclick="dispp1(this.value)"<?php if ($row->piece1cond==2) echo ' checked="checked"'; ?> /><label for="piece1cond2"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CUSTOM'); ?></label>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p1lib" style="display:none;">
                                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PIECE'); ?></td>
                                                        <td valign="top">
                                                            <select name="piece1id" class="inputbox" size="1">
																<?php
																$pieces = $lists['piece1'];
																for ($i = 0; $i < count($pieces); $i++) {
																	$piece = $pieces[$i];
																	$selected = '';
																	if ($piece->id == $row->piece1id) $selected = ' selected';
																	echo '<option value="'.$piece->id.'"'.$selected.'>'.$piece->text.'</option>';
																} // for
																?>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p1code" style="display:none;">
                                                        <td valign="top" colspan="2">
                                                            <a href="#" onClick="codeAreaResize('piece1code',<?php echo $ff_config->areasmall; ?>);">[<?php echo $ff_config->areasmall; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece1code',<?php echo $ff_config->areamedium; ?>);">[<?php echo $ff_config->areamedium; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece1code',<?php echo $ff_config->arealarge; ?>);">[<?php echo $ff_config->arealarge; ?>]</a>
                                                            <br/>
                                                            <textarea onFocus="codeAreaFocus(this);" readonly="readonly" wrap="off" name="piece1lines" style="display: none; width:60px;" rows="<?php echo $p1size; ?>" class="inputbox"></textarea>
                                                            <textarea onFocus="codeAreaFocus(this);" onKeyUp="codeAreaChange(this,event);" wrap="off" name="piece1code" style="width:100%;" rows="<?php echo $p1size; ?>" class="inputbox"><?php echo htmlspecialchars($row->piece1code, ENT_QUOTES); ?></textarea>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_AFTERFORM'); ?></legend>
                                                <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                                    <tr>
                                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TYPE'); ?></td>
                                                        <td valign="top">
                                                            <input type="radio" id="piece2cond0" name="piece2cond" value="0" onclick="dispp2(this.value)"<?php if ($row->piece2cond==0) echo ' checked="checked"'; ?> /><label for="piece2cond0"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONE'); ?></label>
                                                            <input type="radio" id="piece2cond1" name="piece2cond" value="1" onclick="dispp2(this.value)"<?php if ($row->piece2cond==1) echo ' checked="checked"'; ?> /><label for="piece2cond1"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_LIBRARY'); ?></label>
                                                            <input type="radio" id="piece2cond2" name="piece2cond" value="2" onclick="dispp2(this.value)"<?php if ($row->piece2cond==2) echo ' checked="checked"'; ?> /><label for="piece2cond2"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CUSTOM'); ?></label>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p2lib" style="display:none;">
                                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PIECE'); ?></td>
                                                        <td valign="top">
                                                            <select name="piece2id" class="inputbox" size="1">
																<?php
																$pieces = $lists['piece2'];
																for ($i = 0; $i < count($pieces); $i++) {
																	$piece = $pieces[$i];
																	$selected = '';
																	if ($piece->id == $row->piece2id) $selected = ' selected';
																	echo '<option value="'.$piece->id.'"'.$selected.'>'.$piece->text.'</option>';
																} // for
																?>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p2code" style="display:none;">
                                                        <td valign="top" colspan="2">
                                                            <a href="#" onClick="codeAreaResize('piece2code',<?php echo $ff_config->areasmall; ?>);">[<?php echo $ff_config->areasmall; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece2code',<?php echo $ff_config->areamedium; ?>);">[<?php echo $ff_config->areamedium; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece2code',<?php echo $ff_config->arealarge; ?>);">[<?php echo $ff_config->arealarge; ?>]</a>
                                                            <br/>
                                                            <textarea onFocus="codeAreaFocus(this);" readonly="readonly" wrap="off" name="piece2lines" style="display: none; width:60px;" rows="<?php echo $p2size; ?>" class="inputbox"></textarea>
                                                            <textarea onFocus="codeAreaFocus(this);" onKeyUp="codeAreaChange(this,event);" wrap="off" name="piece2code" style="width:100%;" rows="<?php echo $p2size; ?>" class="inputbox"><?php echo htmlspecialchars($row->piece2code, ENT_QUOTES); ?></textarea>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                            </fieldset>
							<?php
							$tabs->endTab();
							$tabs->startTab(BFText::_('COM_BREEZINGFORMS_FORMS_SUBMPIECES'),'tab_submpieces');
							$p3size = $p4size = $ff_config->areasmall;
							if ($row->piece3cond==2)
								$p3size = $ff_config->areamedium;
							else
								if ($row->piece4cond==2)
									$p4size = $ff_config->areamedium;
							?>
                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SUBMPIECES'); ?></legend>
                                <table width="80%" cellpadding="4" cellspacing="1" border="0">
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_BEGINSUBMIT'); ?></legend>
                                                <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                                    <tr>
                                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TYPE'); ?></td>
                                                        <td valign="top">
                                                            <input type="radio" id="piece3cond0" name="piece3cond" value="0" onclick="dispp3(this.value)"<?php if ($row->piece3cond==0) echo ' checked="checked"'; ?> /><label for="piece3cond0"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONE'); ?></label>
                                                            <input type="radio" id="piece3cond1" name="piece3cond" value="1" onclick="dispp3(this.value)"<?php if ($row->piece3cond==1) echo ' checked="checked"'; ?> /><label for="piece3cond1"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_LIBRARY'); ?></label>
                                                            <input type="radio" id="piece3cond2" name="piece3cond" value="2" onclick="dispp3(this.value)"<?php if ($row->piece3cond==2) echo ' checked="checked"'; ?> /><label for="piece3cond2"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CUSTOM'); ?></label>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p3lib" style="display:none;">
                                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PIECE'); ?></td>
                                                        <td valign="top">
                                                            <select name="piece3id" class="inputbox" size="1">
																<?php
																$pieces = $lists['piece3'];
																for ($i = 0; $i < count($pieces); $i++) {
																	$piece = $pieces[$i];
																	$selected = '';
																	if ($piece->id == $row->piece3id) $selected = ' selected';
																	echo '<option value="'.$piece->id.'"'.$selected.'>'.$piece->text.'</option>';
																} // for
																?>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p3code" style="display:none;">
                                                        <td valign="top" colspan="2">
                                                            <a href="#" onClick="codeAreaResize('piece3code',<?php echo $ff_config->areasmall; ?>);">[<?php echo $ff_config->areasmall; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece3code',<?php echo $ff_config->areamedium; ?>);">[<?php echo $ff_config->areamedium; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece3code',<?php echo $ff_config->arealarge; ?>);">[<?php echo $ff_config->arealarge; ?>]</a>
                                                            <br/>
                                                            <textarea onFocus="codeAreaFocus(this);" readonly="readonly" wrap="off" name="piece3lines" style="display: none; width:60px;" rows="<?php echo $p3size; ?>" class="inputbox"></textarea>
                                                            <textarea onFocus="codeAreaFocus(this);" onKeyUp="codeAreaChange(this,event);" wrap="off" name="piece3code" style="width:100%;" rows="<?php echo $p3size; ?>" class="inputbox"><?php echo htmlspecialchars($row->piece3code, ENT_QUOTES); ?></textarea>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2">
                                            <fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ENDSUBMIT'); ?></legend>
                                                <table width="100%" cellpadding="4" cellspacing="1" border="0">
                                                    <tr>
                                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TYPE'); ?></td>
                                                        <td valign="top">
                                                            <input type="radio" id="piece4cond0" name="piece4cond" value="0" onclick="dispp4(this.value)"<?php if ($row->piece4cond==0) echo ' checked="checked"'; ?> /><label for="piece4cond0"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NONE'); ?></label>
                                                            <input type="radio" id="piece4cond1" name="piece4cond" value="1" onclick="dispp4(this.value)"<?php if ($row->piece4cond==1) echo ' checked="checked"'; ?> /><label for="piece4cond1"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_LIBRARY'); ?></label>
                                                            <input type="radio" id="piece4cond2" name="piece4cond" value="2" onclick="dispp4(this.value)"<?php if ($row->piece4cond==2) echo ' checked="checked"'; ?> /><label for="piece4cond2"> <?php echo BFText::_('COM_BREEZINGFORMS_FORMS_CUSTOM'); ?></label>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p4lib" style="display:none;">
                                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PIECE'); ?></td>
                                                        <td valign="top">
                                                            <select name="piece4id" class="inputbox" size="1">
																<?php
																$pieces = $lists['piece4'];
																for ($i = 0; $i < count($pieces); $i++) {
																	$piece = $pieces[$i];
																	$selected = '';
																	if ($piece->id == $row->piece4id) $selected = ' selected';
																	echo '<option value="'.$piece->id.'"'.$selected.'>'.$piece->text.'</option>';
																} // for
																?>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="p4code" style="display:none;">
                                                        <td nowrap valign="top" colspan="2">
                                                            <a href="#" onClick="codeAreaResize('piece4code',<?php echo $ff_config->areasmall; ?>);">[<?php echo $ff_config->areasmall; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece4code',<?php echo $ff_config->areamedium; ?>);">[<?php echo $ff_config->areamedium; ?>]</a>
                                                            <a href="#" onClick="codeAreaResize('piece4code',<?php echo $ff_config->arealarge; ?>);">[<?php echo $ff_config->arealarge; ?>]</a>
                                                            <br/>
                                                            <textarea onFocus="codeAreaFocus(this);" readonly="readonly" wrap="off" name="piece4lines" style="display: none; width:60px;" rows="<?php echo $p4size; ?>" class="inputbox"></textarea>
                                                            <textarea onFocus="codeAreaFocus(this);" onKeyUp="codeAreaChange(this,event);" wrap="off" name="piece4code" style="width:100%;" rows="<?php echo $p4size; ?>" class="inputbox"><?php echo htmlspecialchars($row->piece4code, ENT_QUOTES); ?></textarea>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                            </fieldset>
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                            </fieldset>
							<?php
							$tabs->endTab();
							$tabs->startTab('MailChimp®','tab_mailchimp');
							?>

                            <fieldset><legend>MailChimp®</legend>
                                <table width="100%" cellpadding="4" cellspacing="1" border="0">

                                    <tr>
                                        <td valign="top" style="width: 200px;"><?php echo BFText::_('COM_BREEZINGFORMS_API_KEY'); ?></td>
                                        <td valign="top"><input type="text" name="mailchimp_api_key"  value="<?php echo $row->mailchimp_api_key; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_LIST_ID'); ?></td>
                                        <td valign="top"><input type="text" name="mailchimp_list_id"  value="<?php echo $row->mailchimp_list_id; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_EMAIL_FIELD'); ?></td>
                                        <td valign="top"><input type="text" name="mailchimp_email_field"  value="<?php echo $row->mailchimp_email_field; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_CHECKBOX_FIELD'); ?></td>
                                        <td valign="top"><input type="text" name="mailchimp_checkbox_field"  value="<?php echo $row->mailchimp_checkbox_field; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_UNSUBSCRIBE_FIELD'); ?></td>
                                        <td valign="top"><input type="text" name="mailchimp_unsubscribe_field"  value="<?php echo $row->mailchimp_unsubscribe_field; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_TEXT_HTML_MOBILE_FIELD'); ?></td>
                                        <td valign="top"><input type="text" name="mailchimp_text_html_mobile_field"  value="<?php echo $row->mailchimp_text_html_mobile_field; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_MERGE_VARS'); ?></td>
                                        <td valign="top"><input type="text" name="mailchimp_mergevars"  value="<?php echo $row->mailchimp_mergevars; ?>" style="width:90%;"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_DEFAULT_TYPE'); ?></td>
                                        <td valign="top">
                                            <select name="mailchimp_default_type" class="inputbox">
                                                <option value="text"<?php echo $row->mailchimp_default_type == 'text' ? ' selected="selected"' : '';?>>Text</option>
                                                <option value="html"<?php echo $row->mailchimp_default_type == 'html' ? ' selected="selected"' : '';?>>HTML</option>
                                                <option value="mobile"<?php echo $row->mailchimp_default_type == 'mobile' ? ' selected="selected"' : '';?>>Mobile</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_DOUBLE_OPTIN'); ?></td>
                                        <td valign="top"><input type="radio" name="mailchimp_double_optin" class="inputbox"<?php echo $row->mailchimp_double_optin ? ' checked="checked"' : '';?> value="1"/> <?php echo BFText::_('COM_BREEZINGFORMS_YES');?> <input type="radio" name="mailchimp_double_optin"  class="inputbox"<?php echo !$row->mailchimp_double_optin ? ' checked="checked"' : '';?> value="0"/><?php echo BFText::_('COM_BREEZINGFORMS_NO');?></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_UNSUBSCRIBE_DELETE_MEMBER'); ?></td>
                                        <td valign="top"><input type="radio" name="mailchimp_delete_member" class="inputbox"<?php echo $row->mailchimp_delete_member ? ' checked="checked"' : '';?> value="1"/> <?php echo BFText::_('COM_BREEZINGFORMS_YES');?> <input type="radio" name="mailchimp_delete_member"  class="inputbox"<?php echo !$row->mailchimp_delete_member ? ' checked="checked"' : '';?> value="0"/><?php echo BFText::_('COM_BREEZINGFORMS_NO');?></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_SEND_ERRORS'); ?></td>
                                        <td valign="top"><input type="radio" name="mailchimp_send_errors" class="inputbox"<?php echo $row->mailchimp_send_errors ? ' checked="checked"' : '';?> value="1"/> <?php echo BFText::_('COM_BREEZINGFORMS_YES');?> <input type="radio" name="mailchimp_send_errors"  class="inputbox"<?php echo !$row->mailchimp_send_errors ? ' checked="checked"' : '';?> value="0"/><?php echo BFText::_('COM_BREEZINGFORMS_NO');?></td>
                                    </tr>

                                </table>
                            </fieldset>
							<?php
							$tabs->endTab();
							$tabs->startTab('Salesforce®','tab_salesforce');
							?>
                            <fieldset><legend>Salesforce®</legend>
                                <table width="80%" cellpadding="4" cellspacing="1" border="0">

									<?php
									if($row->salesforce_error){
										?>
                                        <tr>
                                            <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_SF_ERROR'); ?></td>
                                            <td style="color: red;" valign="top"><?php echo $row->salesforce_error; ?></td>
                                        </tr>
										<?php
									}
									?>

                                    <tr>
                                        <td style="width: 200px;" valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_SF_ENABLED'); ?></td>
                                        <td valign="top">
                                            <input type="checkbox" onclick="document.getElementById('salesforce_flag').value=1;" name="salesforce_enabled"  value="1" size="50"  class="inputbox"<?php echo $row->salesforce_enabled == 1 ? ' checked="checked"' : ''; ?>/>
                                            <input type="hidden" name="salesforce_flag" id="salesforce_flag" value="0"/>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_SF_TOKEN'); ?></td>
                                        <td valign="top"><input type="text" name="salesforce_token"  value="<?php echo $row->salesforce_token; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_SF_USERNAME'); ?></td>
                                        <td valign="top"><input type="text" name="salesforce_username"  value="<?php echo $row->salesforce_username; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

                                    <tr>
                                        <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_SF_PASSWORD'); ?></td>
                                        <td valign="top"><input type="password" name="salesforce_password"  value="<?php echo $row->salesforce_password; ?>" size="50"  class="inputbox"/></td>
                                    </tr>

									<?php
									if( count($row->salesforce_types) != 0 ){
										?>
                                        <tr>
                                            <td valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_SF_TYPE'); ?></td>
                                            <td valign="top">
                                                <select name="salesforce_type">
													<?php
													foreach($row->salesforce_types As $stype){
														?>
                                                        <option value="<?php echo $stype->name;?>"<?php echo $stype->name == $row->salesforce_type ? ' selected="selected"' : '' ?>><?php echo $stype->label;?></option>
														<?php
													}
													?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top"><b><?php echo BFText::_('COM_BREEZINGFORMS_SF_FIELDS'); ?></b></td>
                                            <td valign="top"></td>
                                        </tr>
										<?php
										foreach($row->breezingforms_fields As $bfField){
											?>
                                            <tr>
                                                <td valign="top"><?php echo $bfField->title; ?> (<?php echo $bfField->name?>)</td>
                                                <td valign="top">
                                                    <select name="salesforce_fields[]">
                                                        <option value=""> - <?php echo BFText::_('COM_BREEZINGFORMS_SF_UNUSED'); ?> - </option>
														<?php
														foreach($row->salesforce_type_fields As $stypefields){
															?>
                                                            <option value="<?php echo $bfField->name?>::<?php echo $stypefields->name;?>"<?php echo in_array($bfField->name.'::'.$stypefields->name, $row->salesforce_fields) ? ' selected="selected"' : '' ?>><?php echo $stypefields->label;?></option>
															<?php
														}
														?>
                                                    </select>
                                                </td>
                                            </tr>
											<?php
										}
										?>
										<?php
									}
									?>

                                </table>
                            </fieldset>
							<?php
							$tabs->endTab();
							$tabs->startTab('Dropbox®','tab_dropbox');
							$failed = false;



							if (version_compare(phpversion(), '5.3.0', '>=')) {


								?>
                                <fieldset><legend>Dropbox®</legend>
                                    <table width="80%" cellpadding="4" cellspacing="1" border="0">
                                        <tr>
                                            <td style="width: 200px;" valign="top" colspan="2">
												<?php
												try{
													if(!$failed){

														if( $row->dropbox_password == '' && $row->dropbox_email == ''){
															$authorizeUrl = 'https://www.dropbox.com/oauth2/authorize?client_id=wfqreycemugothg&response_type=code';
															echo "<h3>Dropbox uses a secure way to connect with other apps like BreezingForms, please follow the steps below to connect this form with Dropbox</h3><br/>";
															echo "1. Open this Dropbox link: <a target=\"_blank\" href=\"" . $authorizeUrl . "\">Dropbox</a><br/><i>(you need to be logged into Dropbox)</i><br/><br/>\n";
															echo "2. Click \"Allow\".<br/><br/>\n";
															echo "3. Copy the authorization below into 'Authentication Code' and save.<br/><br/>\n";
															echo "4. After you finished the connection, your Dropbox instance is active and the Access Token field appears, displaying your personal token. You don't need to do anything further with it. If you need to reset the entire process, use the reset option, save and try again. Otherwise you are ready to use BreezingForms &amp; Dropbox.<br/><br/>\n";
														}else if($row->dropbox_password != '' && $row->dropbox_email == ''){

															require_once JPATH_SITE.'/administrator/components/com_breezingforms/libraries/dropbox/v2/autoload.php';
															$auth = new \Alorel\Dropbox\Operation\Users\GetAuthorizeToken(null, 'NoTokenOperation');
															$db_response = $auth->raw($row->dropbox_password);

															$accessToken = '';
															if(!isset($db_response->access_token)){
																echo '<i style="color:red;">An error occured, no access token available.</i>';
															}
															else{
																echo '<i style="color:red;">Now please save again to store your personal Access Token and you can start using BreezingForms &amp; Dropbox!</i>';
																$accessToken = $db_response->access_token;
															}
															$row->dropbox_password = '';
															$row->dropbox_email = $accessToken;
														}
													}
												}catch(Exception $e){
													echo 'Something went wrong with Dropbox. Please save the page once and try again.<br />';
													echo 'Message: '.$e->getMessage();
													$row->dropbox_password = '';
													$row->dropbox_email = '';
												}
												?>
                                            </td>
                                        </tr>

                                        <tr<?php echo $row->dropbox_email == '' ? ' style="display:none;"' : ''; ?>>
                                            <td style="width: 200px;" valign="top">Access Token</td>
                                            <td valign="top"><input type="text" name="dropbox_email"  value="<?php echo $row->dropbox_email; ?>" size="50"  class="inputbox"/>
                                            </td>
                                        </tr>

                                        <tr<?php echo $row->dropbox_email != '' ? ' style="display:none;"' : ''; ?>>
                                            <td valign="top">Authentication Code</td>
                                            <td valign="top"><input type="text" name="dropbox_password"  value="<?php echo $row->dropbox_password; ?>" size="50"  class="inputbox"/></td>
                                        </tr>
										<?php
										if( $row->dropbox_password != '' || $row->dropbox_email != ''){
											?>
                                            <tr>
                                                <td valign="top">Reset Authentication</td>
                                                <td valign="top"><input name="dropbox_reset_auth" value="1" type="checkbox"/> <label>check and save to restart the process</label></td>
                                            </tr>
											<?php
										}
										?>

                                        <tr>
                                            <td valign="top">Folder (leave empty for form name)</td>
                                            <td valign="top"><input type="text" name="dropbox_folder" value="<?php echo $row->dropbox_folder; ?>" size="50"  class="inputbox"/></td>
                                        </tr>

                                        <tr>
                                            <td valign="top">Upload Submission</td>
                                            <td valign="top"><input type="checkbox" name="dropbox_submission_enabled"  value="1" size="50"  class="inputbox"<?php echo $row->dropbox_submission_enabled == 1 ? ' checked="checked"' : ''; ?>/></td>
                                        </tr>

                                        <tr>
                                            <td valign="top">Submission Types</td>
                                            <td valign="top">
                                                <input type="checkbox" name="dropbox_submission_types[]"  value="pdf" size="50"  class="inputbox"<?php echo in_array('pdf', $row->dropbox_submission_types) ? ' checked="checked"' : ''; ?>/> <label>PDF</label>
                                                <input type="checkbox" name="dropbox_submission_types[]"  value="csv" size="50"  class="inputbox"<?php echo in_array('csv', $row->dropbox_submission_types) ? ' checked="checked"' : ''; ?>/> <label>CSV</label>
                                                <input type="checkbox" name="dropbox_submission_types[]"  value="xml" size="50"  class="inputbox"<?php echo in_array('xml', $row->dropbox_submission_types) ? ' checked="checked"' : ''; ?>/> <label>XML</label>
                                            </td>
                                        </tr>

                                    </table>
                                </fieldset>
								<?php

							}else{
								echo 'Your PHP Version does not support Dropbox. Please upgrade to at least PHP 5.3. You need to do it anyway, earlier versions are not secure any more!';
							}

							$tabs->endTab();

							/*
                            $tabs->startTab('Honeypot','tab_honeypot');
                            ?>
                            <fieldset><legend>Honeypot</legend>

                            <!-- coming soon ->

                            </fieldset>
                            <?php

                            $tabs->endTab();
							*/

							// calling addon plugins

							JPluginHelper::importPlugin('breezingforms_addons');
							$dispatcher = JDispatcher::getInstance();
							$addons = $dispatcher->trigger('onPropertiesDisplay', array(JRequest::getInt('form', 0), $tabs));
							foreach($addons As $addon){
								echo $addon;
							}

							$tabs->endPane();
							?>
                        </td>
                        <td></td>
                    </tr>
                </table>

                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="pkg" value="<?php echo $pkg; ?>" />
                <input type="hidden" name="option" value="<?php echo $option; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="act" value="manageforms" />
                <input type="hidden" name="pages" value="<?php echo $row->pages; ?>" />
                <input type="hidden" name="caller_url" value="<?php echo htmlspecialchars($caller, ENT_QUOTES); ?>" />
            </form>

            <div style="float: right;">
                <input class="btn btn-primary" onclick="submitbutton('save');" type="submit" value="<?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_SAVE'), ENT_QUOTES, 'UTF-8'); ?>"/>
                &nbsp;&nbsp;
                <input class="btn btn-primary" onclick="submitbutton('cancel');" type="submit" value="<?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_CANCEL'), ENT_QUOTES, 'UTF-8'); ?>"/>
            </div>
            <div style="clear:both;"></div>
        </fieldset>
		<?php
	} // edit

	static function listitems( $option, &$rows, &$pkglist, $total = 0 )
	{
		global $ff_config, $ff_version;
		?>
        <script type="text/javascript">
            <!--
            var bf_submitbutton = function(pressbutton)
            {
                var form = document.adminForm;
                switch (pressbutton) {
                    case 'copy':
                    case 'publish':
                    case 'unpublish':
                    case 'remove':
                        if (form.boxchecked.value==0) {
                            alert("<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SELFORMSFIRST'); ?>");
                            return;
                        } // if
                        break;
                    default:
                        break;
                } // switch
                if (pressbutton == 'remove')
                    if (!confirm("<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_ASKDEL'); ?>")) return;
                if (pressbutton == '' && form.pkgsel.value == '')
                    form.pkg.value = '- blank -';
                if (pressbutton == 'easymode')
                    form.act.value = 'easymode'
                if (pressbutton == 'quickmode')
                    form.act.value = 'quickmode'
                else
                    form.pkg.value = form.pkgsel.value;
                submitform(pressbutton);
            } // submitbutton

            if(typeof Joomla != 'undefined'){
                Joomla.submitbutton = bf_submitbutton;
            }

            submitbutton = bf_submitbutton;

            function listItemTask( id, task )
            {
                var f = document.adminForm;
                cb = eval( 'f.' + id );
                if (cb) {
                    for (i = 0; true; i++) {
                        cbx = eval('f.cb'+i);
                        if (!cbx) break;
                        cbx.checked = false;
                    } // for
                    cb.checked = true;
                    f.boxchecked.value = 1;
                    submitbutton(task);
                }
                return false;
            } // listItemTask
            //-->
        </script>
        <form action="index.php?format=html" method="post" name="adminForm" id="adminForm">
            <table cellpadding="4" cellspacing="1" border="0">
                <tr>
                    <td width="50%" nowrap>
                        <table class="adminheading">
                            <tr><th nowrap class="edit">BreezingForms <?php echo $ff_version; ?><br/><span class="componentheading"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_MANAGEFORMS'); ?></span></th></tr>
                        </table>
                    </td>
                    <td nowrap>
						<?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PACKAGE'); ?>:
                        <select id="pkgsel" name="pkgsel" class="inputbox" size="1" onchange="submitbutton('');">
							<?php
							if (count($pkglist)) foreach ($pkglist as $pkg) {
								$selected = '';
								if ($pkg[0]) $selected = ' selected';
								echo '<option value="'.$pkg[1].'"'.$selected.'>'.($pkg[1] == '' ? ' - '.BFText::_('COM_BREEZINGFORMS_SELECT') . ' - ' : $pkg[1]).'&nbsp;</option>';
							} // foreach
							?>
                        </select>
                    </td>
                    <td align="right" width="50%" nowrap>
						<?php
						if($ff_config->enable_classic == 1){
							JToolBarHelper::custom('quickmode',  'new.png',       'new_f2.png',     BFText::_('COM_BREEZINGFORMS_TOOLBAR_QUICKMODE'),  false);
							JToolBarHelper::custom('easymode',  'new.png',       'new_f2.png',     BFText::_('COM_BREEZINGFORMS_TOOLBAR_EASYMODE'),  false);
							JToolBarHelper::custom('new',       'new.png',       'new_f2.png',     BFText::_('COM_BREEZINGFORMS_TOOLBAR_CLASSICMODE'),       false);
						} else{
							JToolBarHelper::custom('quickmode',  'new.png',       'new_f2.png',     BFText::_('COM_BREEZINGFORMS_TOOLBAR_NEW'),  false);
						}
						JToolBarHelper::custom('copy',      'copy.png',      'copy_f2.png',    BFText::_('COM_BREEZINGFORMS_TOOLBAR_COPY'),      false);
						JToolBarHelper::custom('publish',   'publish.png',   'publish_f2.png', BFText::_('COM_BREEZINGFORMS_TOOLBAR_PUBLISH'),   false);
						JToolBarHelper::custom('unpublish', 'unpublish.png', 'unpublish_f2.png',BFText::_('COM_BREEZINGFORMS_TOOLBAR_UNPUBLISH'), false);
						JToolBarHelper::custom('remove',    'delete.png',    'delete_f2.png',  BFText::_('COM_BREEZINGFORMS_TOOLBAR_DELETE'),    false);
						?>
                    </td>
                </tr>
            </table>
            <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist table table-striped">
                <tr>
                    <th nowrap align="center"><input type="checkbox" name="toggle" value="" onclick="<?php $version = new JVersion(); echo version_compare($version->getShortVersion(), '3.0', '>=') ? 'Joomla.checkAll(this);' : 'checkAll('.count($rows).');'; ?>" /></th>
                    <th nowrap align="left"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_TITLE'); ?></th>
                    <th nowrap align="left"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_NAME'); ?></th>
                    <th nowrap align="left"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PAGES'); ?></th>
                    <th nowrap align="right"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_WIDTH'); ?></th>
                    <th nowrap align="right"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_HEIGHT'); ?></th>
                    <th nowrap align="right"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_SCRIPTID'); ?></th>
                    <th nowrap align="center"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_PUBLISHED'); ?></th>
                    <th nowrap align="center" colspan="2"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_REORDER'); ?></th>
                    <th align="left"><?php echo BFText::_('COM_BREEZINGFORMS_FORMS_DESCRIPTION'); ?></th>
                </tr>
				<?php
				$k = 0;
				for($i=0; $i < count( $rows ); $i++) {
					$row = $rows[$i];
					$desc = $row->description;
					if (strlen($desc) > $ff_config->limitdesc) $desc = substr($desc,0,$ff_config->limitdesc).'...';
					?>
                    <tr class="row<?php echo $k; ?>">
                        <td nowrap valign="top" align="center"><input type="checkbox" id="cb<?php echo $i; ?>" name="ids[]" value="<?php echo $row->id; ?>" onclick="<?php jimport('joomla.version'); $version = new JVersion(); echo version_compare($version->getShortVersion(), '3.0', '>=') ? 'Joomla.isChecked(this.checked);' : 'isChecked(this.checked);' ;?>" /></td>

						<?php
						if($row->template_code_processed != '' && $row->template_code_processed != 'QuickMode'){
							?>
                            <td valign="top" align="left"><a href="index.php?option=com_breezingforms&amp;format=html&amp;act=easymode&amp;formName=<?php echo $row->name?>&amp;form=<?php echo $row->id; ?>"><?php echo $row->title; ?></a></td>
                            <td valign="top" align="left"><a href="index.php?option=com_breezingforms&amp;format=html&amp;act=easymode&amp;formName=<?php echo $row->name?>&amp;form=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
						<?php } else if($row->template_code_processed == 'QuickMode') { ?>
                            <td valign="top" align="left"><a href="index.php?option=com_breezingforms&amp;format=html&amp;act=quickmode&amp;formName=<?php echo $row->name?>&amp;form=<?php echo $row->id; ?>"><?php echo $row->title; ?></a></td>
                            <td valign="top" align="left"><a href="index.php?option=com_breezingforms&amp;format=html&amp;act=quickmode&amp;formName=<?php echo $row->name?>&amp;form=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
						<?php } else { ?>
                            <td valign="top" align="left"><a href="#editpage1" onclick="return listItemTask('cb<?php echo $i; ?>','editpage1')"><?php echo $row->title; ?></a></td>
                            <td valign="top" align="left"><a href="#editform" onclick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $row->name; ?></a></td>
						<?php } ?>

                        <td nowrap valign="top" align="left"><?php
							for ($p = 1; $p <= $row->pages; $p++) {
								if ($p > 1) echo '&nbsp;';
								if($row->template_code_processed == '' && $row->template_code_processed != 'QuickMode'){
									?><a href="#editpage<?php echo $p; ?>" onclick="return listItemTask('cb<?php echo $i; ?>','editpage<?php echo $p; ?>')"><?php echo $p; ?></a><?php
								}else if($row->template_code_processed == 'QuickMode'){
									?><a href="index.php?option=com_breezingforms&amp;format=html&amp;act=quickmode&amp;formName=<?php echo $row->name?>&amp;form=<?php echo $row->id; ?>&amp;page=<?php echo $p; ?>"><?php echo $p; ?></a><?php
								} else {?>
                                    <a href="index.php?option=com_breezingforms&amp;format=html&amp;act=easymode&amp;formName=<?php echo $row->name?>&amp;form=<?php echo $row->id; ?>&amp;page=<?php echo $p; ?>"><?php echo $p; ?></a>
									<?php
								}
							} // for
							?></td>
                        <td nowrap valign="top" align="right"><?php echo $row->width; if ($row->widthmode) echo '%'; else echo 'px'; ?></td>
                        <td nowrap valign="top" align="right"><?php
							$text = '';
							switch ($row->heightmode) {
								case 1:
									$text =BFText::_('COM_BREEZINGFORMS_FORMS_AUTO');
									if ($row->height > 0) $text .= '+'.$row->height.'px';
									break;
								case 2:
									$text =BFText::_('COM_BREEZINGFORMS_FORMS_AUTOMAX');
									if ($row->height > 0) $text .= '+'.$row->height.'px';
									break;
								default:
									$text = $row->height.'px';
							} // switch
							echo $text; ?></td>
                        <td nowrap valign="top" align="right"><?php echo $row->id; ?></td>
                        <td nowrap valign="top" align="center"><?php
							if ($row->published == "1") {
								?><a href="#" onClick="return listItemTask('cb<?php echo $i; ?>','unpublish')"><img src="components/com_breezingforms/images/icons/publish_g.png" alt="+" border="0" /></a><?php
							} else {
								?><a href="#" onClick="return listItemTask('cb<?php echo $i; ?>','publish')"><img src="components/com_breezingforms/images/icons/publish_x.png" alt="-" border="0" /></a><?php
							} // if
							?></td>
                        <td nowrap valign="top" align="right"><?php
							if ($i > 0) {
								?><a href="#" onClick="return listItemTask('cb<?php echo $i; ?>','orderup')"><img src="components/com_breezingforms/images/icons/uparrow.png" alt="^" border="0" /></a><?php
							} // if
							?></td>
                        <td nowrap valign="top" align="left"><?php
							if ($i < count($rows)-1) {
								?><a href="#" onClick="return listItemTask('cb<?php echo $i; ?>','orderdown')"><img src="components/com_breezingforms/images/icons/downarrow.png" alt="v" border="0" /></a><?php
							} // if
							?></td>
                        <td valign="top" align="left"><?php echo htmlspecialchars($desc, ENT_QUOTES); ?></td>
                    </tr>
					<?php
					$k = 1 - $k;
				} // for

				$limit = JFactory::getApplication()->getUserStateFromRequest('global.list.limit', 'limit', JFactory::getApplication()->getCfg('list_limit'), 'int');
				$pagination = facileFormsForm::getPagination($total, $limit, JRequest::getInt('limitstart',0));
				$pages_links = $pagination->getPagesLinks();
				?>

                <tfoot>
                <tr>
                    <td colspan="1000" valign="middle" align="center">
                        <div class="pagination pagination-toolbar">
							<?php echo $pages_links; ?>
                            <br />
							<?php
							echo $pagination->getLimitBox();
							?>
                            <br />
							<?php echo $pagination->getPagesCounter(); ?>
                            <br />
							<?php echo BFText::_('COM_BREEZINGFORMS_AMOUNT');?>: <?php echo $total;?>
                        </div>
                    </td>
                </tr>
                </tfoot>

            </table>

            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="option" value="<?php echo $option; ?>" />
            <input type="hidden" name="act" value="manageforms" />
            <input type="hidden" name="limitstart" value="<?php echo JRequest::getInt('limitstart',0); ?>" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="form" value="" />
            <input type="hidden" name="page" value="" />
            <input type="hidden" name="pkg" value="" />
        </form>
		<?php
	} // listitems

} // class HTML_facileFormsForm

?>