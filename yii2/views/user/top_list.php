<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Personaldata;
use yii\db\Query; 

/* @var $this UserController */


$this->title = 'Зарегистрированные пользователи';
$this->params['breadcrumbs'][] = $this->title;

$i = 0;
$sum = 0;
$sum = (new Query())
      ->from('o_refuser')
      ->select('SUM(number)')
	  ->all();

?>

<div class="form">
     Всего рефералов:<?php echo $sum[0]['SUM(number)']; ?>
     <br/>
     <?php foreach($ref_user as $ref): ?>
		 <?php 
	     $i=$i+1;
		 echo $i . ".";
		 $user = Personaldata::findOne($ref->id_user);
		 ?>
         <div class="avatar">
             <?php echo $user->avatar_image(Html::encode($user->username),Html::encode($user->photo),'130','130','small_img left');?>
			 <br/>
			 Кол-во рефералов:<?php echo Html::encode($ref->number) ?>
			 <br/>
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