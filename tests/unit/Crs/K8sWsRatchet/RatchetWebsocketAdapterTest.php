<?php

/**
 * This file is part of the crs/k8s-ws-ratchet library.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace unit\Crs\K8sWsRatchet;

use Crs\K8s\Websocket\Contract\FrameHandlerInterface;
use Crs\K8s\Websocket\Exception\WebsocketException;
use Crs\K8sWsRatchet\RatchetWebsocketAdapter;
use Psr\Http\Message\RequestInterface;
use React\EventLoop\LoopInterface;
use React\Socket\ConnectorInterface;

class RatchetWebsocketAdapterTest extends TestCase
{
    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|ConnectorInterface
     */
    private $connector;

    /**
     * @var \Mockery\LegacyMockInterface|\Mockery\MockInterface|LoopInterface
     */
    private $loop;

    /**
     * @var RatchetWebsocketAdapter
     */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();
        $this->connector = \Mockery::spy(ConnectorInterface::class);
        $this->loop = \Mockery::spy(LoopInterface::class);
        $this->subject = new RatchetWebsocketAdapter(
            [],
            $this->connector,
            $this->loop
        );
    }

    public function testConnectThrowsAnExceptionOnConnectionError()
    {
        $request = \Mockery::spy(RequestInterface::class);
        $handler = \Mockery::spy(FrameHandlerInterface::class);

        $request->shouldReceive([
            'getHeaders' => [],
        ]);

        $this->expectException(WebsocketException::class);
        $this->subject->connect('foo', $request, $handler);
    }
}
