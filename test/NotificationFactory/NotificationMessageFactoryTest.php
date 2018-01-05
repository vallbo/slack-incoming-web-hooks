<?php

namespace VallboTest\SlackNotification\NotificationFactory;

use PHPUnit\Framework\TestCase;
use Vallbo\SlackNotification\Notification\NotificationMessage;
use Vallbo\SlackNotification\NotificationFactory\NotificationMessageFactory;

/**
 * Class NotificationMessageFactoryTest
 * @author Vladimir Bosiak <info@vallbo.net>
 */
class NotificationMessageFactoryTest extends TestCase
{

    public function testNotificationMessageCreator()
    {
        $uri = uniqid();
        $text = uniqid();
        $channel = uniqid();
        $username = uniqid();
        $icon = uniqid();
        $factory = new NotificationMessageFactory($uri);

        $notification = $factory->createNotificationMessage($text, $channel, $username, $icon);

        $this->assertInstanceOf(NotificationMessage::class, $notification);
        $this->assertEquals($uri, $notification->getUri());
        $this->assertNotEmpty($notification->getData());
    }
}
