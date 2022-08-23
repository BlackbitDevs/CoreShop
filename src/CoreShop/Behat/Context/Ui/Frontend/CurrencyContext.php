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

namespace CoreShop\Behat\Context\Ui\Frontend;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Page\Frontend\HomePageInterface;

final class CurrencyContext implements Context
{
    public function __construct(private HomePageInterface $homePage)
    {
    }

    /**
     * @When I switch to currency :currencyCode
     * @Given I changed my currency to :currencyCode
     */
    public function iSwitchTheCurrencyToTheCurrency($currencyCode): void
    {
        $this->homePage->open();
        $this->homePage->switchCurrency($currencyCode);
    }
}
