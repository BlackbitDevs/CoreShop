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

namespace CoreShop\Bundle\ProductBundle\Form\Type;

use CoreShop\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use CoreShop\Bundle\RuleBundle\Form\Type\RuleType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductPriceRuleType extends RuleType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => ProductPriceRuleTranslationType::class,
            ])
            ->add('name', TextareaType::class)
            ->add('priority', IntegerType::class)
            ->add('active', CheckboxType::class)
            ->add('stopPropagation', CheckboxType::class)
            ->add('conditions', ProductPriceRuleConditionCollectionType::class)
            ->add('actions', ProductPriceRuleActionCollectionType::class)
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'coreshop_product_price_rule';
    }
}
