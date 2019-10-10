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
use wagood\membershipasgift\elements\Gift;

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

  public function isCodeKeyUnique(string $giftCode): bool
  {
    return !(bool)Gift::findOne(['giftCode' => $giftCode]);
  }

  /**
   * @return string
   * @from https://www.php.net/manual/ru/function.uniqid.php
   */
  public function generateCodeKey(): string
  {
    $s = uniqid("", true);
    $num = hexdec(str_replace(".", "", (string)$s));
    $index = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $base = strlen($index);
    $giftCode = '';
    for ($t = floor(log10($num) / log10($base)); $t >= 0; $t--) {
      $a = floor($num / pow($base, $t));
      $giftCode = $giftCode . substr($index, $a, 1);
      $num = $num - ($a * pow($base, $t));
    }
    return $giftCode;
  }
}
