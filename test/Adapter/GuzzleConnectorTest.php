<?php

namespace VallboTest\SlackNotification\Adapter;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use Vallbo\SlackNotification\Adapter\GuzzleConnector;
use Vallbo\SlackNotification\Notification\NotificationInterface;

/**
 * Class GuzzleConnectorTest
 * @author Vladimir Bosiak <info@vallbo.net>
 */
class GuzzleConnectorTest extends TestCase
{

    /**
     * @var ClientInterface|MockObject
     */
    private $client;

    /**
     * @var GuzzleConnector
     */
    private $connector;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        $this->client = $this->createMock(ClientInterface::class);
        $this->connector = new GuzzleConnector($this->client);
    }

    public function testSuccess()
    {
        $data = ['data' => uniqid()];
        $uri = uniqid();

        $notification = $this->createMock(NotificationInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);

        $notification->expects(self::once())->method('getUri')->willReturn($uri);
        $notification->expects(self::once())->method('getData')->willReturn($data);
        $this->client->expects(self::once())->method('request')
            ->with(
                GuzzleConnector::HTTP_METHOD_POST,
                $uri,
                [
                    RequestOptions::JSON => $data,
                    RequestOptions::TIMEOUT => GuzzleConnector::DEFAULT_TIMEOUT,
                ]
            )
            ->willReturn($response);
        $response->expects(self::once())->method('getBody')->willReturn($stream);
        $stream->expects(self::once())->method('getContents')->willReturn(uniqid());

        $this->connector->sendNotification($notification);
    }

    public function testClientException()
    {
        $data = ['data' => uniqid()];
        $uri = uniqid();

        $notification = $this->createMock(NotificationInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $logger = $this->createMock(LoggerInterface::class);


        $notification->expects(self::once())->method('getUri')->willReturn($uri);
        $notification->expects(self::once())->method('getData')->willReturn($data);
        $this->client->expects(self::once())->method('request')
            ->with(
                GuzzleConnector::HTTP_METHOD_POST,
                $uri,
                [
                    RequestOptions::JSON => $data,
                    RequestOptions::TIMEOUT => GuzzleConnector::DEFAULT_TIMEOUT,
                ]
            )
            ->willThrowException(new ClientException(uniqid(), $request));
        $logger->expects(self::once())->method('warning');

        $this->connector->setLogger($logger);
        $this->expectException(ClientException::class);
        $this->connector->sendNotification($notification);
    }

    public function testException()
    {
        $data = ['data' => uniqid()];
        $uri = uniqid();

        $notification = $this->createMock(NotificationInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $notification->expects(self::once())->method('getUri')->willReturn($uri);
        $notification->expects(self::once())->method('getData')->willReturn($data);
        $this->client->expects(self::once())->method('request')
            ->with(
                GuzzleConnector::HTTP_METHOD_POST,
                $uri,
                [
                    RequestOptions::JSON => $data,
                    RequestOptions::TIMEOUT => GuzzleConnector::DEFAULT_TIMEOUT,
                ]
            )
            ->willThrowException(new \Exception());
        $logger->expects(self::once())->method('critical');

        $this->connector->setLogger($logger);
        $this->expectException(\Exception::class);
        $this->connector->sendNotification($notification);
    }

    public function testLogger()
    {
        $data = ['data' => uniqid()];
        $uri = uniqid();
        $content = uniqid();

        $notification = $this->createMock(NotificationInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $notification->expects(self::once())->method('getUri')->willReturn($uri);
        $notification->expects(self::once())->method('getData')->willReturn($data);
        $this->client->expects(self::once())->method('request')
            ->with(
                GuzzleConnector::HTTP_METHOD_POST,
                $uri,
                [
                    RequestOptions::JSON => $data,
                    RequestOptions::TIMEOUT => GuzzleConnector::DEFAULT_TIMEOUT,
                ]
            )
            ->willReturn($response);
        $response->expects(self::once())->method('getBody')->willReturn($stream);
        $stream->expects(self::once())->method('getContents')->willReturn($content);
        $logger->expects(self::once())->method('info')->with($content);

        $this->connector->setLogger($logger);
        $this->connector->sendNotification($notification);
    }
}
