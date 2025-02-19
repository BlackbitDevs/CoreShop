<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Component\Core\Product\Calculator;

use CoreShop\Component\Product\Calculator\ProductRetailPriceCalculatorInterface;
use CoreShop\Component\Product\Exception\NoRetailPriceFoundException;
use CoreShop\Component\Product\Model\ProductInterface;
use CoreShop\Component\Store\Model\StoreInterface;
use Webmozart\Assert\Assert;

final class StoreProductPriceCalculator implements ProductRetailPriceCalculatorInterface
{
    public function getRetailPrice(ProductInterface $subject, array $context): int
    {
        /**
         * @var $subject \CoreShop\Component\Core\Model\ProductInterface
         */
        Assert::isInstanceOf($subject, \CoreShop\Component\Core\Model\ProductInterface::class);
        Assert::keyExists($context, 'store');
        Assert::isInstanceOf($context['store'], StoreInterface::class);

        $storeValues = $subject->getStoreValuesForStore($context['store']);

        if (null === $storeValues) {
            throw new NoRetailPriceFoundException(__CLASS__);
        }

        if (0 === $storeValues->getPrice()) {
            throw new NoRetailPriceFoundException(__CLASS__);
        }

        return $storeValues->getPrice();
    }
}
