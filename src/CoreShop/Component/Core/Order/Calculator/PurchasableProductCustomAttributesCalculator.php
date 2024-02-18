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

namespace CoreShop\Component\Core\Order\Calculator;

use CoreShop\Component\Core\Model\ProductInterface;
use CoreShop\Component\Order\Calculator\PurchasableCustomAttributesCalculatorInterface;
use CoreShop\Component\Order\Model\PurchasableInterface;
use CoreShop\Component\Product\Calculator\ProductCustomAttributesCalculatorInterface;

final class PurchasableProductCustomAttributesCalculator implements PurchasableCustomAttributesCalculatorInterface
{
    public function __construct(
        private ProductCustomAttributesCalculatorInterface $productPriceCalculator,
    ) {
    }

    public function getCustomAttributes(PurchasableInterface $purchasable, array $context): array
    {
        if ($purchasable instanceof ProductInterface) {
            return $this->productPriceCalculator->getCustomAttributes($purchasable, $context);
        }

        return [];
    }
}
