<?php

namespace Vallbo\SlackNotification\Notification;

/**
 * Interface NotificationInterface
 * @author Vladimir Bosiak <info@vallbo.net>
 */
interface NotificationInterface
{

    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return array
     */
    public function getData(): array;
}
