<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dektrium\user;

use yii\base\InvalidConfigException;
use yii\base\Module as BaseModule;
use yii\db\Connection;

/**
 * This is the main module class for the Yii2-user.
 *
 * @property array $modelMap
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Module extends BaseModule
{
    const VERSION = '0.9.12';

    /** Email is changed right after user enter's new email address. */
    const STRATEGY_INSECURE = 0;

    /** Email is changed after user clicks confirmation link sent to his new email address. */
    const STRATEGY_DEFAULT = 1;

    /** Email is changed after user clicks both confirmation links sent to his old and new email addresses. */
    const STRATEGY_SECURE = 2;

    /** @var bool Whether to show flash messages. */
    public $enableFlashMessages = true;

    /** @var bool Whether to enable registration. */
    public $enableRegistration = true;

    /** @var bool Whether to remove password field from registration form. */
    public $enableGeneratingPassword = false;

    /** @var bool Whether user has to confirm his account. */
    public $enableConfirmation = true;

    /** @var bool Whether to allow logging in without confirmation. */
    public $enableUnconfirmedLogin = false;

    /** @var bool Whether to enable password recovery. */
    public $enablePasswordRecovery = true;

    /** @var bool Whether user can remove his account */
    public $enableAccountDelete = false;

    /** @var bool Enable the 'impersonate as another user' function */
    public $enableImpersonateUser = true;

    /**
     * @var bool Enable the 'session history' function
     * Using with {@see SessionHistoryDecorator}
     */
    public $enableSessionHistory = false;

    /**
     * @var int|bool The number of 'session history' records will be stored for user
     * if equals false records will not be deleted
     */
    public $numberSessionHistory = false;

    /**
     * @var int|bool The time after which the expired 'session history' will be deleted
     * if equals false records will not be deleted
     */
    public $timeoutSessionHistory = false;

    /** @var int Email changing strategy. */
    public $emailChangeStrategy = self::STRATEGY_DEFAULT;

    /** @var bool Enable 'two factor authentication' (TFA) function */
    public $enableTwoFactorAuthentication = false;

    /** @var int The time you want the user will be remembered without asking for credentials. */
    public $rememberFor = 1209600; // two weeks

    /** @var int The time before a confirmation token becomes invalid. */
    public $confirmWithin = 86400; // 24 hours

    /** @var int The time before a recovery token becomes invalid. */
    public $recoverWithin = 21600; // 6 hours

    /** @var int Cost parameter used by the Blowfish hash algorithm. */
    public $cost = 10;

    /** @var array An array of administrator's usernames. */
    public $admins = [];

    /** @var string The Administrator permission name. */
    public $adminPermission;

    /** @var array Mailer configuration */
    public $mailer = [];

    /** @var array Model map */
    public $modelMap = [];

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'user';

    /**
     * @var bool Is the user module in DEBUG mode? Will be set to false automatically
     * if the application leaves DEBUG mode.
     */
    public $debug = false;

    /** @var string The database connection to use for models in this module. */
    public $dbConnection = 'db';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '<id:\d+>'                               => 'profile/show',
        '<action:(login|logout|auth)>'           => 'security/<action>',
        '<action:(register|resend)>'             => 'registration/<action>',
        'confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'registration/confirm',
        'forgot'                                 => 'recovery/request',
        'recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'recovery/reset',
        'settings/<action:\w+>'                  => 'settings/<action>'
    ];

    /**
     * @return Connection
     * @throws InvalidConfigException
     */
    public function getDb()
    {
        return \Yii::$app->get($this->dbConnection);
    }

    /**
     * @return bool
     */
    public function hasNumberSessionHistory()
    {
        return $this->numberSessionHistory !== false && $this->numberSessionHistory > 0;
    }

    /**
     * @return bool
     */
    public function hasTimeoutSessionHistory()
    {
        return $this->timeoutSessionHistory !== false && $this->timeoutSessionHistory > 0;
    }
}
