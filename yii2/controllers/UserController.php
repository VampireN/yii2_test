<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Personaldata;
use app\models\User;
use app\models\Refuser;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class UserController extends \yii\web\Controller
{
   
   /**
     *
     */
    public function actionIndex()
    {
        $users = Personaldata::find()->all();
        return $this->render('users_list', array('users' => $users));
    }
	
	
    /**
      * Вывод Топ-листа рефералов
      */
    public function actionTop()
    {
        $ref_user = Refuser::find()
	               ->where( 'number>0')
	               ->orderBy('number DESC')
	               ->all();
         
        return $this->render('top_list', array('ref_user' => $ref_user));
    }
	
	
    /**
      * @return array
      */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
      * Вход на сайт
      */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
           return $this->goHome();
        }
	   
        $model = new LoginForm();

        if (Yii::$app->request->isAjax) {
	    $model->load($_POST);
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    return ActiveForm::validate($model);
        }
		
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
	    return $this->goBack();
        } 
        else {
	     return $this->render('login', ['model' => $model]);
        }
    }


    /**
      * Выход
      */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();

    }


    /**
     * Отображение модели с данным id
     *
     * @param $id
     * @throws HttpException
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->loadModel($id)]);
    }


    /**
     * Загрузка данных модели с полученным id
     *
     * @param $id
     * @return ActiveRecord
     * @throws NotFoundHttpException
     */
    public function loadModel($id)
    {
        if (($model = Personaldata::findOne($id)) !== null) {
            return $model;
        } 
        else {
             throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Вывод всех рефералов пользователя с полученным id
     *
     * @param $id
     */
    public function actionMy_ref($id)
    {

        $ref_user = Refuser::find()
		   ->where(['id_ref'=>$id])
		   ->orderBy('number DESC')
	           ->all();

        return  $this->render('my_ref', array('ref_user' => $ref_user));
    }


    /**
     * Моя страница
     */
    public function actionMy()
    {
        $name = Yii::$app->user->identity->username;
        $users = Personaldata::findOne(['username' => $name]);

        return $this->render('my', ['users' => $users]);
    }


    /**
     * Редактирование
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->scenario = 'update';
		
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-form') {
            echo ActiveForm::validate($model);
            Yii::app()->end();
        }
		
        if ($model->load(Yii::$app->request->post()) ) {
	    $model->avatar = UploadedFile::getInstance($model, 'avatar');

            if ($model->avatar) {
                $sourcePath = pathinfo($model->avatar->name); 
                $fileName = date('m-d') . '-' . md5($model->username) . '.' . $sourcePath['extension'];
                $model->photo = $fileName;
                $file = Yii::$app->basePath . '/web/images/users/' . $fileName;
	        $model->avatar->saveAs($file);
	     }
				 
            $model->setPassword($model->password);
            $model->generateAuthKey();
              
            if ($model->save()) {
                $this->redirect(array('my'));
            }
        }

        return $this->render('update', ['model' => $model]);

    }


    /**
     * Удаление страницы
     */
    public function actionDelete($id)
    {
        $ref_user = Refuser::find()
                   ->where(['id_user' =>$id])
		   ->one();

        // Если у пользователя есть выше стоящий реферал ищем его данные в бд
        if ($ref_user->id_ref != 0) {
            $my_ref = Refuser::find()
			         ->where(['id_user' =>$ref_user->id_ref])
			         ->one();

            $my_ref->number--;
            $my_ref->save();
        }

        $ref_user->delete();

        //Ищем всех рефералов пользователя
        $users = Refuser::find()
		        ->where(['id_ref' =>$id])
		        ->all();

        //Если они есть, то прописываем 0 вместо id пользователя
        if ($users != null) {
            foreach ($users as $one) {
                $one->id_ref = 0;
                $one->save();
            }
        }

        $this->loadModel($id)->delete();

        Yii::$app->user->logout();
        return $this->goHome();
    }


    /**
     * Регистрация
     */
    public function actionRegistration()
    {
        $model = new Personaldata();
        $model_ref = new Refuser();

        $model->scenario = 'registration';

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'upload-form') {
            echo ActiveForm::validate($model);
            Yii::app()->end();
        }

        if (!\Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app()->homeUrl);
        }
        else {
	       if (isset($_GET['ref'])) {
		   $ref = $_GET['ref'];
                   $model_ref->id_ref =(int)$ref;
                }
                else {
	              $ref = 0;
	        }
			  
                if (isset($_POST['Personaldata'])) {
                    $model->attributes = $_POST['Personaldata'];
                    $model->verifyCode = $_POST['Personaldata']['verifyCode'];
				  
                  if ($model->validate()) {
				
                      $model->avatar = UploadedFile::getInstance($model, 'avatar');

                      if ($model->avatar) {
                          $sourcePath = pathinfo($model->avatar->name);
                          $fileName = date('m-d') . '-' . md5($model->username) . '.' . $sourcePath['extension'];
                          $model->photo = $fileName;
                          $file = Yii::$app->basePath . '/web/images/users/' . $fileName;

                          $model->avatar->saveAs($file);
                      }
					  
		      $sms = $model->username;
                      $model->setPassword($model->password);
		      $model->generateAuthKey();
                      $model->save(false);
					
                      $model_ref->id_user = $model->id;
                      $model_ref->number = 0;
                      $model_ref->save();
                     
                      if ($ref !== 0 && $ref !== null) {
                          $ref_user = Refuser::findOne(['id_user' => $ref]);

                          if ($ref_user !== null) {
			      $num = $ref_user->number;
                              $ref_user->number = $num + 1 ;
                              $ref_user->save();
                          }
                      }
					
                      return $this->render('registration_ok', ['sms' => $sms]);
                 
                 }
                 else {
                      return $this->render('registration', ['model' => $model]);
                 }
              }
              else {
                return $this->render('registration', ['model' => $model]);
              }
        }
    }

}
