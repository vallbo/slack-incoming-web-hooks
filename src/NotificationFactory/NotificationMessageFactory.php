<?php

namespace Vallbo\SlackNotification\NotificationFactory;

use Vallbo\SlackNotification\Notification\NotificationInterface;
use Vallbo\SlackNotification\Notification\NotificationMessage;

/**
 * Class NotificationMessageFactory
 * @author Vladimir Bosiak <info@vallbo.net>
 */
class NotificationMessageFactory
{

    /**
     * @var string
     */
    private $uri;

    /**
     * NotificationMessageFactory constructor.
     * @param string $uri
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param string $text
     * @param string|null $channel
     * @param string|null $username
     * @param string|null $icon
     * @return NotificationInterface
     */
    public function createNotificationMessage(
        string $text,
        string $channel = null,
        string $username = null,
        string $icon = null
    ): NotificationInterface {
        $message = new NotificationMessage($this->uri, $text);
        $message->setChannel($channel);
        $message->setUsername($username);
        $message->setIcon($icon);
        return $message;
    }
}
