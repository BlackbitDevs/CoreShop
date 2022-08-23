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

namespace CoreShop\Behat\Context\Ui\Pimcore;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Page\Pimcore\PWAPageInterface;
use Webmozart\Assert\Assert;

final class PWAContext implements Context
{
    public function __construct(private PWAPageInterface $pwaPage)
    {
    }

    /**
     * @When I open resource ":application", ":resource"
     */
    public function iOpenResource(string $application, string $resource): void
    {
        $this->pwaPage->openResource($application, $resource);
    }

    /**
     * @Given the panel with id ":id" should be open
     */
    public function thePanelWithIdShouldBeOpen(string $id): void
    {
        Assert::true($this->pwaPage->hasPimcoreTabWithId($id));
    }
}
