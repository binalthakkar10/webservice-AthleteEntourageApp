<?php

class TransactionController extends AdminCoreController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Transaction'),
		));
	}

	public function actionCreate() {
		$model = new Transaction;


		if (isset($_POST['Transaction'])) {
			$model->setAttributes($_POST['Transaction']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->transaction_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Transaction');


		if (isset($_POST['Transaction'])) {
			$model->setAttributes($_POST['Transaction']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->transaction_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Transaction')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Transaction');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Transaction('search');
		$model->unsetAttributes();

		if (isset($_GET['Transaction']))
			$model->setAttributes($_GET['Transaction']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}