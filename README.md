# Slack Incoming WebHooks Messages

## Incoming web hooks help

Help for Slack Web Hook App: <https://api.slack.com/incoming-webhooks>

## Usage example

```php
use Vallbo\SlackNotification\Adapter\GuzzleConnector;
use Vallbo\SlackNotification\NotificationFactory\NotificationMessageFactory;


$factory = new NotificationMessageFactory(
    '<hook URI>'
);

$message = $factory->createNotificationMessage('TEST', 'fun');

$connector = new GuzzleConnector(new \GuzzleHttp\Client());

$connector->sendNotification($message);
```
