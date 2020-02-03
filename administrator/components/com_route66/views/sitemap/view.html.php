<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66ViewSitemap extends JViewLegacy
{
	protected $form;
	protected $state;
	protected $item;

	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->state = $this->get('State');
		$this->params = JComponentHelper::getParams('com_route66');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		$this->loadHelper('html');

		JToolBarHelper::title(JText::_('COM_ROUTE66_SITEMAP_TITLE'), 'tree-2');
		JRequest::setVar('hidemainmenu', true);

		JToolBarHelper::apply('sitemap.apply');
		JToolBarHelper::save('sitemap.save');
		JToolbarHelper::save2copy('sitemap.save2copy');
		JToolBarHelper::cancel('sitemap.cancel');

		JHtml::_('behavior.tooltip');
		JHtml::_('behavior.formvalidation');
		JHtml::_('behavior.keepalive');
		JHtml::_('formbehavior.chosen', 'select');

		parent::display($tpl);
	}
}
