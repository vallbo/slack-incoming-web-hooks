<?php

namespace Vallbo\SlackNotification\Notification;

/**
 * Class NotificationMessage
 * @author Vladimir Bosiak <info@vallbo.net>
 */
class NotificationMessage implements NotificationInterface
{

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string|null
     */
    private $channel;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $icon;

    /**
     * NotificationMessage constructor.
     * @param string $uri
     * @param string $text
     */
    public function __construct(string $uri, string $text)
    {
        $this->uri = $uri;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return null|string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param null|string $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return null|string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param null|string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return null|string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param null|string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $payload = ['text' => $this->text];
        if (null !== $this->channel) {
            $payload['channel'] = $this->channel;
        }
        if (null !== $this->username) {
            $payload['username'] = $this->username;
        }
        if (null !== $this->icon) {
            $payload['icon_emoji'] = $this->icon;
        }
        return $payload;
    }
}
