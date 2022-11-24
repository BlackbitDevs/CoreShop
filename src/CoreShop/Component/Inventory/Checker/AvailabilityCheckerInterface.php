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

namespace CoreShop\Component\Inventory\Checker;

use CoreShop\Component\Inventory\Model\StockableInterface;

interface AvailabilityCheckerInterface
{
    public function isStockAvailable(StockableInterface $stockable): bool;

    public function isStockSufficient(StockableInterface $stockable, float $quantity): bool;
}
