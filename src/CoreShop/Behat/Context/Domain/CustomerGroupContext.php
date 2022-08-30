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
use CoreShop\Component\Core\Model\CategoryInterface;
use CoreShop\Component\Core\Model\ProductInterface;
use Webmozart\Assert\Assert;

final class CustomerGroupContext implements Context
{
    /**
     * @Then /^the (customer "[^"]+") should be in (customer-group "[^"]+")$/
     */
    public function theCustomerShouldBeInCustomerGroup(ProductInterface $product, CategoryInterface $category): void
    {
        Assert::oneOf($category, $product->getCategories());
    }
}
