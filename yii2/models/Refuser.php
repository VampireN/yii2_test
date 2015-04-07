<?php

namespace app\models;
use app\models\Personaldata;
use Yii;

/**
 * This is the model class for table "o_refuser".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_ref
 * @property integer $number
 */
class Refuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o_refuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_ref', 'number'], 'required'],
            [['id_user', 'id_ref', 'number'], 'integer']
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_ref' => 'Id Ref',
            'number' => 'Number',
        ];
    }
}
