<?php

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <kost@micro-php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Micro\Plugin\Http\Test\Unit\Business\Locator;

use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Http\Business\Locator\RouteCodeLocator;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Micro\Plugin\Http\Plugin\RouteProviderPluginInterface;
use PHPUnit\Framework\TestCase;

class RouteCodeLocatorTest extends TestCase
{

    public function testLocate()
    {
        $kernel = $this->createMock(KernelInterface::class);
        $kernel
            ->expects($this->once())
            ->method('plugins')
            ->with(RouteProviderPluginInterface::class)
            ->willReturn([
                $this->createRouteProvider(),
                $this->createRouteProvider()
            ]);

        $routerCodeLocator = new RouteCodeLocator($kernel);
        foreach ($routerCodeLocator->locate() as $route) {
            $this->assertInstanceOf(RouteInterface::class, $route);
        }
    }

    protected function createRouteProvider()
    {
        $routeProvider = $this->createMock(RouteProviderPluginInterface::class);
        $routeProvider
            ->expects($this->once())
            ->method('provideRoutes')
            ->willReturn([
                $this->createMock(RouteInterface::class),
            ]);

        return $routeProvider;
    }
}
