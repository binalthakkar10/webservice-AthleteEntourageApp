<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

class Controller extends CController
{

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs;

	public static function getCurrentTimeStamp($key='')
	{
		$timeStamp = CTimestamp::getDate(mktime());
		if(isset($timeStamp[$key])) return $timeStamp[$key];
		else return $timeStamp;
	}
	public static function priceFormat ($price, $symbol=false) {
		$price = sprintf('%.2f', $price);
		if(Yii::app()->language == 'de')
		$price = str_replace('.', ',', $price);

		if($symbol)
		$price = self::getCurrency('symbol').$price;
		return $price;
	}

	public static function getCurrency($type='code')
	{
		if($type=='code') {
			return SystemConfig::getValue('default_currency');
		}else {
			return SystemConfig::getValue('default_currency_symbol');;
		}
	}

}