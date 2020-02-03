<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class Route66ViewAnalysis extends JViewLegacy
{
	public function display($tpl = null)
	{
		$this->isPro = JFile::exists(JPATH_SITE . '/plugins/k2/route66seo/media/js/route66analyzer.js');

		$this->loadHelper('html');
		$this->loadHelper('extension');
		$version = Route66HelperExtension::getVersion();

		JToolBarHelper::title(JText::_('COM_ROUTE66_SEO_ANALYSIS_TITLE'), 'search');
		$toolbar = JToolbar::getInstance('toolbar');
		$toolbar->appendButton('Link', 'back', 'JTOOLBAR_BACK', 'index.php?option=com_route66&view=seo');

		if ($this->isPro)
		{
			JHtml::_('jquery.framework');
			JHtml::_('behavior.formvalidation');
			$document = JFactory::getDocument();
			$document->addStyleSheet(JUri::root(true) . '/media/route66/css/route66seo.css', array('version' => $version));
			$document->addScript(JUri::root(true) . '/media/route66/js/circle-progress.min.js', array('version' => $version));
			$this->loadLanguage();
			$document->addScript(JUri::root(true) . '/media/route66/js/yoast.min.js', array('version' => $version));
			$document->addScript(JUri::root(true) . '/plugins/k2/route66seo/media/js/route66analyzer.js', array('version' => $version));
			JText::script('ERROR');
			JText::script('COM_ROUTE66_YOU_CAN_USE_ONLY_INTERNAL_URLS');

			$this->form = JForm::getInstance('route66seoanalysis', JPATH_SITE . '/administrator/components/com_route66/forms/route66seoanalysis.xml', array('control' => 'jform'));

			$button = '<button onclick="Joomla.submitbutton(\'seo.fetchPage\');" class="btn btn-small btn-success"><span class="icon-play icon-white" title="' . JText::_('COM_ROUTE66_ANALYZE') . '"></span>' . JText::_('COM_ROUTE66_ANALYZE') . '</button>';
			$toolbar->appendButton('Custom', $button, 'generate');
		}
		else
		{
			$application = JFactory::getApplication();
			$application->enqueueMessage(JText::_('COM_ROUTE66_PAGE_CONTENT_ANALYSIS_PRO_FEATURE'), 'warning');
		}

		parent::display($tpl);
	}

	private function loadLanguage()
	{
		$i18n = '';
		$language = JFactory::getLanguage();
		$language->load('com_route66', JPATH_ADMINISTRATOR . '/components/com_route66');
		$tag = $language->getTag();
		$locale = str_replace('-', '_', $tag);

		$path = JPATH_ADMINISTRATOR . '/components/com_route66/lib/translations';
		$files = array('wordpress-seo-' . $locale . '.json');

		if (strpos($locale, '_'))
		{
			$parts = explode('_', $locale);
			$files[] = 'wordpress-seo-' . $parts[0] . '.json';
		}

		foreach ($files as $file)
		{
			if (JFile::exists($path . '/' . $file))
			{
				$buffer = JFile::read($path . '/' . $file);
				$buffer = str_replace('wordpress-seo', 'js-text-analysis', $buffer);
				$i18n = json_decode($buffer);

				break;
			}
		}

		$document = JFactory::getDocument();
		$document->addScriptOptions('Route66AnalyzerOptions', array('i18n' => $i18n));
	}
}
