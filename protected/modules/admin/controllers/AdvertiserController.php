<?php
class AdvertiserController extends AdminCoreController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);

	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function defaultAccessRules()
	{
		return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('admin','update'),
				'users'=>array('admin'),
		),
		);
	}

	public function actionAdmin()
	{
		$model = new Users('search');
		$data=$model->findAll('user_type="advertiser"');
		$arrayDataProvider=new CArrayDataProvider($data, array(
						'pagination'=>array(
						'pageSize'=>10,
		),
		));
		$params =array(
			'arrayDataProvider'=>$arrayDataProvider,
			'model'=>$model,
		);
		$this->render('admin', $params);
	}

	public function actionUpdate($id){
		$model=$this->loadModel($id);
		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', Yii::t("messages","Successfully Updated Records.!"));
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Users::model()->findByPk((int)$id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionsearch() {		 
		 
		 
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('activated', $this->activated);
		$criteria->compare('banned', $this->banned);
		$criteria->compare('ban_reason', $this->ban_reason, true);
		$criteria->compare('last_ip', $this->last_ip, true);
		$criteria->compare('last_login', $this->last_login, true);
		$criteria->compare('created', $this->created, true);
		$criteria->compare('modified', $this->modified, true);
		$criteria->compare('producer', $this->producer);
		$criteria->compare('professional', $this->professional);
		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
		));
	}





}