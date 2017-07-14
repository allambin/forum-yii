<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\widgets\LinkPager;
use app\modules\forum\components\ThreadSortingByViews;
use app\modules\forum\components\ThreadSortingByDate;
use app\modules\forum\helpers\ThreadSorting;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\forum\models\ThreadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Threads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="thread-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Thread'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        Sort by:
        <?php
            $allowedSortings = [
                new ThreadSortingByViews,
                new ThreadSortingByDate,
            ];
            $threadSorting = new ThreadSorting();
            echo $threadSorting->renderSortingButtons($sort, $direction, $allowedSortings);
        ?>
    </p>

    <div class="thread-list">
    <?php foreach ($models as $model) : ?>
        <?php $user = User::findIdentity($model->author); ?>
        <div class="thread-list-item">
            <div class="thread-list-item-title"><?= Html::a(Yii::t('app', Html::encode($model->title)), ['view', 'id' => $model->id]); ?></div>
            <div class="color-text-lightest in-caps">
                <?= Yii::t('app', 'Published at {date} by <span class="accent">{username}</span>', [
                    'date' => $model->creation_date,
                    'username' => $user->username
                ]) ?>
            </div>
            <div class="thread-list-item-replies-count color-text-lightest pull-right">
                <?= Yii::t('app', '{count,plural,=0{no reply} =1{1 reply} other{# replies}}', ['count' => $model->repliesCount]) ?> | 
                <?= Yii::t('app', '{count,plural,=0{no view} =1{1 view} other{# views}}', ['count' => $model->views]) ?>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>

</div>
