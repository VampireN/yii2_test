<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Refuser;
use app\models\User;

/**
 * This is the model class for table "o_personaldata".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $fio
 * @property string $address
 * @property string $photo
 * @property string $password_hash
 * @property string $auth_key
 */
 
class Personaldata extends \yii\db\ActiveRecord
{
    public $verifyCode;
    public $avatar; 
    public $rememberMe = true;
   // private $_identity;
   // public $errorCode;
    private $_user = false;

    /**
     * @inheritdoc
     */ 
    public static function tableName()
    {
        return 'o_personaldata';
    }
	
    /**
     * @inheritdoc
     */
    public function getOrders()
    {
        return $this->hasMany(Refuser::className(), ['id_ref' => 'id','id_user' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'fio', 'address','verifyCode'], 'required',
			  'message' => 'Необходимо заполнить.',
			  'on' => 'registration',
			],
			[['username', 'email', 'password', 'fio', 'address'], 'required','on' => 'update'],
			[['username', 'password'],'required',
			  'message' => 'Необходимо заполнить.',
			  'on' => 'login'
			],
            [['username', 'address'], 'string','min'=>4, 'max' => 30],
            ['email', 'string','min'=>6,'max' => 50],
			['email', 'email','on'=>'registration'],
            ['password', 'string', 'max' => 32],
			['rememberMe', 'boolean'],
            ['fio', 'string', 'max' => 70],
            ['photo', 'string', 'max' => 255],
            ['username', 'unique','on' => 'registration'],
			['email', 'unique'],
			[['avatar'], 'file',
			 'extensions' => 'jpg,gif,png',
			 'checkExtensionByMimeType' => false,
			 'maxSize'=>1024 * 1024 * 5, // 5 MB
			],
			//['verifyCode', 'captcha'/*,'message' => 'Неверный код.'*/],
			['username', 'match', 'pattern' => '/^[A-Za-z0-9А-Яа-я\s,]+$/u',
			'message' => 'Логин содержит недопустимые символы.'
			],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
             'username' => 'Логин',
             'password'  => 'Пароль',
			 'email'=>'e-mail',
			 'fio'=>'ФИО',
			 'address'=>'Адрес',
			 'avatar' => 'Фото',
			 'rememberMe'=>'Запомнить',
			 'verifyCode'=>'Введите код:',
        ];
    }

    /**
     * Загрузка аватара
     *
     * @param $username
     * @param $photo
     * @param string $width
	 * @param string $height
     * @param string $class
     * @return string
     */
    public function avatar_image($username, $photo, $width, $height, $class)
    {
	
        if ($photo !== "") {
            return Html::img( Url::to('yii2/web/images/users/' . $photo,true), ['alt' => $username,'width'=>$width,'height'=>$height,'class'=>$class]);
        }
        else {
            return Html::img( Url::to('yii2/web/images/pics/noimage.gif',true), ['alt' => 'noimage','width'=>$width,'height'=>$height,'class'=>$class]);
        }
    }
	
	/**
	* Generates password hash from password and sets it to the model
	*
	* @param string $password
	*/
	public function setPassword($password)
	{
	    $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
	}
	
	/**
	* Generates "remember me" authentication key
	*/
	public function generateAuthKey()
	{
	    $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
	}

}
