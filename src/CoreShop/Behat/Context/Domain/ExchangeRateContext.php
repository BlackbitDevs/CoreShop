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

namespace CoreShop\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use CoreShop\Component\Core\Model\CurrencyInterface;
use CoreShop\Component\Currency\Converter\CurrencyConverterInterface;
use Webmozart\Assert\Assert;

final class ExchangeRateContext implements Context
{
    public function __construct(private CurrencyConverterInterface $currencyConverter)
    {
    }

    /**
     * @Then /^price "([^"]+)" of (currency "[^"]+") should exchange to price "([^"]+)" in (currency "[^"]+")$/
     */
    public function priceOfCurrencyShouldExchangeToPriceInCurrency($fromPrice, CurrencyInterface $fromCurrency, $toPrice, CurrencyInterface $toCurrency): void
    {
        Assert::same(
            $this->currencyConverter->convert((int)$fromPrice, $fromCurrency->getIsoCode(), $toCurrency->getIsoCode()),
            (int)$toPrice,
            sprintf(
                'Given exchanged value (%s %s) is different from actual value (%s %s)',
                $fromPrice,
                $fromCurrency->getIsoCode(),
                $toPrice,
                $toCurrency->getIsoCode()
            )
        );
    }
}
