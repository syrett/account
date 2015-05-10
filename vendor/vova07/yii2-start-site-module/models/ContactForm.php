<?php

namespace vova07\site\models;

use vova07\site\Module;
use yii\base\Model;
use Yii;

/**
 * Class ContactForm.
 * @package frontend\modules\site\models
 * Contact form model.
 *
 * @property string $name Name
 * @property string $email E-mail
 * @property string $subject Subject
 * @property string $body Body
 * @property string $verifyCode Verify Code
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [[name]], [[email]], [[subject]] and [[body]] are required.
            [['name', 'email', 'subject', 'body'], 'required'],
            // [[email]] must be an valid e-mail.
            ['email', 'email'],
            // [[verifyCode]] must be a right captcha code.
            ['verifyCode', 'captcha', 'captchaAction' => 'site/default/captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('site', 'CONTACT_FORM_ATTR_NAME'),
            'email' => Module::t('site', 'CONTACT_FORM_ATTR_EMAIL'),
            'subject' => Module::t('site', 'CONTACT_FORM_ATTR_SUBJECT'),
            'body' => Module::t('site', 'CONTACT_FORM_ATTR_BODY'),
            'verifyCode' => Module::t('site', 'CONTACT_FORM_ATTR_VERIFY_CODE'),
        ];
    }

    /**
     * Send user's message to `Admin` e-mail address.
     *
     * @param string $email E-mail address
     *
     * @return boolean Model validation status
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
            return true;
        } else {
            return false;
        }
    }
}