<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66ViewSitemapIndex extends JViewLegacy
{
	public function display($tpl = null)
	{
		$application = JFactory::getApplication();
		JLoader::register('Route66ModelSitemap', JPATH_ADMINISTRATOR . '/components/com_route66/models/sitemap.php');
		$model = JModelLegacy::getInstance('Sitemap', 'Route66Model', array('ignore_request' => true));
		$this->item = $model->getItem($application->input->getInt('id'));

		if (!$this->item->state)
		{
			return JError::raiseError(404, JText::_('JERROR_PAGE_NOT_FOUND'));
		}

		$this->items = $model->getSitemapIndex($this->item);
		parent::display($tpl);
	}
}
