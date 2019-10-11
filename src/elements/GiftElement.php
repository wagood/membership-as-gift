<?php
namespace wagood\membershipasgift\elements;

use wagood\membershipasgift\MembershipAsGift;
use wagood\membershipasgift\elements\db\GiftQuery;
use wagood\membershipasgift\records\GiftRecord;

use Craft;
use craft\base\Element;
use craft\elements\db\ElementQueryInterface;
use yii\base\InvalidConfigException;

class GiftElement extends Element
{
  /**
   * @inheritdoc
   */
  public static function displayName(): string
  {
    return 'Gift';
  }

  /**
   * @inheritdoc
   */
  public static function pluralDisplayName(): string
  {
    return 'Gifts';
  }

  public $giftCode;
  public $subscriptionId;
  public $subscriptionType = 'none';

  public function getName()
  {
    return Craft::t('subscription-as-gift', 'Gift code');
  }

  public function rules(): array
  {
    $rules = parent::rules();

    $rules[] = [['giftCode'], 'required'];
    $rules[] = [['subscriptionId'], 'required'];
    $rules[] = [['subscriptionType'], 'required'];

    return $rules;
  }

  public static function find(): ElementQueryInterface
  {
    return new GiftQuery(static::class);
  }

  public static function hasStatuses(): bool
  {
      return true;
  }

  public function afterSave(bool $isNew)
  {
    if (!$isNew) {
      $giftRecord = GiftRecord::findOne($this->id);

      if (!$giftRecord) {
        throw new InvalidConfigException('Invalid code id: ' . $this->id);
      }
    } else {
      $giftRecord = new GiftRecord();
      $giftRecord->id = $this->id;
    }

    if ($isNew) {
      $giftRecord->giftCode = $this->generateCode();
      // set the giftCode to the Code as well to use it directly
      $this->giftCode = $giftRecord->giftCode;
      $giftRecord->subscriptionId = $this->subscriptionId;
      $giftRecord->subscriptionType = $this->subscriptionType;
    }

    $giftRecord->save(false);
  }

  protected function generateCode(): string
  {
    do {
      $codeKey = MembershipAsGift::getInstance()->getGiftservice()->generateCodeKey();
    } while (!MembershipAsGift::getInstance()->getGiftservice()->isCodeKeyUnique($codeKey));

    return $codeKey;
  }

}