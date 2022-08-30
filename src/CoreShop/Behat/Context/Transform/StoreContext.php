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

namespace CoreShop\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CoreShop\Component\Core\Model\StoreInterface;
use CoreShop\Component\Store\Repository\StoreRepositoryInterface;
use Webmozart\Assert\Assert;

final class StoreContext implements Context
{
    public function __construct(private StoreRepositoryInterface $storeRepository)
    {
    }

    /**
     * @Transform /^store(?:|s) "([^"]+)"$/
     * @Transform /^store to "([^"]+)"$/
     */
    public function getStoreByName($name): StoreInterface
    {
        /**
         * @var StoreInterface[] $stores
         */
        $stores = $this->storeRepository->findBy(['name' => $name]);

        Assert::eq(
            count($stores),
            1,
            sprintf('%d stores has been found with name "%s".', count($stores), $name)
        );

        return reset($stores);
    }
}
