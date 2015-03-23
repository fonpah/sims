<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\staff\models\Staff;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\staff\models\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin([
        'id' => 'staff-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input} {error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 60, 'required' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 60, 'required' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255, 'required' => true]) ?>

    <?= $form->field($model, 'birthdate')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter birth date ...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>

    <?= $form->field($model, 'gender')->dropDownList(['m' => Yii::t('app', 'Male'), 'f' => Yii::t('app', 'Female'),], ['prompt' => Yii::t('app', '--Select--')]) ?>

    <?= $form->field($model, 'nat_id_nr')->textInput(['maxlength' => 255, 'required' => true]) ?>

    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => 30, 'required' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([Staff::TYPE_TEACHING => Yii::t('app', 'Teaching Staff'), Staff::TYPE_NON_TEACHING => Yii::t('app', 'Non Teaching Staff')], ['prompt' => Yii::t('app', '--Select--')]) ?>

    <?= $form->field($model, 'status')->dropDownList([Staff::STATUS_ACTIVE => Yii::t('app', 'Active'), Staff::STATUS_INACTIVE => Yii::t('app', 'Inactive')], ['prompt' => Yii::t('app', '--Select--')]) ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-4 text-right">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
