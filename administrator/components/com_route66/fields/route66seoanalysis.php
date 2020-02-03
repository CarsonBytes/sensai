<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class JFormFieldRoute66SeoAnalysis extends JFormField
{
	public $type = 'Route66SeoAnalysis';

	public function getInput()
	{
		$html = '<div id="route66-seo-analysis"></div>';

		return $html;
	}
}
