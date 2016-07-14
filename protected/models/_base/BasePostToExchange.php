<?php

/**
 * This is the model base class for the table "post_to_exchange".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PostToExchange".
 *
 * Columns in table "post_to_exchange" available as properties of the model,
 * followed by relations of table "post_to_exchange" available as properties of the model.
 *
 * @property integer $postexchange_id
 * @property integer $user_id
 * @property integer $campaign_id
 * @property integer $user_type
 * @property string $message
 * @property string $created_date
 * @property string $start_date
 * @property string $end_date
 * @property string $post_type
 * @property double $cost
 * @property integer $is_paid
 * @property integer $is_delete
 *
 * @property UserDetail $user
 */
abstract class BasePostToExchange extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'post_to_exchange';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'PostToExchange|PostToExchanges', $n);
	}

	public static function representingColumn() {
		return 'message';
	}

	public function rules() {
		return array(
			array('user_id, campaign_id, user_type, message, created_date, start_date, end_date, post_type, cost', 'required'),
			array('user_id, campaign_id, user_type, is_paid, is_delete', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('message', 'length', 'max'=>5000),
			array('post_type', 'length', 'max'=>5),
			array('is_paid, is_delete', 'default', 'setOnEmpty' => true, 'value' => null),
			array('postexchange_id, user_id, campaign_id, user_type, message, created_date, start_date, end_date, post_type, cost, is_paid, is_delete', 'safe', 'on'=>'search'),
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
			'postexchange_id' => Yii::t('app', 'Postexchange'),
			'user_id' => null,
			'campaign_id' => Yii::t('app', 'Campaign'),
			'user_type' => Yii::t('app', 'User Type'),
			'message' => Yii::t('app', 'Message'),
			'created_date' => Yii::t('app', 'Created Date'),
			'start_date' => Yii::t('app', 'Start Date'),
			'end_date' => Yii::t('app', 'End Date'),
			'post_type' => Yii::t('app', 'Post Type'),
			'cost' => Yii::t('app', 'Cost'),
			'is_paid' => Yii::t('app', 'Is Paid'),
			'is_delete' => Yii::t('app', 'Is Delete'),
			'user' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('postexchange_id', $this->postexchange_id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('campaign_id', $this->campaign_id);
		$criteria->compare('user_type', $this->user_type);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('start_date', $this->start_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('post_type', $this->post_type, true);
		$criteria->compare('cost', $this->cost);
		$criteria->compare('is_paid', $this->is_paid);
		$criteria->compare('is_delete', $this->is_delete);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}