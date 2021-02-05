<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

use Joomla\CMS\Filesystem\File;

class Route66Plugin extends JPlugin
{
	protected $rules = array();

	public function onRoute66AddRules()
	{
		$application = JFactory::getApplication();
		$languages = JLanguageHelper::getLanguages('lang_code');
		$languageFilter = $application->isClient('site') && $application->getLanguageFilter();

		if ($languageFilter)
		{
			$default = JComponentHelper::getParams('com_languages')->get('site', 'en-GB');
			$plugin = JPluginHelper::getPlugin('system', 'languagefilter');
			$params = new JRegistry($plugin->params);
			$removeDefaultPrefix = $params->get('remove_default_prefix');

			foreach ($languages as $language)
			{
				$language->prefix = $language->sef;

				if ($removeDefaultPrefix && $language->lang_code == $default)
				{
					$language->prefix = '';
				}
			}
		}

		$array = array();

		foreach ($this->rules as $ruleName)
		{
			$patterns = $this->params->get($ruleName);

			if (!is_object($patterns))
			{
				continue;
			}

			foreach ($patterns as $key => $pattern)
			{
				if ($languageFilter && $key == '*')
				{
					continue;
				}

				if (!$languageFilter && $key != '*')
				{
					continue;
				}

				$pattern = trim($pattern);

				if (!$pattern)
				{
					continue;
				}

				$prefix = '';

				if ($key != '*' && isset($languages[$key]))
				{
					$prefix = $languages[$key]->prefix;
				}

				include_once JPATH_SITE . '/plugins/route66/' . $this->_name . '/rules/' . $ruleName . '.php';
				$className = 'Route66Rule' . ucfirst($this->_name) . ucfirst($ruleName);
				$rule = new $className($pattern, $prefix, $key);
				$array[] = $rule;
			}
		}

		return $array;
	}

	public function onRoute66IsExtensionInstalled()
	{
		return true;
	}

	public function onRoute66LoadExtensionForm(&$form, $formType)
	{
		$formFile = JPATH_SITE . '/plugins/route66/' . $this->_name . '/forms/' . $formType . '.xml';

		if ($this->onRoute66IsExtensionInstalled() && File::exists($formFile))
		{
			$form->loadFile($formFile);
		}
	}

	public function onRoute66GetSitemapItems($feed, $extension, $offset, $limit)
	{
		$items = array();
		$name = $this->_name;

		if ($feed->sources->get($name) && $extension == $name && $this->onRoute66IsExtensionInstalled())
		{
			$items = $this->getSitemapItems($feed, $offset, $limit);
		}

		return $items;
	}

	public function getSitemapItems($feed, $offset, $limit)
	{
		return array();
	}

	public function onRoute66CountSitemapItems($feed)
	{
		$count = 0;
		$name = $this->_name;

		if ($feed->sources->get($name) && $this->onRoute66IsExtensionInstalled())
		{
			$count = $this->countSitemapItems($feed);
		}

		return array('extension' => $name, 'count' => $count);
	}

	public function countSitemapItems($feed)
	{
		return 0;
	}

	protected function getModel()
	{
		$name = ucfirst($this->_name);
		JLoader::register('Route66Model'.$name, JPATH_SITE . '/plugins/route66/' . $this->_name . '/models/'.$this->_name.'.php');
		return JModelLegacy::getInstance($name, 'Route66Model', array('ignore_request' => true));
	}

	public function onRoute66GetInstantArticles($feed)
	{
		$items = array();
		$name = $this->_name;

		if ($feed->sources->get($name) && $this->onRoute66IsExtensionInstalled())
		{
			$items = $this->getInstantArticles($feed);
		}

		return $items;
	}

	public function getInstantArticles($feed)
	{
		return array();
	}

	protected function getFirstImage(&$text)
	{
		$result = null;
		$doc = new DOMDocument();
		$doc->loadHTML('<?xml encoding="utf-8"?>' . $text);
		$images = $doc->getElementsByTagName('img');

		if ($images->length > 0)
		{
			$image = $images->item(0);
			$src = $image->getAttribute('src');

			if (strpos($src, 'http') !== 0)
			{
				$src = JUri::root(false) . '/' . $src;
			}
			$result = new stdClass();
			$result->src = $src;
			$result->description = $image->getAttribute('alt');
			$image->parentNode->removeChild($image);
			$text = $doc->saveHTML();
		}

		return $result;
	}

	protected function prepareTextForInstantArticles($text)
	{
		// Use DOM
		$doc = new DOMDocument();
		$doc->loadHTML('<?xml encoding="utf-8"?>' . $text);

		// Handle images
		$images = $doc->getElementsByTagName('img');

		foreach ($images as $image)
		{

			// Fix relative image paths
			$src = $image->getAttribute('src');

			if (strpos($src, 'http') !== 0)
			{
				$image->setAttribute('src', JUri::root(false) . '/' . $src);
			}

			// Move images out of paragraphs. This is required by Instant Articles
			if ($image->parentNode->tagName == 'p')
			{
				$image->parentNode->parentNode->insertBefore($image, $image->parentNode);
			}
		}

		// Handle embeds
		$iframes = $doc->getElementsByTagName('iframe');

		foreach ($iframes as $iframe)
		{

			// Fix src with no protocol
			$src = $iframe->getAttribute('src');

			if (strpos($src, '//') === 0)
			{
				$iframe->setAttribute('src', 'https:' . $src);
			}

			// Fix src with relative paths
			$src = $iframe->getAttribute('src');

			if (strpos($src, 'http') !== 0)
			{
				$iframe->setAttribute('src', JUri::root(false) . '/' . $src);
			}

			// Move embeds out of paragraphs. This is required by Instant Articles
			if ($iframe->parentNode->tagName == 'p')
			{
				$iframe->parentNode->parentNode->insertBefore($iframe, $iframe->parentNode);
			}
		}

		// Remove empty paragraphs
		$paragraphs = $doc->getElementsByTagName('p');

		foreach ($paragraphs as $paragraph)
		{
			$nodeValue = trim(str_replace(array('&nbsp;', ' '), array('', ''), $paragraph->nodeValue));

			if (!$paragraph->hasChildNodes() && !$nodeValue)
			{
				$paragraph->parentNode->removeChild($paragraph);
			}
		}

		// Convert relative links to absolute
		$links = $doc->getElementsByTagName('a');

		foreach ($links as $link)
		{
			$href = $link->getAttribute('href');

			if (strpos($href, 'http') !== 0)
			{
				$link->setAttribute('href', JUri::root(false) . '/' . ltrim($href, '/'));
			}
		}

		$html = $doc->saveHTML($doc->getElementsByTagName('body')->item(0));
		$html = str_replace(array('<body>', '</body>', '<h3>', '</h3>', '<h4>', '</h4>'), array('', '', '<h2>', '</h2>', '<h2>', '</h2>'), $html);

		return $html;
	}
}
