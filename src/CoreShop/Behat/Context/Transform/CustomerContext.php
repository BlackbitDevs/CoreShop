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
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Core\Model\CustomerInterface;
use CoreShop\Component\Customer\Repository\CustomerRepositoryInterface;
use Webmozart\Assert\Assert;

final class CustomerContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private CustomerRepositoryInterface $customerRepository)
    {
    }

    /**
     * @Transform /^customer "([^"]+)"$/
     * @Transform /^email "([^"]+)"$/
     */
    public function getCustomerByEmail($email): CustomerInterface
    {
        $customer = $this->customerRepository->findCustomerByEmail($email);

        Assert::isInstanceOf($customer, CustomerInterface::class);

        return $customer;
    }

    /**
     * @Transform /^customer$/
     */
    public function customer(): CustomerInterface
    {
        $customer = $this->sharedStorage->get('customer');

        Assert::isInstanceOf($customer, CustomerInterface::class);

        return $customer;
    }
}
