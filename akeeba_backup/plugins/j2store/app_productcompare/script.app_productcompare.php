<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');
class plgJ2StoreApp_productcompareInstallerScript {
	protected $source ='source';
	function preflight( $type, $parent ) {
		if(!JComponentHelper::isEnabled('com_j2store')) {
			Jerror::raiseWarning(null, 'J2Store is not found. Please install J2Store before installing this plugin');
			return false;
		}
		require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/version.php');
		if(version_compare(J2STORE_VERSION, '3.1.7', 'lt')) {
			Jerror::raiseWarning(null, 'You need at least J2Store Version 3.1.7 for this application to work. Please update your J2Store');
			return false;
		}
	}
	public function postflight($type, $parent){
		$this->_moveSource($parent);
	}
	/**
	 * Method to move source files into
	 * Products/view
	 * @param object $parent
	 */
	public function _moveSource($parent){
		$src = $parent->getParent()->getPath('source');
		//have to move the files in the path
		$source_path = $src.'/'.$this->source.'/';
		$destination_path = JPATH_SITE.'/components/com_j2store/views/products/tmpl/';
		if (is_dir($source_path)){
			//destination path
			$files = JFolder::files($source_path);
			foreach($files as $file){
				if (!JFile::move($source_path.$file, $destination_path.$file) ) {
					$parent->getParent()->abort('Could not move folder '.$destination_path .'Check permissions.');
					return false;
				}
			}
		}
	}
}