<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 */

declare(strict_types=1);

namespace CoreShop\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use CoreShop\Component\Core\Model\OrderInterface;
use CoreShop\Component\Order\Cart\Rule\CartPriceRuleValidationProcessorInterface;
use CoreShop\Component\Order\Model\CartPriceRuleInterface;
use Webmozart\Assert\Assert;

final class CartPriceRuleContext implements Context
{
    public function __construct(private CartPriceRuleValidationProcessorInterface $cartPriceRuleValidationProcessor)
    {
    }

    /**
     * @Then /^the (cart rule "[^"]+") should be valid for (my cart)$/
     * @Then /^the (cart rule) should be valid for (my cart)$/
     */
    public function theSpecificPriceRuleForProductShouldBeValid(CartPriceRuleInterface $cartPriceRule, OrderInterface $cart): void
    {
        Assert::true($this->cartPriceRuleValidationProcessor->isValidCartRule($cart, $cartPriceRule));
    }

    /**
     * @Then /^the (cart rule "[^"]+") should be invalid for (my cart)$/
     * @Then /^the (cart rule) should be invalid for (my cart)$/
     */
    public function theSpecificPriceRuleForProductShouldBeInvalid(CartPriceRuleInterface $cartPriceRule, OrderInterface $cart): void
    {
        Assert::false($this->cartPriceRuleValidationProcessor->isValidCartRule($cart, $cartPriceRule));
    }
}
