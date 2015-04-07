<?php
use yii\helpers\Html;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $model app\models\Personaldata */

$this->title = 'Редактировать';
$this->params['breadcrumbs'][] = ['label' => 'Моя страница', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;

echo  Menu::widget([
      'items' => [
	   ['label' => 'Все пользователи', 'url' => ['index']],
	   ['label' => 'Моя страница', 'url' => ['my']]
	  ],
]);
?>

<div class="personaldata-update">

    <h1>Редактировать данные <?= Html::encode($model->username) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>