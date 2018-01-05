<?php

namespace Vallbo\SlackNotification\Adapter;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Vallbo\SlackNotification\Notification\NotificationInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

/**
 * Class GuzzleConnector
 * @author Vladimir Bosiak <info@vallbo.net>
 */
class GuzzleConnector implements ConnectorInterface
{

    const DEFAULT_TIMEOUT = 10;
    const HTTP_METHOD_POST = 'POST';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var int
     */
    private $timeout;

    /**
     * GuzzleConnector constructor.
     * @param ClientInterface $client
     * @param int $timeout
     */
    public function __construct(ClientInterface $client, $timeout = self::DEFAULT_TIMEOUT)
    {
        $this->client = $client;
        $this->logger = new NullLogger();
        $this->timeout = $timeout;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param NotificationInterface $notification
     * @throws \Exception
     */
    public function sendNotification(NotificationInterface $notification)
    {
        $options = [];
        $options[RequestOptions::JSON] = $notification->getData();
        if ($this->timeout !== null) {
            $options[RequestOptions::TIMEOUT] = $this->timeout;
        }

        try {
            $response = $this->client->request(
                self::HTTP_METHOD_POST,
                $notification->getUri(),
                $options
            );
        } catch (ClientException $exception) {
            $this->logger->warning($exception);
            throw $exception;
        } catch (\Exception $exception) {
            $this->logger->critical($exception);
            throw $exception;
        }
        $this->logger->info($response->getBody()->getContents());
    }
}
