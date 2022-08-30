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
use Pimcore\Model\DataObject\Concrete;

final class SharedStorageContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage)
    {
    }

    /**
     * @Transform /^(it|its|theirs|them|he)$/
     */
    public function getLatestResource(): mixed
    {
        return $this->sharedStorage->getLatestResource();
    }

    /**
     * @Transform /^(?:this|that|the) ([^"]+)$/
     */
    public function getResource(string $resource): mixed
    {
        return $this->sharedStorage->get(str_replace([' ', '-', '\''], '_', $resource));
    }

    /**
     * @Transform /^(object)$/
     */
    public function getLatestObject(): ?object
    {
        return $this->getLatestResource() instanceof Concrete ? $this->getLatestResource() : null;
    }

    /**
     * @Transform /^(copied-object)$/
     */
    public function getCopiedObject(): ?object
    {
        return $this->sharedStorage->get('copied-object');
    }
}
