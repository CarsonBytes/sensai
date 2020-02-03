<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

class Route66Router extends JComponentRouterBase
{
	public function build(&$query)
	{
		$segments = array();

		if (isset($query['view']))
		{
			$segments[] = $query['view'];
			unset($query['view']);
		}

		if (isset($query['id']))
		{
			$segments[] = $query['id'];
			unset($query['id']);
		}

		if (isset($query['extension']))
		{
			$segments[] = $query['extension'];
			unset($query['extension']);
		}

		return $segments;
	}

	public function parse(&$segments)
	{
		$vars = array();

		$vars['view'] = $segments[0];
		$vars['id'] = $segments[1];

		if (isset($segments[2]))
		{
			$vars['extension'] = $segments[2];
		}

		return $vars;
	}
}
