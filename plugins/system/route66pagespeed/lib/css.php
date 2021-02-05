<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

class Route66Css
{
	protected $rootAbsolute;
	protected $rootRelative;
	protected $parts = array();

	public function __construct()
	{
		$this->rootAbsolute = JUri::root(false);
		$this->rootRelative = JUri::root(true);
	}

	public function addLink($href)
	{
		if (!$href)
		{
			return false;
		}

		if ($this->isExternal($href))
		{
			return false;
		}

		if ($this->isScript($href))
		{
			return false;
		}

		$filepath = $this->getFilePath($href);

		if (!$filepath)
		{
			return false;
		}

		$buffer = file_get_contents(JPATH_SITE . '/' . $filepath);

		$this->addStyle($buffer, $href);

		return true;
	}

	public function addStyle($buffer, $path = '')
	{
		$basepath = $path ?  '/' . dirname($this->getFilePath($path)) : '/';

		$imports = $this->findImports($buffer);

		if (count($imports))
		{
			foreach ($imports as $import)
			{
				if ($this->isExternal($import['path']))
				{
					continue;
				}

				$href = $this->relativeToAbsolute($import['path'], $basepath);

				if ($this->addLink($href))
				{
					$buffer = str_replace($import[0], '', $buffer);
				}
			}
		}

		$urls = $this->findUrls($buffer);

		if (count($urls))
		{
			foreach ($urls as $url)
			{
				if ($this->isExternal($url))
				{
					continue;
				}
				$replace = $this->relativeToAbsolute($url, $basepath);

				if ($replace)
				{
					$buffer = str_replace($url, $replace, $buffer);
				}
			}
		}
		$this->parts[] = $buffer;

		return true;
	}

	public function combine()
	{
		return implode('', $this->parts);
	}

	protected function findImports($buffer)
	{
		$expressions = array('/@import\s+url\((?P<quotes>["\']?)(?P<path>.+?)(?P=quotes)\)\s*(?P<media>[^;]*)\s*;?/ix', '/@import\s+(?P<quotes>["\'])(?P<path>.+?)(?P=quotes)\s*(?P<media>[^;]*)\s*;?/ix');
		$matches = array();

		foreach ($expressions as $expression)
		{
			if (preg_match_all($expression, $buffer, $newMatches, PREG_SET_ORDER))
			{
				$matches = array_merge($matches, $newMatches);
			}
		}

		return $matches;
	}

	protected function findUrls($buffer)
	{
		preg_match_all('/url\((.*?)\)/i', $buffer, $matches);

		return $matches[1];
	}

	protected function relativeToAbsolute($url, $basepath)
	{
		$parts = explode('/', $basepath);
		$url = trim($url, '\'"');

		if (strpos($url, 'data:') === 0 || strpos($url, 'http') === 0)
		{
			return;
		}

		$count = substr_count($url, '../');

		if ($count)
		{
			$url = str_replace(str_repeat('../', $count), implode('/', array_slice($parts, 0, -$count)) . '/', $url);
			$url = ltrim($url, '/');
		}
		elseif (strpos($url, './') === 0)
		{
			$url = str_replace('./', $basepath . '/', $url);
		}
		elseif (strpos($url, '/') === 0)
		{
			$url = $url;
		}
		else
		{
			$url = ltrim($url, '/');
			$url = $basepath . '/' . $url;
		}

		$url = ltrim($url, '/');

		return  '/' . $url;
	}

	protected function isExternal($href)
	{
		if (strpos($href, '//') === 0)
		{
			return true;
		}

		if (strpos($href, 'http') === 0 && strpos($href, $this->rootAbsolute) !== 0)
		{
			return true;
		}

		return false;
	}

	protected function isScript($href)
	{
		$path = parse_url($href, PHP_URL_PATH);
		$parts = pathinfo($path);
		$extension = strtolower($parts['extension']);

		return $extension == 'php';
	}

	protected function getFilePath($href)
	{
		if (strpos($href, $this->rootAbsolute) === 0)
		{
			$href = str_replace($this->rootAbsolute, '', $href);
		}
		elseif ($this->rootRelative && strpos($href, $this->rootRelative) === 0)
		{
			$href = str_replace($this->rootRelative . '/', '', $href);
		}

		$filepath = parse_url($href, PHP_URL_PATH);
		$filepath = ltrim($filepath, '/');

		return $filepath;
	}
}
