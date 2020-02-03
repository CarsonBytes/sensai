<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/library/plugins/app.php');
class plgJ2StoreApp_productcompare extends J2StoreAppPlugin
{
	/**
	 * @var $_element  string  Should always correspond with the plugin's filename,
	 *                         forcing it to be unique
	 */
	var $_element   = 'app_productcompare';

	/**
	 * Overriding
	 *
	 * @param $options
	 * @return unknown_type
	 */
	function onJ2StoreGetAppView( $row )
	{

		if (!$this->_isMe($row))
		{
			return null;
		}

		$html = $this->viewList();


		return $html;
	}

	/**
	 * Validates the data submitted based on the suffix provided
	 * A controller for this plugin, you could say
	 *
	 * @param $task
	 * @return html
	 */
	function viewList()
	{
		$app = JFactory::getApplication();
		$option = 'com_j2store';
		$ns = $option.'.app.'.$this->_element;
		$html = "";
		JToolBarHelper::title(JText::_('J2STORE_APP').'-'.JText::_('PLG_J2STORE_'.strtoupper($this->_element)),'j2store-logo');
		JToolBarHelper::apply('apply');
		JToolBarHelper::save();
		JToolBarHelper::back('PLG_J2STORE_BACK_TO_APPS', 'index.php?option=com_j2store&view=apps');
		JToolBarHelper::back('J2STORE_BACK_TO_DASHBOARD', 'index.php?option=com_j2store');

		$vars = new JObject();
		//model should always be a plural
		$this->includeCustomModel('AppProductCompares');

		$model = F0FModel::getTmpInstance('AppProductCompares', 'J2StoreModel');

		$data = $this->params->toArray();
		$newdata = array();
		$newdata['params'] = $data;
		$form = $model->getForm($newdata);
		$vars->form = $form;

		$this->includeCustomTables();

		$id = $app->input->getInt('id', '0');
		$vars->id = $id;
		$vars->action = "index.php?option=com_j2store&view=app&task=view&id={$id}";
		$html = $this->_getLayout('default', $vars);
		return $html;
	}

	public function onJ2StoreAfterAddToCartButton($product,$context) {
		$app = JFactory::getApplication();
		if($app->isAdmin()) return '';
		$sesssion = JFactory::getSession();
		$compare_list = $sesssion->get('product_compare',array(),'j2store');
		$doc = JFactory::getDocument();
		$doc->addScript(JUri::root(true).'/plugins/j2store/'.$this->_element.'/'.$this->_element.'/assets/js/compare.js');
		$vars = new JObject();
		$table = F0FTable::getInstance('App', 'J2StoreTable');
		$table->load(array('element'=>$this->_element));
		$vars->aid = $table->extension_id;
		$vars->product = $product;
		$vars->params = $this->params;
		$vars->compare_list = $compare_list;
		$view_pos = (strpos($context, 'view_cart') || strpos($context, 'item_cart')|| strpos($context, 'article.item_cart'));
		$category_pos = (strpos($context, 'default_cart') || strpos($context, 'category') || strpos($context ,'j2store.site.category.item_cart') || strpos($context, 'category.cart') || strpos($context, 'article.cart'));
		$qoptions = array (
			'option' => 'com_j2store',
			'view' => 'products',
			'task' => 'compare',
		);
		$pro_menu = J2StoreRouterHelper::findProductMenu ( $qoptions );
		$vars->item_id = isset($pro_menu->id) ? $pro_menu->id:null;
		if ($view_pos !== false  && $this->params->get('layout_type',1) =='1' ) {
			return  $this->_getLayout('form', $vars);
		}elseif($category_pos !==false && $this->params->get('layout_type') =='2'){
			return  $this->_getLayout('form', $vars);
		}elseif($this->params->get('layout_type') =='3'){
			return  $this->_getLayout('form', $vars);
		}
	}

	public static function findProductMenu($qoptions) {

		$menus =JMenu::getInstance('site');
		$menu_id = null;
		$other_tasks = array('compare');
		foreach($menus->getMenu() as $item)
		{
			if(isset($item->query['view']) && $item->query['view']=='products') {
				if (isset($item->query['task']) && !empty($item->query['task']) && in_array($item->query['task'] , $other_tasks) ){
					$menu_id =$item->id;
					break;
				}
				if(self::checkMenuProducts($item, $qoptions)) {
					$menu_id =$item->id;
					//break on first found menu
					break;
				}
			}

		}
		return $menu_id;

	}

	public function onJ2StoreCompareProductHtml() {
		$app = JFactory::getApplication();
		$sesssion = JFactory::getSession();
		$product_helper = J2Store::product();
		$this->includeCustomModel('AppProductCompares');
		$model = F0FModel::getTmpInstance('AppProductCompares', 'J2StoreModel');
		$products =array();
		$compare_list = $sesssion->get('product_compare',array(),'j2store');
		$product_id_list =array();
		foreach($compare_list as $variant_id => $product_id){
			$product_id_list[] = $product_id;
		}
		$array = array();
		if(!empty($product_id_list)){
			$filters = F0FModel::getTmpInstance('Products', 'J2StoreModel')->getProductFilters($product_id_list);
			foreach($filters as $group_id=>$filter) {
				foreach($filter['filters'] as $f) {
					 //$array[$filter['group_name']][$f->product_id][] = $f->filter_name;
					 $array[$filter['group_name']]= $f->filter_name;
				}
			}
			foreach($compare_list as $variant_id => $product_id){
				$product = $product_helper->setId($product_id)->getProduct();
				F0FModel::getTmpInstance('Products', 'J2StoreModel')->runMyBehaviorFlag(true)->getProduct($product);
				$products[] = $product;
			}
		}
		$vars = new JObject();
		$vars->products = $products;
		$vars->params = F0FModel::getTmpInstance('Products', 'J2StoreModel')->getMergedParams();
		$vars->continue_url = F0FModel::getTmpInstance('Carts','J2StoreModel')->getContinueShoppingUrl();
		$vars->filters = $array;

		$table = F0FTable::getInstance('App', 'J2StoreTable');
		$table->load(array('element'=>$this->_element));
		$vars->aid = $table->extension_id;
		$html = $this->_getLayout('compare', $vars);
		return $html;
	}
}

