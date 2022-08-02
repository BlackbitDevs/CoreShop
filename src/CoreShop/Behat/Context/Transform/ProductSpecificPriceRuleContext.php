<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Product\Model\ProductSpecificPriceRuleInterface;
use CoreShop\Component\Product\Repository\ProductSpecificPriceRuleRepositoryInterface;
use Webmozart\Assert\Assert;

final class ProductSpecificPriceRuleContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private ProductSpecificPriceRuleRepositoryInterface $productSpecificPriceRuleRepository)
    {
    }

    /**
     * @Transform /^specific price rule "([^"]+)"$/
     */
    public function getPriceRuleByProductAndName(string $ruleName): ProductSpecificPriceRuleInterface
    {
        $rule = $this->productSpecificPriceRuleRepository->findOneBy(['name' => $ruleName]);

        Assert::isInstanceOf($rule, ProductSpecificPriceRuleInterface::class);

        return $rule;
    }

    /**
     * @Transform /^(specific price rule)$/
     */
    public function getLatestSpecificPriceRule(): ProductSpecificPriceRuleInterface
    {
        $resource = $this->sharedStorage->getLatestResource();

        Assert::isInstanceOf($resource, ProductSpecificPriceRuleInterface::class);

        return $resource;
    }
}
