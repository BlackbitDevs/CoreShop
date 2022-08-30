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
use CoreShop\Component\Core\Context\ShopperContextInterface;
use CoreShop\Component\Core\Model\ProductInterface;
use CoreShop\Component\Product\Model\ProductPriceRuleInterface;
use CoreShop\Component\Rule\Condition\RuleValidationProcessorInterface;
use Webmozart\Assert\Assert;

final class ProductPriceRuleContext implements Context
{
    public function __construct(private ShopperContextInterface $shopperContext, private RuleValidationProcessorInterface $ruleValidationProcessor)
    {
    }

    /**
     * @Then /^the (price rule "[^"]+") for (product "[^"]+") should be valid$/
     * @Then /^the (price rule) should be valid for (product "[^"]+")$/
     */
    public function theSpecificPriceRuleForProductShouldBeValid(ProductPriceRuleInterface $productPriceRule, ProductInterface $product): void
    {
        Assert::true($this->ruleValidationProcessor->isValid($product, $productPriceRule, $this->shopperContext->getContext()));
    }

    /**
     * @Then /^the (price rule "[^"]+") for (product "[^"]+") should be invalid$/
     * @Then /^the (price rule) should be invalid for (product "[^"]+")$/
     */
    public function theSpecificPriceRuleForProductShouldBeInvalid(ProductPriceRuleInterface $productPriceRule, ProductInterface $product): void
    {
        Assert::false($this->ruleValidationProcessor->isValid($product, $productPriceRule, $this->shopperContext->getContext()));
    }
}
