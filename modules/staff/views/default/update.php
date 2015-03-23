<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\Staff */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Staff',
]) . ' ' . Html::encode($model->username);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="staff-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
