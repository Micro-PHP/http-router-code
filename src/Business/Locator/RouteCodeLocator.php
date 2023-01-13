<?php

declare(strict_types=1);

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <kost@micro-php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Locator;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Http\Plugin\RouteProviderPluginInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteCodeLocator implements RouteLocatorInterface
{
    /**
     * @param KernelInterface $kernel
     */
    public function __construct(
        private KernelInterface $kernel
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function locate(): iterable
    {
        $iterator = $this->kernel->plugins(RouteProviderPluginInterface::class);
        /** @var RouteProviderPluginInterface $plugin */
        foreach ($iterator as $plugin) {
            foreach ($plugin->provideRoutes() as $route) {
                yield $route;
            }
        }
    }
}