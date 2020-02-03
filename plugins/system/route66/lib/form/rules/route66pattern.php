<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class JFormRuleRoute66Pattern extends JFormRule
{
	private $tokens;
	private $identifiers;

	public function test(SimpleXMLElement $element, $value, $group = null, JRegistry $input = null, JForm $form = null)
	{
		$language = JFactory::getLanguage();
		$language->load('plg_system_route66.sys', JPATH_SITE . '/plugins/system/route66');

		$this->identifiers = explode(',', $element->attributes()->identifiers);
		$this->tokens = array_merge($this->identifiers, explode(',', $element->attributes()->tokens));

		foreach ($value as $data)
		{
			if ($data)
			{
				$tokens = array();
				$matches = array();
				preg_match_all('/{(.*?)}/', $data, $matches, PREG_SET_ORDER);

				if (is_array($matches) && count($matches))
				{
					foreach ($matches as $match)
					{
						if (!in_array($match[1], $this->tokens))
						{
							return new UnexpectedValueException(JText::sprintf('PLG_SYSTEM_ROUTE66_INVALID_TOKEN_USED', $match[1], JText::_($element->attributes()->label)));
						}
						$tokens[] = $match[1];
					}
					$tokens = array_unique($tokens);
					$intersection = array_intersect($tokens, $this->identifiers);

					if (count($intersection) == 0)
					{
						return new UnexpectedValueException(JText::sprintf('PLG_SYSTEM_ROUTE66_NO_IDENTIFIER_PROVIDED', JText::_($element->attributes()->label)));
					}
				}
				else
				{
					return new UnexpectedValueException(JText::sprintf('PLG_SYSTEM_ROUTE66_INVALID_PATTERN', JText::_($element->attributes()->label)));
				}
			}
		}

		return true;
	}
}
