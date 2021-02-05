<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

JLoader::register('Route66ModelMetadata', JPATH_ADMINISTRATOR . '/components/com_route66/models/metadata.php');

class PlgContentRoute66Metadata extends JPlugin
{
	protected $autoloadLanguage = true;

	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');

			return false;
		}

		$name = $form->getName();
		$application = JFactory::getApplication();

		if ($name == 'com_content.article' && $application->input->getMethod() == 'GET')
		{
			// Add data
			if (is_array($data) && !isset($data['route66metadata']))
			{
				$data['route66metadata'] = array();
			}
			elseif (is_object($data) && !isset($data->route66metadata))
			{
				$data->route66metadata = array();
			}

			JForm::addFormPath(JPATH_ADMINISTRATOR . '/components/com_route66/forms');
			$form->loadFile('route66metadata', false);
		}
	}

	public function onContentAfterSave($context, $article, $isNew)
	{
		if ($context == 'com_content.article')
		{
			$application = JFactory::getApplication();
			$data = $application->input->post->get('jform', array(), 'array');

			if (isset($data['route66metadata']) && is_array($data['route66metadata']))
			{
				$resourceId = (int) $article->id;
				$model = JModelLegacy::getInstance('Metadata', 'Route66Model');
				$model->delete($context, $article->id);
				$model->save($context, $article->id, $data['route66metadata']);
			}
		}
	}

	public function onContentPrepareData($context, $data)
	{
		if ($context != 'com_content.article')
		{
			return true;
		}
		$id = is_object($data) ? $data->id: $data['id'];

		if ($id)
		{
			$model = JModelLegacy::getInstance('Metadata', 'Route66Model');
			$result = $model->fetch($context, $id);

			if ($result)
			{
				$metadata = json_decode($result->metadata);
			}
			else
			{
				$metadata = array();
			}

			if (is_object($data))
			{
				$data->route66metadata = $metadata;
			}
			else
			{
				$data['route66metadata'] = $metadata;
			}
		}

		return true;
	}

	public function onContentAfterDelete($context, $data)
	{
		if ($context == 'com_content.article')
		{
			$model = JModelLegacy::getInstance('Metadata', 'Route66Model');
			$model->delete($context, $data->id);
		}

		return true;
	}
}
