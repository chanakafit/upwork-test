<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">

        <ul>
            <li><?= \yii\helpers\Html::a('Pet',['pet/index'])?></li>
            <li><?= \yii\helpers\Html::a('User\'s Pet',['user-pet/index'])?></li>
        </ul>

    </div>
</div>
