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
use CoreShop\Component\Core\Model\CountryInterface;
use CoreShop\Component\Core\Model\CurrencyInterface;
use CoreShop\Component\Core\Model\StoreInterface;
use CoreShop\Component\Resource\Factory\FactoryInterface;
use CoreShop\Component\Store\Context\FixedStoreContext;
use Doctrine\ORM\EntityManagerInterface;

final class StoreContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private EntityManagerInterface $entityManager, private FactoryInterface $storeFactory, private FactoryInterface $currencyFactory, private FactoryInterface $countryFactory, private FixedStoreContext $fixedStoreContext)
    {
    }

    /**
     * @Given the site operates on a store in "Austria"
     */
    public function storeOperatesOnASingleStoreInAustria(): void
    {
        $store = $this->createStore('Austria');

        $this->fixedStoreContext->setStore($store);
        $this->saveStore($store);
    }

    /**
     * @Given the site operates on a store in "Austria" with gross values
     */
    public function storeOperatesOnASingleStoreInAustriaWithGrossValues(): void
    {
        $store = $this->createStore('Austria', null, null, true);

        $this->fixedStoreContext->setStore($store);
        $this->saveStore($store);
    }

    /**
     * @Given /^I am in (store "[^"]+")$/
     */
    public function iAmInStore(StoreInterface $store): void
    {
        $this->fixedStoreContext->setStore($store);
    }

    /**
     * @Given /^the site has a store "([^"]+)" with (country "[^"]+") and (currency "[^"]+")$/
     */
    public function siteHasAStoreWithCountryAndCurrency($name, CountryInterface $country, CurrencyInterface $currency): void
    {
        $store = $this->createStore($name, $currency, $country);

        $this->saveStore($store);
    }

    /**
     * @Given /^the site has a store "([^"]+)" with (country "[^"]+") and (currency "[^"]+") and gross values$/
     */
    public function siteHasAStoreWithCountryAndCurrencyAndGrossValues($name, CountryInterface $country, CurrencyInterface $currency): void
    {
        $store = $this->createStore($name, $currency, $country, true);

        $this->saveStore($store);
    }

    /**
     * @Given /^the (store "[^"]+") uses theme "([^"]+)"$/
     */
    public function theStoreusesTheme(StoreInterface $store, $template): void
    {
        $store->setTemplate($template);

        $this->saveStore($store);
    }

    /**
     * @Given /^the (store "[^"]+") is the default store$/
     */
    public function theStoreIsDefault(StoreInterface $store): void
    {
        $store->setIsDefault(true);

        $this->saveStore($store);
    }

    private function createStore(
        string $name,
        CurrencyInterface $currency = null,
        CountryInterface $country = null,
        $grossValues = false
    ): StoreInterface {
        /**
         * @var StoreInterface $store
         */
        $store = $this->storeFactory->createNew();

        if (null === $currency) {
            /**
             * @var CurrencyInterface $currency
             */
            $currency = $this->currencyFactory->createNew();
            $currency->setIsoCode('EUR');
            $currency->setName('EURO');
            $currency->setSymbol('€');

            $this->entityManager->persist($currency);

            $this->sharedStorage->set('currency', $currency);
        }

        if (null === $country) {
            /**
             * @var CountryInterface $country
             */
            $country = $this->countryFactory->createNew();
            $country->setName('Austria', 'en');
            $country->setIsoCode('AT');
            $country->setCurrency($currency);
            $country->setActive(true);
            $country->setAddressFormat('
                {{ company }}
                {{ salutation }} {{ firstname }} {{ lastname }}
                {{ street }}
                {{ postcode }}
                {{ country.name }}
            ');

            $this->entityManager->persist($country);

            $this->sharedStorage->set('country', $country);
        }

        $this->entityManager->flush();

        $store->setName($name);
        $store->setCurrency($currency);
        $store->setBaseCountry($country);
        $store->addCountry($country);
        $store->setUseGrossPrice($grossValues);

        return $store;
    }

    private function saveStore(StoreInterface $store): void
    {
        $this->entityManager->persist($store);
        $this->entityManager->flush();

        $this->sharedStorage->set('store', $store);
    }
}
