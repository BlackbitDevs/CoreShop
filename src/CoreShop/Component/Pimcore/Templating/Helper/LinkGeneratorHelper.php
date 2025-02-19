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

namespace CoreShop\Component\Pimcore\Templating\Helper;

use CoreShop\Component\Pimcore\Routing\LinkGeneratorInterface;
use Pimcore\Model\DataObject\Concrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Templating\Helper\Helper;

class LinkGeneratorHelper extends Helper implements LinkGeneratorHelperInterface
{
    private LinkGeneratorInterface $linkGenerator;

    public function __construct(LinkGeneratorInterface $linkGenerator)
    {
        $this->linkGenerator = $linkGenerator;
    }

    public function getPath($routeNameOrObject/*, $routeName*/, $params = [], $relative = false): string
    {
        list($object, $routeName, $params, $relative) = $this->prepareParameters(func_get_args());

        return $this->linkGenerator->generate(
            $object,
            $routeName,
            $params,
            $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }

    public function getUrl($routeNameOrObject/*, $routeName*/, $params = [], $schemeRelative = false): string
    {
        list($object, $routeName, $params, $relative) = $this->prepareParameters(func_get_args());

        return $this->linkGenerator->generate(
            $object,
            $routeName,
            $params,
            $relative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    protected function prepareParameters($arguments): array
    {
        $object = null;
        $routeName = null;

        if (count($arguments) >= 1) {
            $object = $arguments[0];
            $routeName = $arguments[0];

            if ($arguments[0] instanceof Concrete) {
                $routeName = $arguments[1];

                if (count($arguments) > 2) {
                    $params = $arguments[2];
                } else {
                    $params = [];
                }

                if (count($arguments) > 3) {
                    $relative = $arguments[3];
                } else {
                    $relative = false;
                }
            } else {
                $object = null;

                if (count($arguments) > 1) {
                    $params = $arguments[1];
                } else {
                    $params = [];
                }

                if (count($arguments) > 2) {
                    $relative = $arguments[2];
                } else {
                    $relative = false;
                }
            }
        } else {
            throw new \InvalidArgumentException('At least on parameter needs to be given');
        }

        return [
            $object,
            $routeName,
            $params,
            $relative,
        ];
    }

    public function getName(): string
    {
        return 'coreshop_link';
    }
}
