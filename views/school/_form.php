<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Country;

/* @var $this yii\web\View */
/* @var $model app\models\SchoolProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="school-profile-form">

    <?php $form = ActiveForm::begin([
        'id'=> 'school-profile-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input} {error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'post_code')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 60]) ?>

    <?php
       $countries = ArrayHelper::map(Country::find()->all(),'id','name');
        echo $form->field($model, 'country_id')->dropDownList($countries,['id'=>'title']);
    ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-4 text-right">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
