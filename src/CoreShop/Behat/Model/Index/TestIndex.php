<?php

declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Behat\Model\Index;

use CoreShop\Component\Index\Model\IndexableInterface;
use CoreShop\Component\Index\Model\IndexInterface;
use CoreShop\Component\Resource\Exception\ImplementedByPimcoreException;
use CoreShop\Component\Resource\Pimcore\Model\AbstractPimcoreModel;

/** @noinspection ReturnTypeCanBeDeclaredInspection */
class TestIndex extends AbstractPimcoreModel implements IndexableInterface
{
    public function getIndexable(IndexInterface $index): bool
    {
        return true;
    }

    public function getIndexableEnabled(IndexInterface $index): bool
    {
        $enabled = $this->getEnabled();

        if (!is_bool($enabled)) {
            return false;
        }

        return $enabled;
    }

    public function getEnabled()
    {
        return new ImplementedByPimcoreException(__CLASS__, __METHOD__);
    }

    public function getName($language)
    {
        return new ImplementedByPimcoreException(__CLASS__, __METHOD__);
    }

    public function getIndexableName(IndexInterface $index, string $language): string
    {
        $name = $this->getName($language);

        if (!is_string($name)) {
            return '';
        }

        return $name;
    }
}
