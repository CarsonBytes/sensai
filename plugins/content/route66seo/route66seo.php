<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';
require_once JPATH_ADMINISTRATOR . '/components/com_route66/lib/seoanalyzer.php';

class PlgContentRoute66Seo extends JPlugin
{
	protected $autoloadLanguage = true;
	protected $enabled = false;

	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);
		$params = JComponentHelper::getParams('com_route66');
		$this->enabled = $params->get('seo', true);
	}

	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');

			return false;
		}

		$name = $form->getName();
		$application = JFactory::getApplication();

		if ($this->enabled && $name == 'com_content.article' && $application->input->getMethod() == 'GET')
		{

            // Cast to object
			if (is_array($data))
			{
				$data = (object) $data;
			}

			if (!isset($data->route66seo))
			{
				$data->route66seo = array();
			}

			// Attach analyzer to form
			$options = $this->getScriptOptions($data->id, $data->catid);
			$params = JComponentHelper::getParams('com_route66');
			$position = $params->get('seo_display_position', 'form');
			$Route66SeoAnalyzer = new Route66SeoAnalyzer($data->route66seo, $options, $position);
			$Route66SeoAnalyzer->render($form);
		}
	}

	public function getScriptOptions($id, $catid = 0)
	{
		$options = array();
		$options['option'] = 'com_content';
		$options['view'] = 'article';
		$options['id'] = $id;
		$options['aliasToken'] = '{articleAlias}';
		$options['fields'] = array(
          'title' => '#jform_title',
          'pagetitle' => '#jform_attribs_article_page_title',
          'alias' => '#jform_alias',
          'text' => '#jform_articletext',
          'description' => '#jform_metadesc',
        );
		$options['route'] = ContentHelperRoute::getArticleRoute((int) $id . ':' . $options['aliasToken'], (int) $catid);
		$params = JComponentHelper::getParams('com_content');
		$options['split'] = !$params->get('show_intro');

		return $options;
	}

	public function onContentAfterSave($context, $article, $isNew)
	{
		if ($this->enabled && $context == 'com_content.article')
		{
			$application = JFactory::getApplication();
			$data = $application->input->post->get('jform', array(), 'array');

			if (isset($data['route66seo']) && is_array($data['route66seo']) && isset($data['route66seo']['score']))
			{
				$score = (int) $data['route66seo']['score'];
				$keyword = $data['route66seo']['keyword'];
				$resourceId = (int) $article->id;

				JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_route66/models');
				$model = JModelLegacy::getInstance('Seo', 'Route66Model');
				$model->delete($context, $article->id);
				$model->save($context, $article->id, $keyword, $score);
			}
		}
	}

	public function onContentPrepareData($context, &$data)
	{
		if (!$this->enabled || $context != 'com_content.article')
		{
			return true;
		}

		$id = is_object($data) ? $data->id: $data['id'];

		if ($id)
		{
			JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_route66/models');
			$model = JModelLegacy::getInstance('Seo', 'Route66Model');
			$result = $model->fetch($context, $id);

			if (is_object($data))
			{
				$data->route66seo = (array) $result;
			}
			else
			{
				$data['route66seo'] = (array) $result;
			}
		}

		return true;
	}

	public function onContentAfterDelete($context, $data)
	{
		if ($this->enabled && $context == 'com_content.article')
		{
			JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_route66/models');
			$model = JModelLegacy::getInstance('Seo', 'Route66Model');
			$model->delete($context, $data->id);
		}

		return true;
	}
}
