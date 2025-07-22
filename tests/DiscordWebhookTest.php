<?php

namespace Anthhyo\Discord\Tests;

use Anthhyo\Discord\DiscordWebhook;
use Anthhyo\Discord\Message\DiscordMessage;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DiscordWebhookTest extends TestCase {
	
	public function testSendCallsCurlAndSucceeds() {
		$logger = $this->createMock(LoggerInterface::class);

		$logger
			->expects($this->never())
			->method('error');

		$webhook = $this->getMockBuilder(DiscordWebhook::class)
			->setConstructorArgs(['https://discordapp.com/api/webhooks/fake/webhookurl', $logger])
			->onlyMethods(['doCurlPost'])
			->getMock();

		$webhook
			->expects($this->once())
			->method('doCurlPost')
			->willReturn('{"id":"12345"}');

		$message = new DiscordMessage();
		$message->setContent('Test message');

		$webhook->send($message);

		$this->assertTrue(true); // No exceptions means success
	}

	public function testSendLogsErrorOnCurlFailure() {
		$logger = $this->createMock(LoggerInterface::class);

		$logger
			->expects($this->once())
			->method('error')
			->with($this->stringContains('Failed to send Discord message'));

		$webhook = $this
			->getMockBuilder(DiscordWebhook::class)
			->setConstructorArgs(['https://discordapp.com/api/webhooks/fake/webhookurl', $logger])
			->onlyMethods(['doCurlPost'])
			->getMock();

		$webhook
			->expects($this->once())
			->method('doCurlPost')
			->willReturn(false);

		$message = new DiscordMessage();
		$message->setContent('Test message');

		$webhook->send($message);
	}

	public function testSendLogsException() {
		$logger = $this->createMock(LoggerInterface::class);

		$logger
			->expects($this->once())
			->method('error')
			->with($this->stringContains('Exception sending Discord message'));

		$webhook = $this
			->getMockBuilder(DiscordWebhook::class)
			->setConstructorArgs(['https://discordapp.com/api/webhooks/fake/webhookurl', $logger])
			->onlyMethods(['doCurlPost'])
			->getMock();

		$webhook
			->expects($this->once())
			->method('doCurlPost')
			->willThrowException(new Exception('Curl error'));

		$message = new DiscordMessage();
		$message->setContent('Test message');

		$webhook->send($message);
	}
	
}
