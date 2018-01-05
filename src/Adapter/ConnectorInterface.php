<?php

namespace Vallbo\SlackNotification\Adapter;

use Vallbo\SlackNotification\Notification\NotificationInterface;

/**
 * Interface ConnectorInterface
 * @author Vladimir Bosiak <info@vallbo.net>
 */
interface ConnectorInterface
{

    public function sendNotification(NotificationInterface $notification);
}
