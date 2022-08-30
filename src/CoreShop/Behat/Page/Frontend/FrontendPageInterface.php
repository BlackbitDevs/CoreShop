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

namespace CoreShop\Behat\Page\Frontend;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface FrontendPageInterface extends SymfonyPageInterface
{
    public function isOpenWithUri(string $uri): bool;

    public function tryToOpenWithUri(string $uri): void;
}
