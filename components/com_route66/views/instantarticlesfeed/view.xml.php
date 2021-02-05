<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66ViewInstantArticlesFeed extends JViewLegacy
{
	public function display($tpl = null)
	{
		$application = JFactory::getApplication();
		JLoader::register('Route66ModelInstantArticlesFeed', JPATH_ADMINISTRATOR . '/components/com_route66/models/instantarticlesfeed.php');
		$model = JModelLegacy::getInstance('InstantArticlesFeed', 'Route66Model', array('ignore_request' => true));
		$this->feed = $model->getItem($application->input->getInt('id'));

		if (!$this->feed->state)
		{
			return JError::raiseError(404, JText::_('JERROR_PAGE_NOT_FOUND'));
		}
		$this->feed->items = $model->getInstantArticlesFeedItems($this->feed);

		parent::display($tpl);
	}
}
