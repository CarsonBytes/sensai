<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('hidden');

class JFormFieldRoute66SeoScore extends JFormFieldHidden
{
	public $type = 'Route66SeoScore';

	public function getInput()
	{
		$html = '<div id="route66-seo-score">';
		$html .= '<span id="route66-seo-score-text"></span>';
		$html .= '</div>';
		$html .= parent::getInput();

		return $html;
	}
}
