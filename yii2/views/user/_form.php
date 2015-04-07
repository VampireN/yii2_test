<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Personaldata */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="personaldata-form">
 
    <?php $form = ActiveForm::begin([
    'id' => 'update-form',
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
	
    <?= $model->avatar_image(Html::encode($model->username),Html::encode($model->photo),'130','130','small_img left');?>
	
    <?= $form->field($model, 'username')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => 70]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => 255]) ?>
	
	<?=$form->field($model, 'avatar')->fileInput(['multiple'=>'multiple']);?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

