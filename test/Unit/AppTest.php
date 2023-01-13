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

use Micro\Framework\Kernel\Configuration\DefaultApplicationConfiguration;
use Micro\Kernel\App\AppKernel;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class AppTest extends TestCase
{
    public function testApp()
    {
        $configuration = new DefaultApplicationConfiguration([]);
        $kernel = new AppKernel(
            $configuration,
            [
                TestPlugin::class
            ],
        );

        $kernel->run();
        $request = Request::create('/kost');
        $response = $kernel->container()->get(HttpFacadeInterface::class)
            ->execute($request);

        $this->assertEquals('Hello, kost', $response->getContent());

    }
}