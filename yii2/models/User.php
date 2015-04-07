<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

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
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
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
	public function behaviors()
	{
        return [ TimestampBehavior::className()];
	}
	
	/**
	* @inheritdoc
	*/
	public function rules()
	{
	return [
	    [['username', 'email'], 'unique'],
	];
	}

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
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
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
	    $user = Personaldata::find()
			   ->andWhere(['or',['username' => $username],['email' => $username]])
			   ->one();
			   
	    return new static($user);
    }
     
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
	    return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
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
