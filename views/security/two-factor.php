<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Two-factor authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>

                <?= Yii::t(
                    'user',
                    'Enter code from the {0} or recovery code',
                    [
                        Html::a(
                            Yii::t('user', 'tfa_application'),
                            Yii::t('user', 'tfa_application_link'),
                            [
                                'target' => '_blank',
                            ]
                        )
                    ]
                ) ?>
                <?= $form->field($model, 'code',
                    [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1',
                            'placeholder' => $model->getAttributeLabel('code'),
                        ],
                    ]
                )->label(false);
                ?>

                <?= Html::submitButton(
                    Yii::t('user', 'Sign in'),
                    ['class' => 'btn btn-primary btn-block', 'tabindex' => '4']
                ) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
