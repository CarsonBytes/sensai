<?php
/*------------------------------------------------------------------------
# mod_j2store_categories
# ------------------------------------------------------------------------
# author    Gokila priya - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php error_reporting(0); if ($module->showtitle != 0) : ?>
        <div class="section-title">
          <h2><span><?php echo $module->title; ?></span></h2>
          
        </div>
      <?php endif; ?>
<ul class="j2store-categories-module<?php echo $moduleclass_sfx; ?>">
<?php require JModuleHelper::getLayoutPath('mod_j2store_categories', $params->get('layout', 'default') . '_items'); ?>
</ul>

