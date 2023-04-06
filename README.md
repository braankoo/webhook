# Webhook package

## Installation

In root of laravel app create packages folder. ```mdkir packages```

Go to packages and clone this package
```bash
git clone https://github.com/braankoo/webhook.git
```
In composer.json of Laravel app add
``` 
"repositories": [
        {
            "type": "path",
            "url": "./packages/webhook"
        }
    ] 
```

Run ``` composer require brankodragovic/webhook ```

Please publish all assets ```php artisan vendor:publish --provider="BrankoDragovic\Webhook\Providers\WebhookServiceProvider" --tag="config"```

In config folder change webhook.php webhook_url to desired endpoint

## Usage
Use it as :
``` 
public $dispatchesEvents = [
        'updated' => StatusUpdated::class
    ]; 
```
Or
``` 
event(new StatusUpdated($model)) 
```
### Testing

```bash
composer test
```
