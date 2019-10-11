<?php
namespace wagood\membershipasgift\traits;

use wagood\membershipasgift\services\GiftService;

trait PluginTrait
{
    // Static Properties
    // =========================================================================

    public static $plugin;


    // Public Methods
    // =========================================================================

    public function getGiftService()
    {
        return $this->get('GiftService');
    }

    private function _setPluginComponents()
    {
        $this->setComponents([
            'GiftService' => GiftService::class,
        ]);
    }

}