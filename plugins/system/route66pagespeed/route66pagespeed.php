<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/plugins/system/route66pagespeed/lib/css.php';
require_once JPATH_SITE . '/plugins/system/route66pagespeed/lib/minifier.php';

class plgSystemRoute66PageSpeed extends JPlugin
{
	protected $doc;
	protected $cache;
	protected $optimizeJs = false;
	protected $optimizeCss = false;
	protected $optimizeImages = false;

	public function onAfterDispatch()
	{
		$application = JFactory::getApplication();
		$document = JFactory::getDocument();
		$user = JFactory::getUser();
		$componentParams = JComponentHelper::getParams('com_route66');

		if ($application->isAdmin() || $application->input->getMethod() != 'GET')
		{
			return;
		}

		if ($document->getType() != 'html')
		{
			return;
		}

		if (!$user->guest)
		{
			return;
		}

		if (in_array($application->input->getCmd('option'), $componentParams->get('optimizeExclusions', array())))
		{
			return;
		}

		$this->params->merge($componentParams);
		$this->optimizeJs = $this->params->get('optimizeJs');
		$this->optimizeCss = $this->params->get('optimizeCss');
		$this->optimizeImages = $this->params->get('lazyloadImages');
		$this->optimizeIframes = $this->params->get('lazyloadIframes');
		$this->cache = JFactory::getCache('plg_system_route66_pagespeed', 'output');
		$this->cache->setCaching(true);
		$this->cache->setLifeTime($this->params->get('optimizeCacheTime', 15));

		if ($this->optimizeImages)
		{
			$document->addScript(JUri::root(true) . '/media/route66/js/lazysizes.min.js');
		}
	}

	public function onAfterRender()
	{
		if ($this->optimizeJs || $this->optimizeCss || $this->optimizeImages)
		{
			$application = JFactory::getApplication();
			$buffer = '<?xml encoding="UTF-8">' . $application->getBody();

			libxml_use_internal_errors(true);
			$this->doc = new DOMDocument('1.0', 'UTF-8');
			$this->doc->preserveWhiteSpace = false;
			$this->doc->formatOutput = false;
			$this->doc->loadHTML($buffer);

			if ($this->optimizeImages)
			{
				$this->prepareImages();
			}

			if ($this->optimizeIframes)
			{
				$this->prepareIframes();
			}

			if ($this->optimizeJs)
			{
				$this->prepareJs();
			}

			if ($this->optimizeCss)
			{
				$this->prepareCss();
			}

			$buffer = $this->doc->saveHTML();
			$buffer = str_replace('<?xml encoding="UTF-8">', '', $buffer);

			$application->setBody($this->doc->saveHTML());
		}
	}

	protected function prepareJs()
	{
		$scripts = $this->doc->getElementsByTagName('script');
		$parts = array();

		for ($i = $scripts->length; --$i >= 0;)
		{
			$script = $scripts->item($i);

			if (!$script->getAttribute('src'))
			{
				$type = $script->getAttribute('type');

				if ($type == 'text/javascript' || $type == '')
				{
					$parts[] = $script->nodeValue;
					$script->parentNode->removeChild($script);
				}
			}
			elseif (!$script->getAttribute('defer'))
			{
				$script->setAttribute('defer', 'defer');
			}
		}
		$js = implode('', array_reverse($parts));

		if ($js)
		{
			if ($this->params->get('optimizeJsMethod') == 'file')
			{
				$key = md5($js);
				$timestamp = $this->cache->get($key . '_script_timestamp');

				if (!$timestamp)
				{
					$date = JFactory::getDate();
					$timestamp = $date->toUnix();
					$this->cache->store($timestamp, $key . '_script_timestamp');
					jimport('joomla.filesystem.file');
					JFile::write(JPATH_SITE . '/media/route66/scripts/' . $key . '.js', $js);
				}
				$head = $this->doc->getElementsByTagName('head')->item(0);
				$script = $this->doc->createElement('script', ' ');
				$script->setAttribute('defer', 'defer');
				$script->setAttribute('src', JUri::root(true) . '/media/route66/scripts/' . $key . '.js?v=' . $timestamp);
				$head->appendChild($script);
			}
			else
			{
				$body = $this->doc->getElementsByTagName('body')->item(0);
				$script = $this->doc->createElement('script', 'document.addEventListener("DOMContentLoaded", function(event) {' . $js . '});');
				$body->appendChild($script);
			}
		}
	}

