<?php
Yii::import('application.models.AdminUser.*');
class AdminUserController extends AdminCoreController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 * @return array action filters
	 */
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
				'actions'=>array('view'),
				'users'=>array('admin'),
		),
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete','change'),
				'users'=>array('admin'),
		),

		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	/*public function actionView($id)
	 {
		$this->render('view',array(
		'model'=>$this->loadModel($id),
		));
		}*/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionCreate() {
		$this->pageTitle = "Create Users || Lets Go Out";
		$model = new Users();
	
		if (isset($_POST['Users'])) {

			//$_POST['AdminUser']['created_at']	=	date("Y-m-d H:i:s");

			if(isset($_POST['Users']['password'])){
				$adminUserObj=new Users();
				$MD5Pwd=$adminUserObj->makeMD5Password($_POST['Users']['password']);
				$_POST['Users']['password']	=	$MD5Pwd;

			}

			$model->setAttributes($_POST['Users']);
			$model->firstname=$_POST['Users']['firstname'];
			$model->lastname=$_POST['Users']['lastname'];
			
			/*if($_POST['Users']['email']!='')
			{
				$Obj = $model->findByAttributes(array('email'=>$_POST['Users']['email']));
				if(isset($Obj->attributes))
				{
					$model->attributes=$_POST['Users'];
					Yii::app()->admin->setFlash('error', Yii::t("messages","There is already an account with this email address, please try again.!"));
					$this->render('create',array('model'=>$model,));
					Yii::app()->end();
				}
			}*/

			if($_POST['Users']['username']!='')
			{
				$Obj = $model->findByAttributes(array('username'=>$_POST['Users']['username']));

				if(isset($Obj->attributes))
				{
					$model->attributes=$_POST['Users'];
					Yii::app()->admin->setFlash('error', Yii::t("messages","There is already an account with this User Name, please try again.!"));
					$this->render('create',array('model'=>$model,));
					Yii::app()->end();
				}
			}
			
			if($model->save()){
				Yii::app()->admin->setFlash('success', Yii::t("messages","Thank you for succesfully your registration.!"));
				$this->redirect(array('admin'));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->pageTitle = "Upadte Users || Lets Go Out";
		$model = $this->loadModel($id, 'Users');
		if (isset($_POST['Users']))
		{
			/*if(isset($model->created_at))
			 {

				$createdAt=$model->created_at;
				$dateArr=explode("-",$createdAt);

				$y=$dateArr['2'];
				$m=$dateArr['1'];
				$d=$dateArr['0'];
				$cDate=$m."-".$d."-".$y;
				$_POST['Users']['created_at']	=	date("Y-m-d ",strtotime($cDate));
				}*/

			$_POST['Users']['updated_at']	=	date("Y-m-d H:i:s");
			$model->setAttributes($_POST['Users']);
			if(isset($_POST['Users']['user_type']) && !empty($_POST['Users']['user_type'])){
				$model->user_type=$_POST['Users']['user_type'];
			}
			$model->updated_at=$_POST['Users']['updated_at'];
			//$model->extra=$_POST['Users']['extra'];

			if ($model->save(false)) {
				Yii::app()->admin->setFlash('success', Yii::t("messages","Successfully Updated Records.!"));
				$this->redirect(array('admin'));
			}
		}
		$this->render('update', array(
				'model' => $model,
		));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			
			if($id!='1'){
				$this->loadModel($id, 'AdminUsers')->delete();
			}
			if (!Yii::app()->getRequest()->getIsAjaxRequest())
			Yii::app()->admin->setFlash('success', Yii::t("messages","succesfully delete record!"));
			$this->redirect(array('admin'));
		} else
		throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
	/**
	 * Lists all models.
	 */
	/*public function actionIndex()
	 {
		$dataProvider=new CActiveDataProvider('AdminUser');
		$this->render('index',array(
		'dataProvider'=>$dataProvider,
		));
		}*/

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->pageTitle = "Manage Users || Lets Go Out";
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
		$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionSetting()
	{
		$this->pageTitle = "Manage Settings || Lets Go Out";
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
		$model->attributes=$_GET['Users'];

		$this->render('settingadmin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk((int)$id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionChange($id)
	{	
		$this->pageTitle = "Change Password || Lets Go Out";	
		$model = $this->loadModel($id, 'Users');
		$modelForm=new ChangePasswordForm();
		if (isset($_POST['ChangePasswordForm']))
		{
			$modelForm->setAttributes($_POST['ChangePasswordForm']);
			$modelData1 = Users::model()->find("password = '".md5($_POST['ChangePasswordForm']['oldpassword'])."'");
			if($modelData1){
				$modelForm->oldpassword = $_POST['ChangePasswordForm']['oldpassword'];
				$modelForm->password = $_POST['ChangePasswordForm']['password'];
				$modelForm->password_repeat = $_POST['ChangePasswordForm']['password_repeat'];
				if($modelForm->validate()){
					$model->password=md5($_POST['ChangePasswordForm']['password_repeat']);
					if ($model->save(false)) {
						Yii::app()->admin->setFlash('success', Yii::t("messages","Password change successfully!"));
						$this->redirect(array('Setting','id'=>$id));
					}
				}else{
					$this->render('change',array(
							'model'=>$modelForm,
					));
					Yii::app()->end();
				}
			}else{
				Yii::app()->admin->setFlash('error', Yii::t("messages","The Old Password does not match.!"));
				$this->render('change',array('model'=>$modelForm));
				Yii::app()->end();
			}
		}
		$this->render('change',array('model'=>$modelForm));
	}
	public function actionRandomcode(){
		$randomNo = Users::randomNumberGenerate();
		echo $randomNo;
		yii::app()->end();	
	}
}