<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm  */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>Регистрация</h1>
<div class="form">
	<?php
	$form = ActiveForm::begin([
    'id' => 'upload-form',
    'options' => [
	        'class' => 'form-horizontal',
			'enctype'=>'multipart/form-data'
			],
	'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
     ]) 
	 ?>
    <div class="row">
		<?= $form->field($model,'username'); ?>
	</div>

	<div class="row">
		<?= $form->field($model, 'password')->passwordInput(); ?>
	</div>
	
	<div class="row">
		<?= $form->field($model,'fio'); ?>
	</div>

	<div class="row">
		<?= $form->field($model,'address'); ?>
	</div>
	
	<div class="row">
		<?= $form->field($model,'email'); ?>
	</div>
	
	<div class="row">
	<?php echo $form->field($model, 'avatar')->fileInput(['multiple'=>'multiple']);?>
	</div>

        
	<br />
	<div class="row">
	 <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
	
    </div>
        

    <div class="row buttons"> 
	<?= Html::submitButton('Регистрация',['class' => 'btn btn-primary'])?>
	</div>

    <?php ActiveForm::end(); ?>
</div><!-- form -->
