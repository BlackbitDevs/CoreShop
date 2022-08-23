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

namespace CoreShop\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Product\Model\ProductUnitInterface;
use CoreShop\Component\Resource\Factory\FactoryInterface;
use Doctrine\Persistence\ObjectManager;

final class ProductUnitContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private ObjectManager $objectManager, private FactoryInterface $productUnitFactory)
    {
    }

    /**
     * @Given /^the site has a product-unit "([^"]+)"$/
     */
    public function thereIsAProductUnit($name): void
    {
        /**
         * @var ProductUnitInterface $unit
         */
        $unit = $this->productUnitFactory->createNew();

        $unit->setName($name);
        $unit->setFullLabel($name, 'en');
        $unit->setFullPluralLabel($name, 'en');
        $unit->setShortLabel($name, 'en');
        $unit->setShortPluralLabel($name, 'en');

        $this->objectManager->persist($unit);
        $this->objectManager->flush();

        $this->sharedStorage->set('product-unit', $unit);
    }
}
