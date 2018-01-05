# Slack Incoming WebHooks Messages

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
