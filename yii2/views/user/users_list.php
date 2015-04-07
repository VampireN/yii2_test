<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
 
/* @var $this UserController */

$this->title = 'Зарегистрированные пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form">
     <?php foreach($users as $user): ?>
     <div class="avatar">
          <?php echo $user->avatar_image(Html::encode($user->username),Html::encode($user->photo),'130','130','avatar_img');?>
          Логин: <?php echo Html::a(Html::encode($user->username),array('user/view','id'=>$user->id)); ?>
		  <br/>
		  E-mail: <?php echo Html::encode($user->email); ?>
		  <br/>
     </div>
     <?php endforeach; ?>
	 <?php 
	   if(Yii::$app->user->isGuest){
	      echo Html::a('Зарегестрироваться', array('user/registration'));
		}
	  ?>
</div>