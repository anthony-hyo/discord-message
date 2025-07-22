# Discord Message

**PHP package to create and send Discord messages via webhook**

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

## Overview

This library provides a simple way to create rich Discord messages (with embeds) and send them using Discord webhooks. Designed for PHP 8+ projects, it supports typed properties, JSON serialization, and PSR-3 compatible logging.

---

## Installation

```bash
composer require anthhyo/discord-message
```

---

## Requirements

* PHP 8.0 or higher
* `ext-json`
* `ext-curl`
* PSR-3 compatible logger (optional, default to `NullLogger`)

---

## Usage

### Creating a message

```php
use Anthhyo\Discord\Message\DiscordMessage;
use Anthhyo\Discord\Message\DiscordEmbed;

$message = (new DiscordMessage())
    ->setContent('Hello World!')
    ->setUsername('Bot')
    ->setAvatar('https://example.com/avatar.png');

$embed = (new DiscordEmbed())
    ->setTitle('Embed Title')
    ->setDescription('This is an embed description')
    ->setColorWithHexValue('#FF0000');

$message->addEmbed($embed);
```

### Sending a message via webhook

```php
use Anthhyo\Discord\DiscordWebhook;

$webhook = new DiscordWebhook('https://discord.com/api/webhooks/your_webhook_id/your_webhook_token');

$webhook->send($message);
```

---

## Logging

You can inject your own PSR-3 logger instance in `DiscordWebhook` to capture errors, or it will use a null logger by default.

---

## Running Tests

```bash
composer install
./vendor/bin/phpunit
```

---

## Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the issues page and submit pull requests.

---

## License

This project is licensed under the MIT License.