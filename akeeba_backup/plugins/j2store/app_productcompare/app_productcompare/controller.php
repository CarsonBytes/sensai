<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
/**
 * ensure this file is being included by a parent file
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );
require_once (JPATH_ADMINISTRATOR . '/components/com_j2store/library/appcontroller.php');
class J2StoreControllerAppProductCompare extends J2StoreAppController {
	var $_element = 'app_productcompare';

	function __construct($config = array()) {
		parent::__construct ( $config );
		//there is problem in loading of language
		//this code will fix the language loading problem
		$language = JFactory::getLanguage();
		$extension = 'plg_j2store'.'_'. $this->_element;
		$language->load($extension, JPATH_ADMINISTRATOR, 'en-GB', true);
		$language->load($extension, JPATH_ADMINISTRATOR, null, true);
	}

	protected function onBeforeGenericTask($task)
	{
		$privilege = $this->configProvider->get(
				$this->component . '.views.' .
				F0FInflector::singularize($this->view) . '.acl.' . $task, ''
		);
		return $this->allowedTasks($task);
	}

	function addcompare() {
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$params = J2Store::config();

		$id = $app->input->getInt('id',0);
		$appModel = F0FModel::getTmpInstance('Apps' ,'J2StoreModel');
		$row = $appModel->getItem($id);
		$registry = new JRegistry();
		$params = $registry->loadString($row->params);
		$max_products = $params->get('max_products_in_compare',5);
		$product_id = $this->input->getInt('product_id');
		$variant_id = $this->input->getInt('variant_id');
		$json =array();
		$list = $session->get('product_compare',array(),'j2store');

		if(isset($list[$variant_id]) && $list[$variant_id] == $product_id ){
			$json['exists'] = true;
			$json['error'] = JText::_('J2STORE_ITEM_ALREADY_ADDED_TO_COMPARE_LIST');
		}
		if(count($list) >= $max_products ){
			$json['error'] = JText::sprintf('PLG_J2STORE_COMPARE_HAS_MAXIMUM_PRODUCTS', $max_products);
		}
		if( !isset($json['error']) && $variant_id && $product_id ){
					$list[$variant_id] = $product_id;
					$session->set('product_compare',$list,'j2store');
		}

		if(!isset($json['error'])) {
			$json['success'] = true;
		}
		echo json_encode($json);
		$app->close();
	}

	function allowedTasks($task) {
		$allowed = array('addcompare' ,'removeCompare' ,'clearAlllist');
		if(in_array($task, $allowed)) {
			return true;
		}
		return false;
	}

	/**
	 * Method to remove the compared items from the session
	 */
	function removeCompare(){
		$app = JFactory::getApplication();
		$sesssion = JFactory::getSession();
		$json =array();
		$product_id = $app->input->getInt('product_id');
		$variant_id = $app->input->getInt('variant_id');
		if($product_id && $variant_id){
			$compare_list = $sesssion->get('product_compare',array(),'j2store');
			if(in_array($variant_id, array_keys($compare_list))){
				unset($compare_list[$variant_id]);
			}
			///set the new array into the session
			$sesssion->set('product_compare',$compare_list,'j2store');
			$json['success'] = JText::_('J2STORE_PRODUCT_REMOVED_FROM_COMPARE');
		}else{
			$json['error'] = true;
		}
		echo json_encode($json);
		$app->close();
	}

	function clearAlllist(){
		$app = JFactory::getApplication();
		$sesssion = JFactory::getSession();
		$json =array();
		$json['success'] = JText::_('J2STORE_COMPARE_LIST_DELETED_SUCCESSFULLY');
		if(!$sesssion->clear('product_compare','j2store')){
			$json['error'] = JText::_('J2STORE_ERROR_REMOVEING_COMPARE_LIST');
		}
		echo json_encode($json);
		$app->close();

	}
}

