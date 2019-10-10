<?php
namespace wagood\membershipasgift\elements;

use wagood\membershipasgift\MembershipAsGift;
use wagood\membershipasgift\elements\db\GiftQuery;
use wagood\membershipasgift\records\GiftRecord;

use Craft;
use craft\base\Element;
use craft\db\Query;
use craft\elements\db\ElementQueryInterface;
use yii\base\InvalidConfigException;

class Gift extends Element
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
  public $activated = 0;
  public $membership = 'none';

  public function getName()
  {
    return Craft::t('membership-as-gift', 'Gift code');
  }

  public function rules(): array
  {
    $rules = parent::rules();

    $rules[] = [['giftCode'], 'required'];
    $rules[] = [['membership'], 'required'];

    return $rules;
  }

  public static function find(): ElementQueryInterface
  {
    return new GiftQuery(static::class);
  }

  public function afterSave(bool $isNew)
  {
    if (!$isNew) {
      $giftRecords = GiftRecord::findOne($this->id);

      if (!$giftRecords) {
        throw new InvalidConfigException('Invalid code id: ' . $this->id);
      }
    } else {
      $giftRecords = new GiftRecord();
      $giftRecords->id = $this->id;
      $giftRecords->membership = $this->membership;
    }

    if ($isNew) {
      $giftRecords->giftCode = $this->generateCode();
      // set the giftCode to the Code as well to use it directly
      $this->giftCode = $giftRecords->giftCode;
    }

    $giftRecords->save(false);
  }

  protected function generateCode(): string
  {
    do {
      $codeKey = MembershipAsGift::getInstance()->getGiftservice()->generateCodeKey();
    } while (!MembershipAsGift::getInstance()->getGiftservice()->isCodeKeyUnique($codeKey));

    return $codeKey;
  }
}