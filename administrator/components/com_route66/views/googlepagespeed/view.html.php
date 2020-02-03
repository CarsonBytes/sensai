<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class Route66ViewGooglePageSpeed extends JViewLegacy
{
	public function display($tpl = null)
	{
		$application = JFactory::getApplication();

		$this->loadHelper('html');
		$this->loadHelper('extension');
		$this->sidebar = Route66HelperHtml::getSidebar('googlepagespeed');

		JToolBarHelper::title(JText::_('COM_ROUTE66_GOOGLE_PAGESPEED'), 'dashboard');
		$customButton = '<a class="btn btn-small" target="_blank" href="https://developers.google.com/speed/pagespeed/insights/?url=' . urlencode(JUri::root(false)) . '"><i class="icon-new-tab"></i>' . JText::_('COM_ROUTE66_ANALYZE_YOUR_SITE') . '</a>';
		$toolbar = JToolBar::getInstance('toolbar');
		$toolbar->appendButton('Custom', $customButton);
		JToolBarHelper::help(null, false, 'https://www.firecoders.com/documentation/route-66');
		Route66HelperHtml::addOptionsButton();

		if (JPluginHelper::isEnabled('system', 'route66pagespeed'))
		{
			Route66HelperExtension::checkPluginsOrdering();
		}
		else
		{
			$application->enqueueMessage(JText::_('COM_ROUTE66_PAGESPEED_PLUGIN_DISABLED_WARNING'), 'warning');
		}

		$this->params = JComponentHelper::getParams('com_route66');

		parent::display($tpl);
	}
}
