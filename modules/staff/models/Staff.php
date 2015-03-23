<?php

namespace app\modules\staff\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "staffs".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $birthdate
 * @property string $gender
 * @property string $nat_id_nr
 * @property string $avatar
 * @property string $updated_at
 * @property string $created_at
 * @property string $login_time
 * @property string $mobile_phone
 * @property integer $updated_by
 * @property integer $created_by
 * @property integer $type
 * @property integer $status
 */
class Staff extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const TYPE_TEACHING = 1;
    const TYPE_NON_TEACHING = 2;
    const ENCRYPTION_KEY = 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staffs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name','birthdate', 'gender', 'nat_id_nr', 'mobile_phone', 'type'], 'required'],
            [['birthdate', 'updated_at', 'created_at', 'login_time'], 'safe'],
            [['birthdate'],'date','format'=>'php:d-m-Y'],
            [['gender'], 'string'],
            [['updated_by', 'created_by', 'type', 'status'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 60],
            [['username'], 'string', 'max' => 45],
            [['password', 'email', 'nat_id_nr', 'avatar'], 'string', 'max' => 255],
            [['mobile_phone'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'gender' => Yii::t('app', 'Gender'),
            'nat_id_nr' => Yii::t('app', 'National ID Nr.'),
            'avatar' => Yii::t('app', 'Avatar'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'login_time' => Yii::t('app', 'Login Time'),
            'mobile_phone' => Yii::t('app', 'Mobile Phone'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_by' => Yii::t('app', 'Created By'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                'value' => new Expression('NOW()')
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by']
                ],
                'value' => function () {
                    return Yii::$app->user->identity->id;
                }
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function beforeSave($insert){

        $this->username = $this->generateUsername();
        if($insert){
            $this->password = $this->mc_encrypt($this->generatePassword(), self::ENCRYPTION_KEY);
        }
        $this->birthdate = date_create_from_format('d-m-Y',$this->birthdate);
        $this->birthdate = $this->birthdate->format('Y-m-d');
        return parent::beforeSave($insert);
    }

    public function afterFind(){
        if($this->birthdate){
            $this->birthdate = date_create_from_format('Y-m-d', $this->birthdate);
            $this->birthdate = $this->birthdate->format('d-m-Y');
        }

        parent::afterFind();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        throw new NotSupportedException('"findByPasswordResetToken" is not implemented.');
    }

    public function getAuthKey()
    {

    }

    public function validateAuthKey($authKey)
    {

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $pw = $this->mc_decrypt($this->password, self::ENCRYPTION_KEY);
        return $pw === $password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $this->mc_encrypt($password, self::ENCRYPTION_KEY);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function generateUsername(){
        $lname = str_replace('-','',$this->last_name);
        $fname = str_replace('-','',$this->first_name);
        $username = 'sf'.substr($fname,0,2).substr($lname,0,4);
        return strtolower($username);
    }
    public function generatePassword()
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $chars = $alpha . $alpha_upper . $numeric;
        $length = 7;
        $len = strlen($chars);
        $pw = '';

        for ($i = 0; $i < $length; $i++)
        {
            $pw .= substr($chars, rand(0, $len - 1), 1);
        }
        // the finished password
        $pw = str_shuffle($pw);
        return $pw;
    }

    public function mc_encrypt($encrypt, $key){
        $encrypt = serialize($encrypt);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
        return $encoded;
    }

// Decrypt Function
    public function mc_decrypt($decrypt, $key){
        $decrypt = explode('|', $decrypt.'|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if($calcmac!==$mac){ return false; }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    }
}
