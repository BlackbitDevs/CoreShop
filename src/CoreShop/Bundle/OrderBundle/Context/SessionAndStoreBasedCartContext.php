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

namespace CoreShop\Bundle\OrderBundle\Context;

use CoreShop\Component\Order\Context\CartContextInterface;
use CoreShop\Component\Order\Context\CartNotFoundException;
use CoreShop\Component\Order\Model\OrderInterface;
use CoreShop\Component\Order\Repository\OrderRepositoryInterface;
use CoreShop\Component\Store\Context\StoreContextInterface;
use CoreShop\Component\Store\Context\StoreNotFoundException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionAndStoreBasedCartContext implements CartContextInterface
{
    private SessionInterface $session;
    private string $sessionKeyName;
    private OrderRepositoryInterface $cartRepository;
    private StoreContextInterface $storeContext;

    public function __construct(
        SessionInterface $session,
        string $sessionKeyName,
        OrderRepositoryInterface $cartRepository,
        StoreContextInterface $storeContext
    ) {
        $this->session = $session;
        $this->sessionKeyName = $sessionKeyName;
        $this->cartRepository = $cartRepository;
        $this->storeContext = $storeContext;
    }

    public function getCart(): OrderInterface
    {
        try {
            $store = $this->storeContext->getStore();
        } catch (StoreNotFoundException $exception) {
            throw new CartNotFoundException($exception->getMessage(), $exception);
        }

        if (!$this->session->has(sprintf('%s.%s', $this->sessionKeyName, $store->getId()))) {
            throw new CartNotFoundException('CoreShop was not able to find the cart in session');
        }

        /**
         * @var OrderInterface $cart
         */
        $cart = $this->cartRepository->findByCartId($this->session->get(sprintf('%s.%s', $this->sessionKeyName, $store->getId())));

        if (null === $cart || null === $cart->getStore() || $cart->getStore()->getId() !== $store->getId()) {
            $cart = null;
        }

        if (null === $cart) {
            $this->session->remove(sprintf('%s.%s', $this->sessionKeyName, $store->getId()));

            throw new CartNotFoundException('CoreShop was not able to find the cart in session');
        }

        return $cart;
    }
}
