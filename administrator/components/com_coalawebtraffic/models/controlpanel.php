<?php

/**
 * @package     Joomla
 * @subpackage  CoalaWeb Traffic
 * @author      Steven Palmer <support@coalaweb.com>
 * @link        https://coalaweb.com/
 * @license     GNU/GPL V3 or later; https://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (c) 2020 Steven Palmer All rights reserved.
 *
 * CoalaWeb Traffic is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT .  '/tables');

/**
 * Methods supporting a control panel
 *
 * @package    Joomla.Administrator
 * @subpackage com_coalawebtraffic
 */
class CoalawebtrafficModelControlpanel extends JModelLegacy
{
    
    /**
     * Check if a download ID is needed (Pro versions)
     * 
     * @return boolean
     */
    public function needsDownloadID() {
        // Do I need a Download ID?
        $ret = true;
        $isPro = defined('COM_CWTRAFFIC_PRO') ? COM_CWTRAFFIC_PRO : 0;
        if (!$isPro) {
            $ret = false;
        } else {
            jimport('joomla.application.component.helper');
            $componentParams = JComponentHelper::getParams('com_coalawebtraffic');
            $dlid = $componentParams->get('downloadid');
            
            if (preg_match('/^([0-9]{1,}:)?[0-9a-f]{32}$/i', $dlid)) {
                $ret = false;
            }
        }

        return $ret;
    }
    
    /**
     * Return a list of Countries
     * 
     * @return type
     */
    function getCountries() 
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select(
            $this->getState(
                'list.select', 'a.country_code, a.country_name, COUNT(1) as num'
            )
        );

        $query->from($db->qn('#__cwtraffic', 'a'));
        $query->where($db->qn('a.country_code') . ' IS NOT NULL ');
        $query->where($db->qn('a.country_code') . ' <> ""');
        $query->group('a.country_code, a.country_name');
        $query->order($db->qn('num') . ' DESC ');

        $db->setQuery($query, 0, 5);

        try {
            $query = $db->loadObjectList();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return null;
        }

        return $query;
    }

    /**
     * Return list of cities
     * 
     * @return object
     */
    function getCities() 
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select(
            $this->getState(
                'list.select', 'a.city, a.country_name, a.country_code, COUNT(1) as num'
            )
        );

        $query->from($db->qn('#__cwtraffic', 'a'));
        $query->where($db->qn('a.city') . ' IS NOT NULL ');
        $query->where($db->qn('a.city') . ' <> ""');
        $query->group('a.city, a.country_name, a.country_code');
        $query->order($db->qn('num') . ' DESC ');

        $db->setQuery($query, 0, 5);

        try {
            $query = $db->loadObjectList();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return null;
        }

        return $query;
    }
    
    /**
     * Get current counts to display in control panel
     * 
     * @return array
     */
    function getStats() 
    {
        $comParams = JComponentHelper::getParams('com_coalawebtraffic');
        $db = JFactory::getDbo();

        //Work out the time off set
        $config = JFactory::getConfig();
        $siteOffset = $config->get('offset');
        date_default_timezone_set($siteOffset);

        $day = date('d');
        $month = date('m');
        $year = date('Y');
        
        $daystart = mktime(0, 0, 0, $month, $day, $year);
        $monthstart = mktime(0, 0, 0, $month, 1, $year);
        $yesterdaystart = $daystart - (24 * 60 * 60);
        
        $weekDayStart = $comParams->get('week_start');
        if ($weekDayStart === 'mon') {
            $weekstart = $daystart - ((date('N') - 1) * 24 * 60 * 60);
        } else {
            $weekstart = $daystart - (date('N') * 24 * 60 * 60);
        }

        $preset = $comParams->get('preset', 0);

        //Count ongoing total
        $query = $db->getQuery(true);
        $query->select('TCOUNT');
        $query->from($db->qn('#__cwtraffic_total'));
        $db->setQuery($query);

        try {
            $tcount = $db->loadResult();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return array();
        }

        // Create base to count from
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->qn('#__cwtraffic'));
        $db->setQuery($query);

        try {
            $all_visitors = $db->loadResult();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return array();
        }

        $all_visitors += $preset;
        $all_visitors += $tcount;

        //Todays Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->qn('#__cwtraffic'));
        $query->where('tm > ' . $db->q($daystart));
        $db->setQuery($query);

        try {
            $today_visitors = $db->loadResult();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return array();
        }

        //Yesterdays Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->qn('#__cwtraffic'));
        $query->where('tm > ' . $db->q($yesterdaystart));
        $query->where('tm < ' . $db->q($daystart));
        $db->setQuery($query);

        try {
            $yesterday_visitors = $db->loadResult();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return array();
        }

        //This Weeks Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->qn('#__cwtraffic'));
        $query->where('tm >= ' . $db->q($weekstart));
        $db->setQuery($query);

        try {
            $week_visitors = $db->loadResult();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return array();
        }

        //Months Visitors
        $query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from($db->qn('#__cwtraffic'));
        $query->where('tm >= ' . $db->q($monthstart));
        $db->setQuery($query);

        try {
            $month_visitors = $db->loadResult();
        } catch (JDatabaseExceptionExecuting $e) {
            JError::raiseWarning(500, JText::sprintf('COM_CWTRAFFIC_DB_ERROR', $e->getMessage()));
            return array();
        }
        
        $ret = array($all_visitors, $today_visitors, $yesterday_visitors, $week_visitors, $month_visitors);
        return ($ret);
        
    }

}