	protected function prepareCss()
	{
		$xpath = new DOMXpath($this->doc);
		$styles = $xpath->query('//link[@rel="stylesheet"] | //style');

		$processor = new Route66Css();
		$processed = array();

		foreach ($styles as $key => $style)
		{
			if ($style->tagName == 'style')
			{
				$result = $processor->addStyle($style->nodeValue);
			}
			else
			{
				$result = $processor->addLink($style->getAttribute('href'));
			}

			if ($result)
			{
				$processed[] = $key;
			}
		}

		for ($i = $styles->length; --$i >= 0;)
		{
			$style = $styles->item($i);

			if (in_array($i, $processed))
			{
				$style->parentNode->removeChild($style);
			}
		}

		$css = $processor->combine();

		if ($css)
		{
			if ($this->params->get('minifyCss'))
			{
				$minifier = new Route66CssMinifier();
				$css = $minifier->process($css);
			}

			$head = $this->doc->getElementsByTagName('head')->item(0);
			$style = $this->doc->createElement('style', $css);
			$head->appendChild($style);
		}
	}

	protected function prepareImages()
	{
		$componentParams = JComponentHelper::getParams('com_route66');
		$placeholder = $componentParams->get('lazyloadImagePlaceholder');

		if ($placeholder)
		{
			$placeholder = JUri::root(true) . '/' . $placeholder;
		}
		else
		{
			$placeholder = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
		}

		$restrictionMode = $componentParams->get('lazyloadImagesRestrictionsMode');
		$classname = $componentParams->get('lazyloadImagesClass');

		$images = $this->doc->getElementsByTagName('img');

		for ($i = $images->length; --$i >= 0;)
		{
			$image = $images->item($i);

			$class = $image->getAttribute('class');

			if ($restrictionMode && $classname)
			{
				$classes = explode(' ', $class);
				$classes = array_filter($classes);

				if ($restrictionMode == 'inclusive' && !in_array($classname, $classes))
				{
					continue;
				}
				elseif ($restrictionMode == 'exclusive' && in_array($classname, $classes))
				{
					continue;
				}
			}

			$class .= ' lazyload';
			$image->setAttribute('class', $class);

			$src = $image->getAttribute('src');

			if ($src)
			{
				$image->setAttribute('data-src', $src);
				$image->setAttribute('src', $placeholder);
			}

			$srcset = $image->getAttribute('srcset');

			if ($srcset)
			{
				$image->setAttribute('data-srcset', $srcset);
				$image->removeAttribute('srcset');
			}

			$sizes = $image->getAttribute('sizes');

			if ($sizes)
			{
				$image->setAttribute('data-sizes', 'auto');
				$image->removeAttribute('sizes');
			}
		}
	}

	protected function prepareIframes()
	{
		$componentParams = JComponentHelper::getParams('com_route66');
		$restrictionMode = $componentParams->get('lazyloadIframesRestrictionsMode');
		$classname = $componentParams->get('lazyloadIframesClass');
		$iframes = $this->doc->getElementsByTagName('iframe');

		for ($i = $iframes->length; --$i >= 0;)
		{
			$iframe = $iframes->item($i);

			$class = $iframe->getAttribute('class');

			if ($restrictionMode && $classname)
			{
				$classes = explode(' ', $class);
				$classes = array_filter($classes);

				if ($restrictionMode == 'inclusive' && !in_array($classname, $classes))
				{
					continue;
				}
				elseif ($restrictionMode == 'exclusive' && in_array($classname, $classes))
				{
					continue;
				}
			}

			$class .= ' lazyload';
			$iframe->setAttribute('class', $class);

			$src = $iframe->getAttribute('src');

			if ($src)
			{
				$iframe->setAttribute('data-src', $src);
				$iframe->removeAttribute('src');
			}
		}
	}
}
