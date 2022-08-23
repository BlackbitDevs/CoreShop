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
use Behat\Gherkin\Node\TableNode;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Index\Model\FilterConditionInterface;
use CoreShop\Component\Index\Model\FilterInterface;
use CoreShop\Component\Index\Model\IndexInterface;
use CoreShop\Component\Product\Model\CategoryInterface;
use CoreShop\Component\Resource\Factory\FactoryInterface;
use Doctrine\Persistence\ObjectManager;

final class FilterContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private ObjectManager $objectManager, private FactoryInterface $filterFactory, private FactoryInterface $filterConditionFactory)
    {
    }

    /**
     * @Given /^the site has a filter "([^"]+)" for (index "[^"]+")$/
     */
    public function theSiteHasAFilterForIndex($name, IndexInterface $index): void
    {
        $this->createFilter($name, $index);
    }

    /**
     * @Given /the (filter) has following conditions:/
     */
    public function theFilterHasFollowingConditions(FilterInterface $filter, TableNode $table): void
    {
        $hash = $table->getHash();

        foreach ($hash as $row) {
            /**
             * @var FilterConditionInterface $condition
             */
            $condition = $this->filterConditionFactory->createNew();
            $condition->setType($row['type']);
            $condition->setConfiguration([
                'field' => $row['field'],
            ]);
            $condition->setLabel($row['label']);

            $filter->addCondition($condition);

            $this->objectManager->persist($condition);
        }

        $this->saveFilter($filter);
    }

    /**
     * @Given /the (filter) has a category condition without category$/
     * @Given /the (filter) has a category condition with (category "[^"]+")$/
     * @Given /the (filter) has a category condition with (category "[^"]+") and it (includes all subcategories)$/
     */
    public function theFilterHasACategoryConditionWithCategory(FilterInterface $filter, CategoryInterface $category = null, $includeAllChilds = ''): void
    {
        $condition = $this->filterConditionFactory->createNew();
        $condition->setType('category_select');
        $condition->setConfiguration([
            'preSelect' => $category ? $category->getId() : null,
            'includeSubCategories' => $includeAllChilds === 'includes all subcategories',
        ]);
        $condition->setLabel('Category');

        $filter->addCondition($condition);

        $this->objectManager->persist($condition);

        $this->saveFilter($filter);
    }

    /**
     * @param string         $name
     */
    private function createFilter($name, IndexInterface $index): void
    {
        /**
         * @var FilterInterface $filter
         */
        $filter = $this->filterFactory->createNew();
        $filter->setName($name);
        $filter->setIndex($index);

        $this->saveFilter($filter);
    }

    private function saveFilter(FilterInterface $filter): void
    {
        $this->objectManager->persist($filter);
        $this->objectManager->flush();

        $this->sharedStorage->set('filter', $filter);
    }
}
