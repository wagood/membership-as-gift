<?php
/**
 * membership-as-gift plugin for Craft CMS 3.x
 *
 * Purchase membership as gift
 *
 * @link      https://prestaclub.ru
 * @copyright Copyright (c) 2019 WAGOOD
 */

namespace wagood\membershipasgift\services;

use wagood\membershipasgift\Membershipasgift;

use Craft;
use craft\base\Component;

/**
 * GiftService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    WAGOOD
 * @package   Membershipasgift
 * @since     0.0.1
 */
class GiftService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Membershipasgift::$plugin->giftService->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';

        return $result;
    }
}
