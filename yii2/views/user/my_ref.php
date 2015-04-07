<?php
use yii\helpers\Html;
use app\models\Personaldata;

/* @var $this UserController */

$this->title = 'Мои рефералы';
$this->params['breadcrumbs'][] = ['label' => 'Моя страница', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
$i=0;
?>
<div class="form">
   <?php foreach($ref_user as $ref): ?>
        <br/>
        <?php 
		$i=$i+1;
		echo $i.".";
		$user = Personaldata::findOne($ref->id_user);
		?>
		<div class="avatar">
			 <?php echo $user->avatar_image(Html::encode($user->username),Html::encode($user->photo),'130','130','small_img left');?>
			 <br/>
			 Кол-во рефалов:<?php echo Html::encode($ref->number) ?>
			 <br/>
			 Логин: <?php echo Html::a(Html::encode($user->username),array('user/view','id'=>$user->id)); ?>
			 <br/>
			 E-mail: <?php echo Html::encode($user->email); ?>
			 <br/>
		 </div>
    <?php endforeach; ?>
</div>