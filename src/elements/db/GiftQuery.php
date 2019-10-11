<?php

namespace wagood\membershipasgift\elements\db;

use wagood\membershipasgift\elements\GiftElement;

use craft\elements\db\ElementQuery;
use craft\helpers\Db;

class GiftQuery extends ElementQuery
{
    // Properties
    // =========================================================================

    public $giftCode;
    public $subscriptionId;
    public $subscriptionType;


    // Public Methods
    // =========================================================================
    public function giftCode($value)
    {
        $this->giftCode = $value;
        return $this;
    }

    public function activated($value)
    {
        $this->activated = $value;
        return $this;
    }

    public function subscriptionId($value)
    {
        $this->subscriptionId = $value;
        return $this;
    }

    public function subscriptionType($value)
    {
        $this->subscriptionType = $value;
        return $this;
    }

    protected function statusCondition(string $status)
    {
        switch ($status) {
            case GiftElement::STATUS_ENABLED:
                return [
                    'elements.enabled' => true
                ];
            case GiftElement::STATUS_DISABLED:
                return [
                    'elements.disabled' => true
                ];
            default:
                return parent::statusCondition($status);
        }
    }

    protected function beforePrepare(): bool
    {
        // join in the products table
        $this->joinElementTable('membershipasgift_giftrecord');

        // select the price column
        $this->query->select([
            'membershipasgift_giftrecord.giftCode',
            'membershipasgift_giftrecord.subscriptionId',
            'membershipasgift_giftrecord.subscriptionType',
        ]);

        if ($this->giftCode) {
            $this->subQuery->andWhere(Db::parseParam('membershipasgift_giftrecord.giftCode', $this->giftCode));
        }

        if ($this->subscriptionId) {
            $this->subQuery->andWhere(Db::parseParam('membershipasgift_giftrecord.subscriptionId', $this->subscriptionId));
        }

        if ($this->subscriptionId) {
            $this->subQuery->andWhere(Db::parseParam('membershipasgift_giftrecord.subscriptionType', $this->subscriptionType));
        }

        return parent::beforePrepare();
    }
}
