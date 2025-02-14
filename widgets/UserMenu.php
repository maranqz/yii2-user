<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace dektrium\user\widgets;

use dektrium\user\traits\ModuleTrait;
use yii\widgets\Menu;
use Yii;
use yii\base\Widget;

/**
 * User menu widget.
 */
class UserMenu extends Widget
{
    use ModuleTrait;

    /** @array \dektrium\user\models\RegistrationForm */
    public $items;
    
    public function init()
    {
        parent::init();
        
        $networksVisible = count(Yii::$app->authClientCollection->clients) > 0;
        $sessionHistoryVisible = $this->getModule()->enableSessionHistory;
        $enableTwoFactorAuthentication = $this->getModule()->enableTwoFactorAuthentication;

        $this->items = [
                ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
                ['label' => Yii::t('user', 'Account'), 'url' => ['/user/settings/account']],

                [
                    'label' => Yii::t('user', 'Two factor authentication'),
                    'url' => ['/user/settings/two-factor'],
                    'visible' => $enableTwoFactorAuthentication
                ],
                [
                    'label' => Yii::t('user', 'Networks'),
                    'url' => ['/user/settings/networks'],
                    'visible' => $networksVisible
                ],
                [
                    'label' => Yii::t('user', 'Session history'),
                    'url' => ['/user/settings/session-history'],
                    'visible' => $sessionHistoryVisible
                ],
            ];
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        return Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
            ],
            'items' => $this->items,
        ]);
    }
}
