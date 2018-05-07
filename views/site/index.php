<?php

/* @var $this yii\web\View */

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
                    <h3><?=$item->title?></h3>
                    <?=$item->text?>
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
