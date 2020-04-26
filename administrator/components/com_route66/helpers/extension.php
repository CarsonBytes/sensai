<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2020 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66HelperExtension
{
	public static function getVersion()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->qn('manifest_cache'))->from($db->qn('#__extensions'))->where($db->qn('element') . ' = ' . $db->q('pkg_route66'));
		$db->setQuery($query);
		$manifest = json_decode($db->loadResult());

		return $manifest->version;
	}

	public static function checkPluginsOrdering()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->qn('element'));
		$query->from($db->qn('#__extensions'));
		$query->where($db->qn('folder') . ' = ' . $db->q('system'));
		$query->where($db->qn('enabled') . ' = 1');
		$query->order($db->qn('ordering') . ' DESC');
		$db->setQuery($query, 0, 2);
		$plugins = $db->loadColumn();

		$warning = null;

		foreach ($plugins as $plugin)
		{
			if ($plugin != 'route66' && $plugin != 'route66pagespeed')
			{
				$warning = JText::_('COM_ROUTE66_WRONG_PLUGIN_ORDER');
			}
		}

		if ($warning)
		{
			$application = JFactory::getApplication();
			$application->enqueueMessage($warning, 'warning');
		}
	}
}
