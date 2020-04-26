<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/plugins/system/route66/lib/plugin.php';

class plgRoute66Tags extends Route66Plugin
{
	protected $rules = array('tag');
}
