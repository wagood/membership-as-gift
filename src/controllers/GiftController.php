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

use wagood\membershipasgift\elements\GiftElement;

use Craft;
use craft\web\Controller;

use \Solspace\Freeform\Elements\Submission;
use \yii\web\HttpException;

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

    public $allowStatus = ['open'];

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
    public function actionActivate(string $giftId)
    {
        $result = 'Welcome to the GiftControllerController activate() method';

        return $result;
    }


    public function actionCreate(int $Id)
    {
        // @TODO: check for isPost request
        //$this->requirePostRequest();
        //$request = Craft::$app->getRequest();
        //$codeId = $request->getBodyParam('codeId');

        // check for Freeform plugin
        $Freeform = Craft::$app->getPlugins()->getPlugin('freeform');
        if (null === $Freeform) {
            throw new HttpException(503, 'Freeform plugin required');
        }

        // Get submission by token or Id
        $submission = $Freeform->submissions->getSubmissionById($Id);
        if (!$submission instanceof Submission) {
            throw new HttpException( 404,'Submission not found');
        }

        // Check for submission type is Open
        if (!(isset($submission->status) && in_array($submission->status, $this->allowStatus))) {
            throw new HttpException(404,'Subscription is closed');
        }

        // check for subscriptionId is unique
        if (GiftElement::find()->subscriptionId($Id)->one()) {
            throw new HttpException(503, 'Gift always was created');
        }


        // Get subscriptionType
        $subscriptionType = $submission->subscriptionType->getValue();

        $giftElement = new GiftElement();
        $giftElement->subscriptionId = $Id;
        $giftElement->subscriptionType = $subscriptionType;

        // Save it
        if (!Craft::$app->getElements()->saveElement($giftElement, false)) {
            throw new HttpException(503, 'Can\'t save gift');
        }

        var_dump($submission->status);
        var_dump($subscriptionType);

        // create new Gift
        exit();
    }
}
