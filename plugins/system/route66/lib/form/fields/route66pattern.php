<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('text');

class JFormFieldRoute66Pattern extends JFormFieldText
{
	protected $type = 'Route66Pattern';

	protected function getInput()
	{
		// Keep original name and value
		$name = $this->name;
		$value = $this->value;

		// Initialize buffer
		$buffer = '';

		// First set the any language field
		$this->name = $name . '[*]';
		$this->value = isset($value['*']) ? $value['*'] : '';

		// Make the field hidden if required
		if (JLanguageMultilang::isEnabled())
		{
			$buffer .= $this->hide(parent::getInput());
		}
		else
		{
			$buffer .= parent::getInput();
		}

		// Set the languages fields
		$siteLanguages = JLanguageMultilang::getSiteLangs();
		$languages = JLanguageHelper::getLanguages();

		// Get the input for each language
		foreach ($languages as $language)
		{

			// Process only site languages
			if (array_key_exists($language->lang_code, $siteLanguages))
			{

				// Set the field value and name
				$this->name = $name . '[' . $language->lang_code . ']';
				$this->value = isset($value[$language->lang_code]) ? $value[$language->lang_code] : '';

				// Make the field hidden if required
				if (JLanguageMultilang::isEnabled())
				{
					$flag = JHtml::_('image', 'mod_languages/' . $language->image . '.gif', $language->title, array('title' => $language->title), true);
					$buffer .= '<div style="margin-bottom:10px;"><div class="input-prepend"><span class="add-on">' . $flag . '</span>' . parent::getInput() . '</div></div>';
				}
				else
				{
					$buffer .= $this->hide(parent::getInput());
				}
			}
		}

		// Get identifiers
		$identifiers = explode(',', $this->element['identifiers']);

		// Add markup
		foreach ($identifiers as $key => $identifier)
		{
			$identifiers[$key] = '<strong>' . $identifier . '</strong>';
		}

		// Build legend markup
		$tokens = array_merge($identifiers, explode(',', $this->element['tokens']));
		$tokens = array_filter($tokens);
		$buffer .= '<div class="muted"><em>' . implode(', ', $tokens) . '</em></div>';

		// Return
		return $buffer;
	}

	private function hide($input)
	{
		return str_replace('type="text"', 'type="hidden"', $input);
	}
}
