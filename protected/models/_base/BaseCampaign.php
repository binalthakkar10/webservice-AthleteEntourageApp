<?php

/**
 * This is the model base class for the table "campaign".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Campaign".
 *
 * Columns in table "campaign" available as properties of the model,
 * followed by relations of table "campaign" available as properties of the model.
 *
 * @property integer $user_id
 * @property integer $campaign_id
 * @property string $compaign_message
 * @property integer $post_to_exchange
 * @property string $created_date
 * @property double $total_cost
 * @property integer $is_campaign
 * @property string $package_name
 * @property integer $package_followers
 * @property double $followers_bal
 * @property integer $is_close
 * @property integer $is_paid
 * @property integer $is_delete
 *
 * @property UserDetail $user
 * @property CampaignPartner[] $campaignPartners
 * @property Ratings[] $ratings
 * @property SocialPosts[] $socialPosts
 */
abstract class BaseCampaign extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'campaign';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Campaign|Campaigns', $n);
	}

	public static function representingColumn() {
		return 'compaign_message';
	}

	public function rules() {
		return array(
			array('user_id, compaign_message, is_campaign, package_name, package_followers, followers_bal', 'required'),
			array('user_id, post_to_exchange, is_campaign, package_followers, is_close, is_paid, is_delete', 'numerical', 'integerOnly'=>true),
			array('total_cost, followers_bal', 'numerical'),
			array('compaign_message', 'length', 'max'=>5000),
			array('package_name', 'length', 'max'=>255),
			array('created_date', 'safe'),
			array('post_to_exchange, created_date, total_cost, is_close, is_paid, is_delete', 'default', 'setOnEmpty' => true, 'value' => null),
			array('user_id, campaign_id, compaign_message, post_to_exchange, created_date, total_cost, is_campaign, package_name, package_followers, followers_bal, is_close, is_paid, is_delete', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'UserDetail', 'user_id'),
			'campaignPartners' => array(self::HAS_MANY, 'CampaignPartner', 'campaign_id'),
			'ratings' => array(self::HAS_MANY, 'Ratings', 'campaign_id'),
			'socialPosts' => array(self::HAS_MANY, 'SocialPosts', 'campaign_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'user_id' => null,
			'campaign_id' => Yii::t('app', 'Campaign'),
			'compaign_message' => Yii::t('app', 'Compaign Message'),
			'post_to_exchange' => Yii::t('app', 'Post To Exchange'),
			'created_date' => Yii::t('app', 'Created Date'),
			'total_cost' => Yii::t('app', 'Total Cost'),
			'is_campaign' => Yii::t('app', 'Is Campaign'),
			'package_name' => Yii::t('app', 'Package Name'),
			'package_followers' => Yii::t('app', 'Package Followers'),
			'followers_bal' => Yii::t('app', 'Followers Bal'),
			'is_close' => Yii::t('app', 'Is Close'),
			'is_paid' => Yii::t('app', 'Is Paid'),
			'is_delete' => Yii::t('app', 'Is Delete'),
			'user' => null,
			'campaignPartners' => null,
			'ratings' => null,
			'socialPosts' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('campaign_id', $this->campaign_id);
		$criteria->compare('compaign_message', $this->compaign_message, true);
		$criteria->compare('post_to_exchange', $this->post_to_exchange);
		$criteria->compare('created_date', $this->created_date, true);
		$criteria->compare('total_cost', $this->total_cost);
		$criteria->compare('is_campaign', $this->is_campaign);
		$criteria->compare('package_name', $this->package_name, true);
		$criteria->compare('package_followers', $this->package_followers);
		$criteria->compare('followers_bal', $this->followers_bal);
		$criteria->compare('is_close', $this->is_close);
		$criteria->compare('is_paid', $this->is_paid);
		$criteria->compare('is_delete', $this->is_delete);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}