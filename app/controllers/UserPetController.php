<?php

namespace app\controllers;

use app\models\Pet;
use app\models\UserPet;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class UserPetController extends \yii\web\Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'list-pet', 'user-pet-list', 'delete-pet', 'submit-form'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $pets = Yii::$app->user->identity->getPets()->all();
        return $this->render('index',['pets' => $pets]);
    }

    public function actionListPet($searchQuery): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $pets = Pet::find()->where(['like', 'name', $searchQuery])->all();
        return $pets;
    }

    public function actionUserPetList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Yii::$app->user->identity->getPets()->all();
    }

    public function actionDeletePet(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(UserPet::deleteAll(['user_id' => Yii::$app->user->identity->id])){
            return [
                'status' => 'success',
                'message' => 'Pets delete successfully.#1844'
            ];
        }
        return [
            'status' => 'error',
            'message' => 'Pets not delete successfully.#1844'
        ];
    }

    /**
     * @throws \Exception
     */
    public function actionSubmitForm(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $requestPayload = Yii::$app->request->getRawBody();
        $decodedPayload = json_decode($requestPayload, true);

        $selectedOptions = $decodedPayload['selectedOptions'];
        $userId = Yii::$app->user->identity->id;

        UserPet::addPets($selectedOptions);

        return [
            'success' => true,
            'message' => 'Pets assigned successfully.',
            'userpets' => Yii::$app->user->identity->getPets()->all()
        ];
    }

    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

}
