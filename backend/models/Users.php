<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\caching\TagDependency;

/**
 * This is the model class for table "users".
 *
 * @property int $ID
 * @property string $ACTIVE
 * @property string $NAME
 * @property string $LAST_NAME
 * @property string $EMAIL
 * @property string $XML_ID
 * @property string $PERSONAL_GENDER
 * @property string $PERSONAL_BIRTHDAY
 * @property string $WORK_POSITION
 * @property string $Region
 * @property string $City
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ACTIVE', 'NAME', 'LAST_NAME', 'EMAIL', 'XML_ID', 'PERSONAL_GENDER'], 'required'],
            [['PERSONAL_BIRTHDAY'], 'safe'], // TODO: на валидатор тоже нет времени
            [['ACTIVE'], 'string', 'max' => 1],
            [['NAME', 'LAST_NAME', 'EMAIL', 'XML_ID', 'PERSONAL_GENDER', 'WORK_POSITION', 'Region', 'City'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ACTIVE' => 'Active',
            'NAME' => 'Name',
            'LAST_NAME' => 'Last Name',
            'EMAIL' => 'Email',
            'XML_ID' => 'Xml ID',
            'PERSONAL_GENDER' => 'Personal Gender',
            'PERSONAL_BIRTHDAY' => 'Personal Birthday',
            'WORK_POSITION' => 'Work Position',
            'Region' => 'Region',
            'City' => 'City',
        ];
    }

    public function getLiverCount(): int
    {
        // TODO: нет таблицы с городами, поэтому пока делаем так
        return Yii::$app->cache->getOrSet($this->City, function(){
            return (new Query())
                ->select('COUNT(*) as liver_count')
                ->from('users')
                ->where(['city' => $this->City])
                ->scalar();
        }, new TagDependency(['tags' => 'users_city']));
    }
}
