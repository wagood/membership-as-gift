<?php
/**
 * membership-as-gift plugin for Craft CMS 3.x
 *
 * Purchase membership as gift
 *
 * @link      https://prestaclub.ru
 * @copyright Copyright (c) 2019 WAGOOD
 */

namespace wagood\membershipasgift\controllers;

use wagood\membershipasgift\Membershipasgift;

use Craft;
use craft\web\Controller;

/**
 * GiftController Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    WAGOOD
 * @package   Membershipasgift
 * @since     0.0.1
 */
class GiftController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['create', 'activate'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/membership-as-gift/gift-controller
     *
     * @return mixed
     */
    public function actionActivate(string $giftId)
    {
        $result = 'Welcome to the GiftControllerController activate() method';

        return $result;
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/membership-as-gift/gift-controller/do-something
     *
     * @return mixed
     */
    public function actionCreate(int $userId)
    {
        $result = 'Welcome to the GiftControllerController create() method';

        return $result;
    }
}
