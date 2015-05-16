<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Tree;
use yii\bootstrap\Tabs;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Url;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model star\catalog\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data']
    ]);

    $fieldGroups = [];
    $fields = [];
    $fields[] = $form->field($model, 'title')->textInput(['maxlength' => 255]);
    $fields[] = $form->field($model, 'price')->textInput(['maxlength' => 255]);
    $fields[] = $form->field($model, 'currency')->dropDownList(['Chinese']);
    $fields[] = $form->field($model, 'language')->dropDownList(['Chinese']);
    $fieldGroups[] = ['label' => Yii::t('catalog','Base Info'), 'content' => implode('', $fields)];

    $fields = [];
    $fields[] = $form->field($model, 'desc')->widget(CKEditor::className(), ['editorOptions' => ['filebrowserBrowseUrl' => Url::to(['elfinder/manager'])]]);
    $fieldGroups[] = ['label' => Yii::t('catalog','Detailed Info'), 'content' => implode('', $fields)];

    $fields = [];
    $fields[] = $form->field($model, 'shipping_fee')->textInput(['maxlength' => 255]);
    $fields[] = $form->field($model, 'is_show')->radioList(['Yes','No']);
    $fields[] = $form->field($model, 'is_promote')->radioList(['Yes','No']);
    $fields[] = $form->field($model, 'is_new')->radioList(['Yes','No']);
    $fields[] = $form->field($model, 'is_hot')->radioList(['Yes','No']);
    $fields[] = $form->field($model, 'is_best')->radioList(['Yes','No']);

    $fieldGroups[] = ['label' => Yii::t('catalog','Other Info'), 'content' => implode('', $fields)];

    $fields = [];
    $fields[] = $form->field($model, 'outer_id')->textInput(['maxlength' => 255]);

    $fieldGroups[] = ['label' => Yii::t('catalog','Product Info'), 'content' => implode('', $fields)];

    $fields = [];
    if($model->isNewRecord){
        $fields[] = $form->field($model, 'images[]')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'multiple'=>true],
            'pluginOptions' => [
                'allowedFileExtensions'=>['jpg','gif','png']
            ]
        ]);
    }else{
        $fields[] = $form->field($model, 'images[]')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*', 'multiple'=>true],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/catalog/core/item/upload-image']),
                'uploadExtraData' => [
                    'album_id' => 20,
                    'cat_id' => 'Nature'
                ],
                'maxFileCount' => 10,
                'allowedFileExtensions'=>['jpg','gif','png']
            ]
        ]);
    }
    $fieldGroups[] = ['label' => Yii::t('catalog','Product Image'), 'content' => implode('', $fields)];
    echo Tabs::widget(['items' => $fieldGroups]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>