<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use mihaildev\elfinder\ElFinder;
use mihaildev\ckeditor\CKEditor;

$this->title = 'Add your advertisement';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add">
    <h1><?= Html::encode($this->title)?></h1>

    <?php $form = ActiveForm::begin([]); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxLength'=>true]) ?>

    <?php echo $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions([
            'elfinder',
        ],[]),
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
