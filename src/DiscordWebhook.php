<?php

namespace Anthhyo\Discord;

use Anthhyo\Discord\Message\DiscordMessage;
use Psr\Log\LoggerInterface;
use Exception;

class DiscordWebhook {

	private ?LoggerInterface $logger;

	public function __construct(
		private readonly string $webhookUrl,
		?LoggerInterface $logger = null
	) {
		$this->logger = $logger;
	}

	public function send(DiscordMessage $message, bool $wait = true): void {
		$url = $this->webhookUrl . (str_contains($this->webhookUrl, '?') ? '&' : '?') . 'wait=' . ($wait ? 'true' : 'false');

		try {
			$response = $this->doCurlPost($url, json_encode($message));

			if ($response === false) {
				$this->logError("Failed to send Discord message: cURL execution failed.");
				return;
			}
		} catch (Exception $e) {
			$this->logError('Exception sending Discord message: ' . $e->getMessage());
		}
	}

	/**
	 * This method performs the actual cURL request.
	 * It is protected so it can be overridden in tests.
	 */
	protected function doCurlPost(string $url, string $payload): string|false {
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	private function logError(string $message): void {
		if ($this->logger) {
			$this->logger->error($message);
			return;
		}
		
		error_log($message);
	}
	
}
