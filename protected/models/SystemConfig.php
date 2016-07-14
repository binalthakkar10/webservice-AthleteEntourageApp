<?php

Yii::import('application.models._base.BaseSystemConfig');

class SystemConfig extends BaseSystemConfig
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function rules() {
		return array(
			array('system_section_id, system_group_id, name, value, position','required'),
			array('system_section_id, system_group_id, status, position', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('input_type', 'length', 'max'=>8),
			array('value, input_options', 'safe'),
			array('system_section_id, system_group_id, name, value, input_type, input_options, status, position', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, system_section_id, system_group_id, name, value, input_type, input_options, status, position', 'safe', 'on'=>'search'),
		);
	}
	public static function getValue($path='',$allFields=0)
	{
		$model = SystemConfig::model();
		$criteria = new CDbCriteria();
		$criteria->condition = "TRIM(LCASE(name)) = TRIM(LCASE('".$path."'))";
		$data = $model->find($criteria);
		if($allFields==0) return $data->value;
		else return $data->attributes;
	}

	public static function getValueIndex($path='', $sep=',', $ind=0, $allFields=0)
	{
		$val = self::getValue($path, $allFields);
		$array = explode($sep, $val);
		if(isset($array[$ind])) return $array[$ind];
		else return false;
	}

	public static function label($n = 1) {
		return Yii::t('app', 'System Config|System Configs', $n);
	}

	public function relations() {
		return array(
			'systemGroup' => array(self::BELONGS_TO, 'SystemGroup', 'system_group_id'),
			'systemSection' => array(self::BELONGS_TO, 'SystemSection', 'system_section_id'),
		);
	}
}