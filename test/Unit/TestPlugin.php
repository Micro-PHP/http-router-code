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

namespace Micro\Plugin\Http\Test\Unit;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginDependedInterface;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Http\HttpRouterCodePlugin;
use Micro\Plugin\Http\Plugin\RouteProviderPluginInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class TestPlugin implements RouteProviderPluginInterface, DependencyProviderInterface, PluginDependedInterface
{
    private Container $container;

    public function provideDependencies(Container $container): void
    {
        $this->container = $container;
    }

    public function provideRoutes(): iterable
    {
        yield $this->container
            ->get(HttpFacadeInterface::class)
            ->createRouteBuilder()
            ->setUri('/{parameter}')
            ->setController(function(Request $request) { return new Response('Hello, ' . $request->get('parameter'));})
            ->build()
            ;
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpRouterCodePlugin::class
        ];
    }
}