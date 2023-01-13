<?php

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
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Plugin\Http\Business\Locator\RouteLocatorInterface;
use Micro\Plugin\Http\HttpCorePlugin;
use Micro\Plugin\Http\HttpRouterCodePlugin;
use Micro\Plugin\Http\Plugin\HttpRouteLocatorPluginInterface;
use PHPUnit\Framework\TestCase;

class HttpRouterCodePluginTest extends TestCase
{
    protected \Micro\Plugin\Http\HttpRouterCodePlugin $plugin;
    protected Container $container;

    public function setUp(): void
    {
        $this->container = $this->createMock(Container::class);
        $this->plugin = new HttpRouterCodePlugin();
        $this->plugin->provideDependencies($this->container);
    }

    public function testConstruct() {
        $this->assertInstanceOf(HttpRouteLocatorPluginInterface::class, $this->plugin);
    }

    public function testGetLocatorType()
    {
        $this->assertEquals('code', $this->plugin->getLocatorType());
    }

    public function testCreateLocator()
    {
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with(KernelInterface::class)
            ->willReturn(
                $this->createMock(KernelInterface::class)
            );

        $this->assertInstanceOf(RouteLocatorInterface::class, $this->plugin->createLocator());
    }

    public function testProvideDependencies()
    {
        $this->assertInstanceOf(DependencyProviderInterface::class, $this->plugin);
    }

    public function testGetDependedPlugins()
    {
        $this->assertEquals(
            [ HttpCorePlugin::class ],
            $this->plugin->getDependedPlugins()
        );
    }
}
