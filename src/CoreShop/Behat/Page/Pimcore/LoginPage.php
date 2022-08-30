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

namespace CoreShop\Behat\Page\Pimcore;

use Behat\Mink\Driver\PantherDriver;

class LoginPage extends AbstractPimcorePage implements LoginPageInterface
{
    public function getRouteName(): string
    {
        return 'pimcore_admin_login';
    }

    public function logIn(): void
    {
        $this->findOrThrow('css', 'button[type=submit]')->click();
        usleep(4000000);

        if ($this->getSession()->getDriver() instanceof PantherDriver) {
            $this->getSession()->getDriver()->getClient()->refreshCrawler();
        }
    }

    public function specifyPassword(string $password): void
    {
        $this->findOrThrow('css', 'input[name=password]')->setValue($password);
    }

    public function specifyUsername(string $username): void
    {
        $this->findOrThrow('css', 'input[name=username]')->setValue($username);
    }
}
