<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SchoolProfile */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'School Profile',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'School Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
