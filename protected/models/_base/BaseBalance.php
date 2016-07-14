<?php

/**
 * This is the model base class for the table "balance".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Balance".
 *
 * Columns in table "balance" available as properties of the model,
 * followed by relations of table "balance" available as properties of the model.
 *
 * @property integer $balance_id
 * @property integer $user_id
 * @property double $balance
 * @property string $created_date
 * @property string $updated_date
 * @property integer $is_delete
 *
 * @property UserDetail $user
 */
abstract class BaseBalance extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'balance';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Balance|Balances', $n);
	}

	public static function representingColumn() {
		return 'created_date';
	}

	public function rules() {
		return array(
			array('user_id, balance, created_date', 'required'),
			array('user_id, is_delete', 'numerical', 'integerOnly'=>true),
			array('balance', 'numerical'),
			array('updated_date', 'safe'),
			array('updated_date, is_delete', 'default', 'setOnEmpty' => true, 'value' => null),
			array('balance_id, user_id, balance, created_date, updated_date, is_delete', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'UserDetail', 'user_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'balance_id' => Yii::t('app', 'Balance'),
			'user_id' => null,
			'balance' => Yii::t('app', 'Balance'),
			'created_date' => Yii::t('app', 'Created Date'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'is_delete' => Yii::t('app', 'Is Delete'),
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('balance_id', $this->balance_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('balance', $this->balance);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('updated_date', $this->updated_date, true);
		$criteria->compare('is_delete', $this->is_delete);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}