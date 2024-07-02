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

namespace CoreShop\Bundle\MessengerBundle\Messenger;

use Symfony\Component\Serializer\Annotation\SerializedName;

final class FailedMessageDetails
{
    public function __construct(
        private mixed $id,
        private string $class,
        private string $failedAt,
        private ?string $error,
        private string $serialized,
    ) {
    }

    #[SerializedName('id')]
    public function getId(): mixed
    {
        return $this->id;
    }

    #[SerializedName('class')]
    public function getClass(): string
    {
        return $this->class;
    }

    #[SerializedName('failed_at')]
    public function getFailedAt(): string
    {
        return $this->failedAt;
    }

    #[SerializedName('error')]
    public function getError(): ?string
    {
        return $this->error;
    }

    #[SerializedName('serialized')]
    public function getSerialized(): string
    {
        return $this->serialized;
    }
}
