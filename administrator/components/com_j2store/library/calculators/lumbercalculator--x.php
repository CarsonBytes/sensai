<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2015-19 Sasi varna kumar / J2Store.org
 * @license GNU GPL v3 or later
 */

// No direct access
defined('_JEXEC') or die;

require_once(JPATH_ADMINISTRATOR.'/components/com_j2store/library/calculators/standardcalculator.php');

class LumberCalculator extends StandardCalculator {
	
	
	public function __construct($config=array()) {
		parent::__construct($config);
	}
	
	/**
	 * Method that calculates the price each time when product price is got
	 * 
	 * */
	public function calculate() {
		
		$variant = $this->get('variant');
		$quantity = $this->get('quantity');
		$date = $this->get('date');
		$group_id = $this->get('group_id');
		
		$plugin = JPluginHelper::getPlugin('j2store', 'app_lumbercalc');
		if (is_object($plugin)) {
			$plugin_params =  new JRegistry($plugin->params);
			$credit_option_id = $plugin_params->get('option_id',0);
			$length_id = $plugin_params->get('length_option',0);
			$width_id = $plugin_params->get('width_option',0);
			$height_id = $plugin_params->get('height_option',0);
		}else{
			// if nothing works out, just call the parent function for standard calculation
			return parent::calculate();
		}		

		$pricing = new JObject();
		$price = $variant->price;
		$pricing->base_price = $price;
		$pricing->price = $price;

		$app = JFactory::getApplication();
		$data = $app->input->getArray($_REQUEST);

		$length = $width = $height = 0.00 ;

		if (isset($variant->options) && $length_id > 0 && $width_id > 0 && $height_id > 0) {
			foreach ($variant->options as $k => $option) {
					if (!empty($option['option_value']) ) {
						switch ($option['option_id']) {
							case $length_id: $length = $option['option_value']; break;
							case $width_id: $width = $option['option_value']; break;
							case $height_id: $height = $option['option_value']; break;
							default: break;
						}
					}
			}
		}

		//multiply the value with the price 100 times to set the value as the product price..
		$calculated_price = 0.00 ; 
		//echo 'l'.$length .'w'. $width .'h'. $height ;
		if ($length > 0.00 && $width > 0.00 && $height > 0.00) {
			$calculated_price = ($length * $width * $height) / 144 ; 
		}

		if ($calculated_price > 0.00)
		{
			$pricing->base_price = $calculated_price;
			$pricing->price = $calculated_price; // original sale price considered for computation
			$pricing->is_discount_pricing_available = false;
			$pricing->calculator = 'lumber';
			return $pricing;
		}

		// if nothing works out, just call the parent function for standard calculation
		return parent::calculate();
	}

}
