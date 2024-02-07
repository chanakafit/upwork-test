<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pet $model */

$this->title = 'Create Pet';
$this->params['breadcrumbs'][] = ['label' => 'Pets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
