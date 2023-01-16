<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginDependedInterface;
use Micro\Plugin\Http\Business\Locator\RouteCodeLocator;
use Micro\Plugin\Http\Business\Locator\RouteLocatorInterface;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Http\Plugin\HttpRouteLocatorPluginInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class HttpRouterCodePlugin implements HttpRouteLocatorPluginInterface, DependencyProviderInterface, PluginDependedInterface
{
    /**
     * @phpstan-ignore-next-line
     */
    private Container $container;

    public function provideDependencies(Container $container): void
    {
        // @phpstan-ignore-next-line
        $this->container = $container;
    }

    public function getLocatorType(): string
    {
        return 'code';
    }

    public function createLocator(): RouteLocatorInterface
    {
        $kernel = $this->container->get(KernelInterface::class);
        $httpFacade = $this->container->get(HttpFacadeInterface::class);
        // @phpstan-ignore-next-line
        return new RouteCodeLocator($kernel, $httpFacade);
    }

    /**
     * {@inheritDoc}
     */
    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
        ];
    }
}
