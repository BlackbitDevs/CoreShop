<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Bundle\CoreBundle\Form\Extension;

use CoreShop\Bundle\AddressBundle\Form\Type\CountryChoiceType;
use CoreShop\Bundle\AddressBundle\Form\Type\StateChoiceType;
use CoreShop\Bundle\TaxationBundle\Form\Type\TaxRuleType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class TaxRuleTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('country', CountryChoiceType::class, [
                'active' => null,
                'required' => false,
            ])
            ->add('state', StateChoiceType::class, [
                'active' => null,
                'required' => false,
            ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [TaxRuleType::class];
    }
}
