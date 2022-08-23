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
use CoreShop\Component\Resource\Factory\FactoryInterface;
use CoreShop\Component\Taxation\Model\TaxRateInterface;
use Doctrine\Persistence\ObjectManager;

final class TaxRateContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private ObjectManager $objectManager, private FactoryInterface $taxRateFactory)
    {
    }

    /**
     * @Given /^the site has a tax rate "([^"]+)" with "([^"]+)%" rate$/
     */
    public function theSiteHasATaxRate($name, float $rate): void
    {
        $this->createTaxRate($name, $rate);
    }

    /**
     * @Given /^the (tax rate "[^"]+") is active$/
     */
    public function theTaxRateIsActive(TaxRateInterface $taxRate): void
    {
        $taxRate->setActive(true);

        $this->saveTaxRate($taxRate);
    }

    private function createTaxRate(string $name, float $rate): void
    {
        /**
         * @var TaxRateInterface $taxRate
         */
        $taxRate = $this->taxRateFactory->createNew();
        $taxRate->setName($name, 'en');
        $taxRate->setRate($rate);

        $this->saveTaxRate($taxRate);
    }

    private function saveTaxRate(TaxRateInterface $taxRate): void
    {
        $this->objectManager->persist($taxRate);
        $this->objectManager->flush();

        $this->sharedStorage->set('taxRate', $taxRate);
    }
}
