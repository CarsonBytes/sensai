<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66Controller extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = false)
	{
		$safeurlparams = array('id' => 'UINT', 'limitstart' => 'UINT', 'extension' => 'CMD');
		parent::display($cachable, $safeurlparams);

		return $this;
	}
}
