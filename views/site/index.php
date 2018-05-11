<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$this->title = 'Board';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?if(count($ads)):?>
                <h2>Last ads:</h2>
            <?else:?>
                <h2>No ads</h2>
            <?endif;?>

            <?foreach($ads as $item): ?>
                <div class="col-md-4">
                    <h3><?=Html::encode($item->title)?></h3>
                    <?=HtmlPurifier::process($item->text)?>
                </div>
            <?endforeach;?>

            <div class="clearfix"></div>

            <?php
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
            ]);
            ?>
        </div>

    </div>
</div>
