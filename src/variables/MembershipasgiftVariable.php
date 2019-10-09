<?php
/**
 * membership-as-gift plugin for Craft CMS 3.x
 *
 * Purchase membership as gift
 *
 * @link      https://prestaclub.ru
 * @copyright Copyright (c) 2019 WAGOOD
 */

namespace wagood\membershipasgift\variables;

use wagood\membershipasgift\Membershipasgift;

use Craft;

/**
 * membership-as-gift Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.membershipasgift }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    WAGOOD
 * @package   Membershipasgift
 * @since     0.0.1
 */
class MembershipasgiftVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.membershipasgift.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.membershipasgift.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
