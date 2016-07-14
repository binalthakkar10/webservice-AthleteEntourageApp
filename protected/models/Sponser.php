<?php

Yii::import('application.models._base.BaseSponser');

class Sponser extends BaseSponser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function rules() {
		return array(
			array('username, fb_screen_name,twitter_screen_name, total_twitt, total_retwitt, fb_likes, fb_friends,facebook_followers, twitter_followers, team, position', 'required'),
			array('total_twitt, total_retwitt, fb_likes, fb_friends, facebook_followers, twitter_followers', 'numerical', 'integerOnly'=>true),
			array('username, iphone_image,ipad_image, fb_screen_name, twitter_screen_name, team, position', 'length', 'max'=>100),
			array('ipad_image,iphone_image', 'file', 'types'=>'jpg, gif, png, jpeg'),
			array('sponser_id, username, iphone_image,ipad_image, fb_screen_name, twitter_screen_name, total_twitt, total_retwitt, fb_likes, fb_friends', 'safe', 'on'=>'search'),
		);
	}
	public static function label($n = 1) {
		return Yii::t('app', 'Sponsor|Sponsors', $n);
	}
	
	public function attributeLabels() {
		return array(
			'sponser_id' => Yii::t('app', 'Sponser'),
			'username' => Yii::t('app', 'Username'),
			'iphone_image' => Yii::t('app', 'iPhone Image'),
			'ipad_image' => Yii::t('app', 'iPad Image'),
			'fb_screen_name' => Yii::t('app', 'Facebook Screen Name'),
			'twitter_screen_name' => Yii::t('app', 'Twitter Screen Name'),
			'total_twitt' => Yii::t('app', 'Total Tweet'),
			'total_retwitt' => Yii::t('app', 'Total Retweet'),
			'fb_likes' => Yii::t('app', 'Facebook Likes'),
			'fb_friends' => Yii::t('app', 'Facebook Friends'),
			'flag' => Yii::t('app', 'Flag'),
		);
	}
}