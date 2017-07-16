<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Thread */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Threads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thread-view">

    <div class="thread">
        <div class="thread-question">
            <h1 class="thread-question-title"><?= Html::encode($this->title) ?></h1>
            <p class="color-text-lightest in-caps"><?= Yii::t('app', 'Published at {date} by <span class="accent">{username}</span>', [
                'date' => $model->creation_date,
                'username' => $model->user->username
            ]) ?></p>
            <div class="thread-question-body"><?= $model->content; ?></div>
            <?php
            echo \chiliec\vote\widgets\Vote::widget([
                'model' => $model,
                'showAggregateRating' => false,
            ]);
            ?>
        </div>
        <?php foreach($model->posts as $post): ?>
        <div class="thread-reply">
            <div class="thread-reply-title color-text-lightest">
                <?= Yii::t('app', '<span class="accent">{username}</span> - {date}', [
                    'date' => $post->creation_date,
                    'username' => $post->user->username
                ]) ?>
            </div>
            <div><?= $post->content; ?></div>
            <?php
            echo \chiliec\vote\widgets\Vote::widget([
                'model' => $post,
                'showAggregateRating' => false,
            ]);
            ?>
        </div>
        <?php endforeach; ?>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Reply'), ['post/create', 'thread_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
