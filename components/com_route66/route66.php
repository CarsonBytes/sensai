<?php
/**
 * @author      Lefteris Kavadas
 * @copyright   Copyright (c) 2016 - 2019 Lefteris Kavadas / firecoders.com
 * @license     GNU General Public License version 3 or later
 */
defined('_JEXEC') or die;

$controller = JControllerLegacy::getInstance('Route66');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
