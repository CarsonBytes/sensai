<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

abstract class Route66Rule
{
	protected $variables;
	protected $pattern;
	protected $tokens = array();
	private $regex = '';
	private $length = 0;
	private $language = '*';
	private $prefix = '';

	public function __construct($pattern, $prefix, $language)
	{
		$this->language = $language;
		$this->prefix = $prefix;
		$this->pattern = $this->prefix ? $this->prefix . '/' . $pattern : $pattern;
		$this->regex = '/' . addcslashes(preg_replace('/{(.*?)}/', '(.*?)', $this->pattern), '/') . '$/';
		preg_match_all('/{(.*?)}/', $this->pattern, $matches, PREG_SET_ORDER);

		if (is_array($matches) && count($matches))
		{
			foreach ($matches as $match)
			{
				$this->tokens[] = '{' . $match[1] . '}';
			}
		}
		$this->length = substr_count($this->pattern, '/');
	}

	abstract public function getTokensValues($query);

	abstract public function getQueryValue($key, $tokens);

	abstract public function getItemid($variables);

	public function getVariables()
	{
		return $this->variables;
	}

	public function getRouteKeys()
	{
		$filtered = array_filter($this->variables, array($this, 'keysFilter'));

		return array_keys($filtered);
	}

	protected function keysFilter($var)
	{
		return $var;
	}

	public function getRouteValues()
	{
		return array_filter($this->variables, array($this, 'valuesFilter'));
	}

	protected function valuesFilter($var)
	{
		return $var && $var != '@';
	}

	public function getOption()
	{
		return $this->variables['option'];
	}

	public function getPattern()
	{
		return $this->pattern;
	}

	public function getTokens()
	{
		return $this->tokens;
	}

	public function getRegex()
	{
		return $this->regex;
	}

	public function getLength()
	{
		return $this->length;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function getPrefix()
	{
		return $this->prefix;
	}
}
