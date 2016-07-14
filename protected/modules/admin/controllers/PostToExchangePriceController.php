<?php

class PostToExchangePriceController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'PostToExchangePrice'),
		));
	}

	public function actionCreate() {
		$model = new PostToExchangePrice;


		if (isset($_POST['PostToExchangePrice'])) {
			$model->setAttributes($_POST['PostToExchangePrice']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->price_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'PostToExchangePrice');


		if (isset($_POST['PostToExchangePrice'])) {
			$model->setAttributes($_POST['PostToExchangePrice']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->price_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'PostToExchangePrice')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('PostToExchangePrice');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new PostToExchangePrice('search');
		$model->unsetAttributes();

		if (isset($_GET['PostToExchangePrice']))
			$model->setAttributes($_GET['PostToExchangePrice']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}