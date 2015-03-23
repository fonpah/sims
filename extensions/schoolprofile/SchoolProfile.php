<?php
/**
 * Created by PhpStorm.
 * User: fonpah
 * Date: 24.02.2015
 * Time: 15:06
 */

namespace app\extensions\schoolprofile;


use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\web\View;

class SchoolProfile implements  BootstrapInterface{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap( $app){
        $app->on(Application::EVENT_BEFORE_ACTION, function() use($app){
            $school = \app\models\SchoolProfile::findOne(array('id'=> $app->params['schoolProfileId']));
            $app->getView()->params['schoolProfile'] = $school;

        });
    }

}