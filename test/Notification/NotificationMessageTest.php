<?php

namespace VallboTest\SlackNotification\Notification;

use PHPUnit\Framework\TestCase;
use Vallbo\SlackNotification\Notification\NotificationMessage;

/**
 * Class NotificationMessageTest
 * @author Vladimir Bosiak <info@vallbo.net>
 */
class NotificationMessageTest extends TestCase
{

    public function testAll()
    {
        $uri = uniqid();
        $text = uniqid();
        $channel = uniqid();
        $username = uniqid();
        $icon = uniqid();

        $message = new NotificationMessage($uri, $text);
        $message->setChannel($channel);
        $message->setUsername($username);
        $message->setIcon($icon);

        $this->assertEquals($uri, $message->getUri());
        $this->assertEquals($text, $message->getText());
        $this->assertEquals($channel, $message->getChannel());
        $this->assertEquals($username, $message->getUsername());
        $this->assertEquals($icon, $message->getIcon());
    }
}
