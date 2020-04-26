<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

require_once JPATH_SITE . '/plugins/system/route66/lib/plugin.php';
require_once JPATH_SITE . '/components/com_content/helpers/route.php';

class plgRoute66Content extends Route66Plugin
{
	protected $rules = array('article', 'category');

	public function getSitemapItems($feed, $offset, $limit)
	{

		// Get model
		$model = $this->getModel();
		$model->setState('offset', $offset);
		$model->setState('limit', $limit);

		if ($feed->settings->get('type') == 'news')
		{
			$model->setState('offset', 0);
			$model->setState('limit', 0);
			$model->setState('filter.days', 2);
		}

		// Set category filter
		if ($feed->sources->get('content') == 2 && is_array($feed->sources->get('contentCategories')) && count($feed->sources->get('contentCategories')))
		{
			$model->setState('categories', $feed->sources->get('contentCategories'));
		}

		$items = $model->getSitemapItems();
		$application = JFactory::getApplication();
		$timezone = new DateTimeZone($application->get('offset'));
		$ssl = $application->get('force_ssl') == 2 ? 1 : 2;
		require_once JPATH_SITE . '/components/com_content/helpers/route.php';

		foreach ($items as $item)
		{
			$item->url = JRoute::_(ContentHelperRoute::getArticleRoute($item->id . ':' . $item->alias, $item->catid, $item->language), true, $ssl);
			$item->videos = array();
			$images = $item->images;
			$item->images = array();

			if ($feed->settings->get('type') != 'news' && $feed->settings->get('images') && $images)
			{
				$images = json_decode($images);

				if (isset($images->image_fulltext) && $images->image_fulltext)
				{
					$image = new stdClass();

					if (strpos($images->image_fulltext, 'http://') === 0 || strpos($images->image_fulltext, 'https://') === 0 || strpos($images->image_fulltext, '//') === 0)
					{
						$image->url = $images->image_fulltext;
					}
					else
					{
						$image->url = JUri::root(false) . $images->image_fulltext;
					}
					$image->caption = $images->image_fulltext_caption;
					$item->images[] = $image;
				}

				if (isset($images->image_intro) && $images->image_intro)
				{
					$image = new stdClass();

					if (strpos($images->image_intro, 'http://') === 0 || strpos($images->image_intro, 'https://') === 0 || strpos($images->image_intro, '//') === 0)
					{
						$image->url = $images->image_intro;
					}
					else
					{
						$image->url = JUri::root(false) . $images->image_intro;
					}
					$image->caption = $images->image_intro_caption;
					$item->images[] = $image;
				}
			}

			$publicationDate = JFactory::getDate($item->publish_up);
			$publicationDate->setTimeZone($timezone);
			$item->publicationDate = $publicationDate->toISO8601(true);
		}

		return $items;
	}

	public function countSitemapItems($feed)
	{

		// Get model
		$model = $this->getModel();

		if ($feed->settings->get('type') == 'news')
		{
			$model->setState('filter.days', 2);
		}

		// Set category filter
		if ($feed->sources->get('content') == 2 && is_array($feed->sources->get('contentCategories')) && count($feed->sources->get('contentCategories')))
		{
			$model->setState('categories', $feed->sources->get('contentCategories'));
		}

		return $model->countSitemapItems();
	}

	public function getInstantArticles($feed)
	{
		// Get model
		$model = $this->getModel();

		// Set category filter
		if ($feed->sources->get('content') == 2 && is_array($feed->sources->get('contentCategories')) && count($feed->sources->get('contentCategories')))
		{
			$model->setState('categories', $feed->sources->get('contentCategories'));
		}

		// Fetch items
		$items = $model->getInstantArticles();

		// Set some variables
		$application = JFactory::getApplication();
		$ssl = $application->get('force_ssl') == 2 ? 1 : 2;
		$timezone = new DateTimeZone($application->get('offset'));
		$languageParams = JComponentHelper::getParams('com_languages');
		$siteLanguage = $languageParams->get('site');
		$params = JComponentHelper::getParams('com_content');

		foreach ($items as $item)
		{

			// Build article params
			$itemParams = new Registry();
			$itemParams->loadString($item->attribs);
			$item->params = clone $params;
			$item->params->merge($itemParams);

			// Article GUID
			$item->guid = md5(JUri::root(false) . '.com_content.article.' . $item->id);

			// Article URL
			$item->url = JRoute::_(ContentHelperRoute::getArticleRoute($item->id . ':' . $item->alias, $item->catid, $item->language), true, $ssl);

			// Text
			if ($item->params->get('show_intro'))
			{
				$item->text = $item->introtext . $item->fulltext;
			}
			else
			{
				$item->text = $item->fulltext;
			}

			// Image
			$item->image = null;

			if ($item->images)
			{
				$images = json_decode($item->images);

				if (isset($images->image_fulltext) && $images->image_fulltext)
				{
					$image = new stdClass();
					$image->src = JUri::root(false) . $images->image_fulltext;
					$image->caption = $images->image_fulltext_caption;
					$item->image = $image;
				}
			}

			if (is_null($item->image))
			{
				$image = $this->getFirstImage($item->text);
			}

			// Content plugins
			$item->text = JHtml::_('content.prepare', $item->text);

			// Prepare Instant Articles markup
			$item->text = $this->prepareTextForInstantArticles($item->text);

			// Videos
			$item->video = null;

			// Gallery
			$item->gallery = array();

			// Author
			if ($item->params->get('show_author'))
			{
				if ($item->created_by_alias)
				{
					$item->author = $item->created_by_alias;
				}
				else
				{
					$item->author = JUser::getInstance($item->created_by)->name;
				}
			}

			// Publication and modification dates
			$publicationDate = JFactory::getDate($item->publish_up);
			$publicationDate->setTimeZone($timezone);
			$item->publicationDate = $publicationDate->toISO8601(true);

			if ((int) $item->modified)
			{
				$modificationDate = JFactory::getDate($item->modified);
				$modificationDate->setTimeZone($timezone);
				$item->modificationDate = $modificationDate->toISO8601(true);
			}
			else
			{
				$item->modificationDate = $item->publicationDate;
			}

			// Language
			if ($item->language == '*')
			{
				$item->language = $siteLanguage;
			}
			$item->language = strtolower($item->language);
		}

		return $items;
	}
}
