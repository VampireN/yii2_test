<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Refuser */

$this->title = 'Create Refuser';
$this->params['breadcrumbs'][] = ['label' => 'Refusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
