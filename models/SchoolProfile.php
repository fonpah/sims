<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "school_profiles".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property string $address
 * @property string $post_code
 * @property string $city
 * @property integer $country_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $created_by
 */
class SchoolProfile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school_profiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'address', 'post_code', 'city', 'country_id'], 'required'],
            [['country_id', 'updated_by', 'created_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['short_name', 'city'], 'string', 'max' => 60],
            [['address'], 'string', 'max' => 150],
            [['post_code'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'short_name' => Yii::t('app', 'Short Name'),
            'address' => Yii::t('app', 'Address'),
            'post_code' => Yii::t('app', 'Post Code'),
            'city' => Yii::t('app', 'City'),
            'country_id' => Yii::t('app', 'Country ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }

    public function behaviors(){
        return [
            [
                'class'=> TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                'value' => new Expression('NOW()')
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by','updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by']
                ],
                'value' => function(){
                    return Yii::$app->user->identity->id;
                }
            ]
        ];
    }


    public function getCountry(){
        return $this->hasOne(Country::className(),array('id'=>'country_id'));
    }
}
