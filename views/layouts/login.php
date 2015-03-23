<?php
/**
 * Created by PhpStorm.
 * User: fonpah
 * Date: 23.02.2015
 * Time: 19:41
 */
use app\assets\LoginAsset;
/* @var $this \yii\web\View */
/* @var $content string */

LoginAsset::register($this);
?>
<?php $this->beginContent('@app/views/layouts/base.php')?>
    <div class="wrap">
        <div class="container">

            <?=$content?>

        </div> <!-- /container -->
    </div>
<?php $this->endContent(); ?>