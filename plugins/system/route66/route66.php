<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class plgSystemRoute66 extends JPlugin
{
	private $canonical;

	public function onAfterInitialise()
	{
		$application = JFactory::getApplication();

		if ($application->get('sef'))
		{

			// Component params in use
			$componentParams = JComponentHelper::getParams('com_route66');
			$this->params->merge($componentParams);

			// Initialize our router
			include_once JPATH_SITE . '/plugins/system/route66/lib/router.php';
			$Route66 = new Route66SefRouter();
		}
	}

	public function onAfterDispatch()
	{
		$application = JFactory::getApplication();

		if ($application->isSite() && $application->get('sef'))
		{

			// Get document
			$document = JFactory::getDocument();

			// Get option
			$option = $application->input->getCmd('option');

			// Duplicate URLs handling
			if ($application->input->getMethod() == 'GET' && ($this->params->get('canonical', 1) || $this->params->get('redirect', 1)) && $document->getType() == 'html' && !in_array($option, $this->params->get('exclusions', array())))
			{

				// Get router
				$router = $application->getRouter();

				// Get URI
				$uri = JUri::getInstance();

				// Merge all the available vars
				$vars = array_merge($router->getVars(), $uri->getQuery(true));
				$vars = array_filter($vars);

				// Canonical URI
				$url = $uri->getScheme() . '://' . $uri->getHost();
				$port = $uri->getPort();

				if ($port)
				{
					$url .= ':' . $port;
				}

				// K2 needs to fix it's router
				if (isset($vars['option']) && $vars['option'] == 'com_k2' && isset($vars['view']) && $vars['view'] == 'itemlist')
				{
					if (!isset($vars['task']) || $vars['task'] == '')
					{
						unset($vars['view']);
					}
				}

				$url .= JRoute::_('index.php?' . http_build_query($vars), false);
				$canonical = JUri::getInstance($url);
				$query = $canonical->getQuery(true);
				$array = array('scheme', 'host', 'port', 'path');
				$canonical = $canonical->toString($array);

				// Current URI
				$current = $uri->toString(array('scheme', 'host', 'port', 'path'));

				// Check for jAMP
				$isAmp = false;

				if (JPluginHelper::isEnabled('system', 'jamp'))
				{
					$plugin = JPluginHelper::getPlugin('system', 'jamp');
					$pluginParams = json_decode($plugin->params);

					if (isset($pluginParams->amp_suffix) && $pluginParams->amp_suffix)
					{
						$suffix = $pluginParams->amp_suffix;
						$length = strlen($suffix);
						$isAmp = substr($current, -($length + 1)) == '/' . $suffix || substr($current, -($length + 6)) == '.' . $suffix . '.html';
					}
				}

				// Canonical and current URI should match. If not redirect
				if (!$isAmp && $this->params->get('redirect', 1) && $current != JUri::root() && urldecode($current) != urldecode($canonical))
				{

					// Redirect
					$redirect = $canonical;

					if (count($query))
					{
						$redirect .= '?' . http_build_query($query);
					}
					$application->redirect($redirect, 301);
				}

				// Add a canonical link
				if (!isset($query['start']))
				{
					$this->canonical = $canonical;
				}
			}
		}
	}

	public function onBeforeCompileHead()
	{
		$application = JFactory::getApplication();
		$document = JFactory::getDocument();

		if ($application->isSite() && $document->getType() == 'html')
		{
			if ($this->params->get('canonical', 1) && $this->canonical)
			{
				$document->addHeadLink(htmlspecialchars($this->canonical), 'canonical');
			}

			if ($this->params->get('facebookPageId'))
			{
				$document->addCustomTag('<meta property="fb:pages" content="' . $this->params->get('facebookPageId') . '" />');
			}
			$this->setMetadata();
		}
	}

	protected function setMetadata()
	{
		$document = JFactory::getDocument();
		$application = JFactory::getApplication();
		$option = $application->input->getCmd('option');
		$view = $application->input->getCmd('view');
		$id = $application->input->getInt('id');

		if ($application->isSite() && $option == 'com_content' && $view == 'article' && $document->getType() == 'html')
		{
			JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_route66/models');
			$model = JModelLegacy::getInstance('Metadata', 'Route66Model');
			$result = $model->fetch('com_content.article', $id);

			if ($result)
			{
				$metadata = new Registry($result->metadata);
			}
			else
			{
				$metadata = new Registry();
			}

			$document = JFactory::getDocument();

			if ($metadata->get('og_type', 'article'))
			{
				$document->setMetadata('og:type', $metadata->get('og_type', 'article'), 'property');
				$document->setMetadata('og:url', JUri::current(), 'property');
				$document->setMetadata('og:title', $metadata->get('og_title', $document->getTitle()), 'property');
				$document->setMetadata('og:description', $metadata->get('og_description', $document->getDescription()), 'property');

				$ogImageType = $metadata->get('og_image', 'full_image');

				if ($ogImageType == 'intro_image' || $ogImageType == 'full_image')
				{
					$db = JFactory::getDbo();
					$query = $db->getQuery(true);
					$query->select($db->qn('images'));
					$query->from($db->qn('#__content'));
					$query->where($db->qn('id') . ' = ' . $id);
					$db->setQuery($query);
					$images = json_decode($db->loadResult());

					if ($ogImageType == 'intro_image' && $images && isset($images->image_intro) && $images->image_intro)
					{
						$document->setMetadata('og:image', JUri::root(false) . $images->image_intro, 'property');
					}
					elseif ($ogImageType == 'full_image' && $images && isset($images->image_fulltext) && $images->image_fulltext)
					{
						$document->setMetadata('og:image', JUri::root(false) . $images->image_fulltext, 'property');
					}
				}
				elseif ($ogImageType == 'media' && $metadata->get('og_image_media'))
				{
					$document->setMetadata('og:image', JUri::root(false) . $metadata->get('og_image_media'), 'property');
				}
				elseif ($ogImageType == 'url' && $metadata->get('og_image_url'))
				{
					$document->setMetadata('og:image', $metadata->get('og_image_url'), 'property');
				}
			}
		}
	}
}
