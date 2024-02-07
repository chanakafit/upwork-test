<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pet".
 *
 * @property int $id
 * @property string $name
 * @property string|null $location
 * @property string|null $imageFile
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UserPet[] $userPets
 * @property User[] $users
 */
class Pet extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'pet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['location', 'imageFile'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 10],
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'location', 'imageFile'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'location' => 'Location',
            'imageFile' => 'Image File',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[UserPets]].
     *
     * @return ActiveQuery
     */
    public function getUserPets(): ActiveQuery
    {
        return $this->hasMany(UserPet::class, ['pet_id' => 'id'])->where(['status' => self::STATUS_ACTIVE]);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('user_pet', ['pet_id' => 'id']);
    }

}
