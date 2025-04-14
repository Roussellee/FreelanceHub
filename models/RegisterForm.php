<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $role;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat', 'role'], 'required'],
            ['role', 'in', 'range' => ['client', 'freelancer'], 'message' => 'Выбор роли администора запрещен, либо такой роли не существует!'],
            [['username', 'email', 'password'], 'string', 'max' => 255],
            [['username'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'Данный логин уже занят!'],
            [['email'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'Данная почта уже занята!'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Логин'),
            'email' => Yii::t('app', 'Почта'),
            'password' => Yii::t('app', 'Пароль'),
            'password_repeat' => Yii::t('app', 'Повтор пароля'),
            'role' => Yii::t('app', 'Роль'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }


    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->role = $this->role;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user->save()) {
                    // Создание связанных записей в client/freelancer
                    if ($this->role == 'client') {
                        $client = new Client();
                        $client->user_id = $user->id;
                        if (!$client->save()) {
                            throw new \Exception('Не удалось создать запись в таблице Client.');
                        }
                    } elseif ($this->role == 'freelancer') {
                        $freelancer = new Freelancer();
                        $freelancer->user_id = $user->id;
                        if (!$freelancer->save()) {
                            throw new \Exception('Не удалось создать запись в таблице Freelancer.');
                        }
                    }

                    $transaction->commit();
                    return $user;

                } else {
                    throw new \Exception('Не удалось сохранить пользователя.');
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage(), 'registration');
                $this->addError('register', 'Произошла ошибка при регистрации.  Пожалуйста, попробуйте позже.');
                return false;
            }
        }
        return false;
    }
}