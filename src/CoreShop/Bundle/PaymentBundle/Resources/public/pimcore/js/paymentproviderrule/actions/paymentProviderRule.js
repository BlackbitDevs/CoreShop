/*
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

pimcore.registerNS('coreshop.paymentproviderrule.actions.paymentProviderRule');

coreshop.paymentproviderrule.actions.paymentProviderRule = Class.create(coreshop.rules.conditions.abstract, {
    type: 'paymentProviderRule',

    getForm: function () {
        var me = this;

        var rule = {
            xtype: 'combo',
            fieldLabel: t('coreshop_action_paymentProviderRule'),
            typeAhead: true,
            listWidth: 100,
            width: 500,
            store: {
                type: 'coreshop_payment_provider_rules'
            },
            displayField: 'name',
            valueField: 'id',
            forceSelection: true,
            multiselect: true,
            triggerAction: 'all',
            name: 'paymentProviderRule',
            maxHeight: 400,
            delimiter: false,
            value: me.data.paymentProviderRule
        };

        if (this.data && this.data.paymentProviderRule) {
            rule.value = this.data.paymentProviderRule;
        }

        this.form = new Ext.form.Panel({
            items: [
                rule
            ]
        });

        return this.form;
    }
});
