<?php
declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use CoreShop\Component\Core\Context\ShopperContextInterface;
use CoreShop\Component\Core\Model\ProductInterface;
use CoreShop\Component\Product\Model\ProductPriceRuleInterface;
use CoreShop\Component\Rule\Condition\RuleValidationProcessorInterface;
use Webmozart\Assert\Assert;

final class ProductPriceRuleContext implements Context
{
    public function __construct(
        private ShopperContextInterface $shopperContext,
        private RuleValidationProcessorInterface $ruleValidationProcessor,
    ) {
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
