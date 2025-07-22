<?php

declare(strict_types=1);

namespace Anthhyo\Discord\Message;

use JsonSerializable;

class DiscordMessage implements JsonSerializable {

	protected ?string $content = null;
	protected ?string $avatar = null;
	protected ?string $username = null;
	protected bool $tts = false;
	protected array $embeds = [];

	public function jsonSerialize(): array {
		return [
			'content'    => $this->content,
			'avatar_url' => $this->avatar,
			'username'   => $this->username,
			'tts'        => $this->tts,
			'embeds'     => $this->embeds,
		];
	}

	public function getContent(): ?string {
		return $this->content;
	}

	public function setContent(string $content): static {
		$this->content = $content;

		return $this;
	}

	public function getAvatar(): ?string {
		return $this->avatar;
	}

	public function setAvatar(string $avatar): static {
		$this->avatar = $avatar;

		return $this;
	}

	public function getUsername(): ?string {
		return $this->username;
	}

	public function setUsername(string $username): static {
		$this->username = $username;

		return $this;
	}

	public function isTts(): bool {
		return $this->tts;
	}

	public function setTts(bool $tts): static {
		$this->tts = $tts;

		return $this;
	}

	public function getEmbeds(): array {
		return $this->embeds;
	}

	public function setEmbeds(array $embeds): static {
		$this->embeds = $embeds;

		return $this;
	}

	public function getFirstEmbed(): DiscordEmbed {
		return $this->embeds[0];
	}

	public function addEmbed(DiscordEmbed $embed): static {
		$this->embeds[] = $embed;

		return $this;
	}

	public function removeEmbed(string $title): bool {
		foreach ($this->embeds as $key => $embed) {
			if ($embed['name'] === $title) {
				unset($this->embeds[$key]);

				return true;
			}
		}

		return false;
	}

	public function getEmbed(string $title): array {
		return $this->findEmbedByTitle($title);
	}

	protected function findEmbedByTitle(string $title): array {
		foreach ($this->embeds as $embed) {
			if ($embed['title'] === $title) {
				return $embed;
			}
		}

		return [];
	}

}
