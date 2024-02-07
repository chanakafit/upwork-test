<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\Exception;

/**
 * This is the model class for table "user_pet".
 *
 * @property int $user_id
 * @property int $pet_id
 *
 * @property Pet $pet
 * @property User $user
 */
class UserPet extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user_pet';
    }

    /**
     * @throws \Exception
     */
    public static function addPets($selectedOptions)
    {
        $userId = Yii::$app->user->identity->id;
        self::addPetsByUser($userId, $selectedOptions);
    }

    /**
     * @throws Exception
     */
    public static function addPetsByUser($userId, $selectedOptions)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            UserPet::deleteAll(['user_id' => Yii::$app->user->identity->id]);
            foreach ($selectedOptions as $petId) {
                $userPet = new UserPet();
                $userPet->user_id = $userId;
                $userPet->pet_id = $petId;
                if (!$userPet->save()) {
                    //log error and continue adding
                    Yii::error("Error saving user pet: " . json_encode($userPet->getErrors()));
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'pet_id'], 'required'],
            [['user_id', 'pet_id'], 'integer'],
            [['user_id', 'pet_id'], 'unique', 'targetAttribute' => ['user_id', 'pet_id']],
            [['pet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pet::class, 'targetAttribute' => ['pet_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => 'User ID',
            'pet_id' => 'Pet ID',
        ];
    }

    /**
     * Gets query for [[Pet]].
     *
     * @return ActiveQuery
     */
    public function getPet(): ActiveQuery
    {
        return $this->hasOne(Pet::class, ['id' => 'pet_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
