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

namespace CoreShop\Component\Product\Rule\Fetcher;

use CoreShop\Component\Product\Model\ProductInterface;
use CoreShop\Component\Registry\ServiceRegistryInterface;

final class CompositeValidRuleFetcher implements ValidRulesFetcherInterface
{
    private ServiceRegistryInterface $validRuleFetchers;

    public function __construct(ServiceRegistryInterface $validRuleFetchers)
    {
        $this->validRuleFetchers = $validRuleFetchers;
    }

    public function getValidRules(ProductInterface $product, array $context): array
    {
        $rules = [];

        /**
         * @var ValidRulesFetcherInterface $validRuleFetcher
         */
        foreach ($this->validRuleFetchers->all() as $validRuleFetcher) {
            $rules = array_merge($rules, $validRuleFetcher->getValidRules($product, $context));
        }

        return $rules;
    }
}
