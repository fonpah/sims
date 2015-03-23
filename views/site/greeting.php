<?php

use yii\helpers\Html;

$this->title = \Yii::t('app', 'Today\'s Headlines');
$this->params['breadcrumbs'][] = $this->title;
?>
    <h2><?= Yii::t('app', 'Hello ') . Html::encode(\Yii::$app->user->identity->getFullName()) ?></h2>

    <h3><?= Yii::t('app', 'Today\'s News') ?></h3>
    <hr/>
    <blockquote>
        <p id="news-box" class="text-muted">
            <?= Yii::t('app', 'loading today\'s news ...') ?>
        </p>
    </blockquote>


<?php
$script = <<< JS
jQuery(document).ready(function(){
   function randomFromTo(from, to){
    return Math.floor(Math.random()*(to -from + 1)+ from);
   }
    function showNews(data){
        var len = data.length;
        var index = randomFromTo(0, len);
         if(data[index]){
          $('#news-box').html(data[index]);
         }
    }
    $.ajax({
      url:'/site/news',
      success:function(json){
        if(!json){
          $('#news-box').html('No News Found');
         return;
        }
        if(json.success == false){
            $('#news-box').html(json.message);
          return;
        }
        showNews(json.data);
        setInterval(function(){
             showNews(json.data);
        },10000)

      }
    });
});
JS;

$this->registerJs($script, \yii\web\View::POS_END);