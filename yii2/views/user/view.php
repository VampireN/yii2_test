<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;

/* @var $this UserController */
/* @var $model User*/

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Зарегистрированные пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>Данные пользователя <?php echo Html::encode($model->username); ?></h1>
<div class="personaldata-view">
<div class="avatar">
     <?php echo $model->avatar_image(Html::encode($model->username),Html::encode($model->photo),'130','130','small_img left');?>
	 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            'fio',
            'address',
            'photo',
        ],
    ]) ?>
	 
      <?php 
       if(Yii::$app->user->isGuest){
          echo Html::a('Зарегестрироваться', array('user/registration','ref' => $model->id));
       }
	  ?>
</div>
</div>