<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this UserController */

$this->title = 'Моя страница';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['/user']];
$this->params['breadcrumbs'][] = $this->title;

?>
<ul>
 <li><?= Html::a('Все пользователи', ['index']) ?></li>
 <li><?= Html::a('Редактирование данных',['update', 'id'=>$users->id]) ?></li>
 <li><?= Html::a('Мои рефералы',['my_ref', 'id'=>$users->id]) ?></li>
 <li><?= Html::a('Удалить страницу', ['delete', 'id' => $users->id], [
            //'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить страницу?',
                'method' => 'post',
            ],
      ]) ?> </li>
</ul>
<h1><?php echo $users->username;?></h1>

<div class="avatar">
     <?php echo $users->avatar_image(Html::encode($users->username),Html::encode($users->photo),'130','130','small_img left');?>

     <?= DetailView::widget([
        'model' => $users,
        'attributes' => [
            'username',
            'email:email',
            'fio',
            'address',
            'photo',
        ],
    ]) ?>

</div>