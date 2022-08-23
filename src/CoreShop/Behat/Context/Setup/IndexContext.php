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
use CoreShop\Behat\Service\ClassStorageInterface;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Bundle\IndexBundle\Worker\MysqlWorker\TableIndex;
use CoreShop\Component\Index\Model\IndexColumnInterface;
use CoreShop\Component\Index\Model\IndexInterface;
use CoreShop\Component\Index\Worker\WorkerInterface;
use CoreShop\Component\Registry\ServiceRegistryInterface;
use CoreShop\Component\Resource\Factory\FactoryInterface;
use Doctrine\Persistence\ObjectManager;
use Pimcore\Model\DataObject\ClassDefinition;

final class IndexContext implements Context
{
    public function __construct(private SharedStorageInterface $sharedStorage, private ClassStorageInterface $classStorage, private ObjectManager $objectManager, private FactoryInterface $indexFactory, private ServiceRegistryInterface $workerServiceRegistry, private FactoryInterface $indexColumnFactory)
    {
    }

    /**
     * @Given /^the site has a index "([^"]+)" for (class "[^"]+") with type "([^"]+)"$/
     * @Given /^the site has a index "([^"]+)" for (behat-class "[^"]+") with type "([^"]+)"$/
     */
    public function theSiteHasAIndexForClassWithType($name, ClassDefinition $class, $type): void
    {
        $this->createIndex($name, $class->getName(), $type);
    }

    /**
     * @Given /the (index) allows version changes$/
     */
    public function theIndexAllowsVersionChanges(IndexInterface $index): void
    {
        $index->setIndexLastVersion(true);
        $this->saveIndex($index);
    }

    /**
     * @Given /the (index) has following fields:/
     */
    public function theIndexHasFollowingFields(IndexInterface $index, TableNode $table): void
    {
        $hash = $table->getHash();

        foreach ($hash as $row) {
            /**
             * @var IndexColumnInterface $column
             */
            $column = $this->indexColumnFactory->createNew();
            $column->setName($row['name']);
            $column->setObjectKey($row['key']);
            $column->setObjectType($row['type']);
            $column->setGetter($row['getter']);
            $column->setColumnType($row['columnType']);
            $column->setDataType('input');

            if (array_key_exists('interpreter', $row)) {
                $column->setInterpreter($row['interpreter']);
            }

            if (array_key_exists('getterConfig', $row)) {
                $column->setGetterConfig(json_decode($row['getterConfig'], true));
            }

            if (array_key_exists('interpreterConfig', $row)) {
                $column->setInterpreterConfig(json_decode($row['interpreterConfig'], true));
            }

            if (array_key_exists('configuration', $row)) {
                $configuration = json_decode($row['configuration'], true);

                foreach ($configuration as $key => &$value) {
                    if ($key === 'className') {
                        $value = $this->classStorage->get($value);
                    }
                }

                $column->setConfiguration($configuration);
            }

            $index->addColumn($column);

            $this->objectManager->persist($column);
            // $row['name'], $row['email'], $row['phone']
        }

        $this->saveIndex($index);
    }

    /**
     * @Given /the (index) has an index for columns "([^"]+)"/
     */
    public function theIndexHasAnIndexForColumn(IndexInterface $index, $columns): void
    {
        $tableIndex = new TableIndex();
        $tableIndex->setType(TableIndex::TABLE_INDEX_TYPE_INDEX);
        $tableIndex->setColumns(explode(', ', $columns));

        $this->addIndexToIndex($index, $tableIndex);
    }

    /**
     * @Given /the (index) has an localized index for columns "([^"]+)"/
     */
    public function theIndexHasAnLocalizedIndexForColumn(IndexInterface $index, $columns): void
    {
        $tableIndex = new TableIndex();
        $tableIndex->setType(TableIndex::TABLE_INDEX_TYPE_INDEX);
        $tableIndex->setColumns(explode(', ', $columns));

        $this->addIndexToIndex($index, $tableIndex, true);
    }

    /**
     * @param bool           $localized
     */
    private function addIndexToIndex(IndexInterface $index, TableIndex $tableIndex, $localized = false): void
    {
        $configurationEntry = $localized ? 'localizedIndexes' : 'indexes';

        $configuration = $index->getConfiguration();

        if (!isset($configuration[$configurationEntry])) {
            $configuration[$configurationEntry] = [];
        }

        $configuration[$configurationEntry][] = $tableIndex;

        $index->setConfiguration($configuration);

        $this->saveIndex($index);
    }

    /**
     * @param string $name
     * @param string $class
     * @param string $type
     */
    private function createIndex($name, $class, $type = 'mysql'): void
    {
        /**
         * @var IndexInterface $index
         */
        $index = $this->indexFactory->createNew();
        $index->setName($name);
        $index->setClass($class);
        $index->setWorker($type);

        $this->saveIndex($index);
    }

    private function saveIndex(IndexInterface $index): void
    {
        $worker = $index->getWorker();

        if (!$this->workerServiceRegistry->has($worker)) {
            throw new \InvalidArgumentException(sprintf('%s Worker not found', $worker));
        }

        /**
         * @var WorkerInterface $worker
         */
        $worker = $this->workerServiceRegistry->get($worker);
        $worker->createOrUpdateIndexStructures($index);

        $this->objectManager->persist($index);
        $this->objectManager->flush();

        $this->sharedStorage->set('index', $index);
    }
}
