<?php

use Anthhyo\Discord\Message\DiscordEmbed;
use Anthhyo\Discord\Message\DiscordMessage;
use PHPUnit\Framework\TestCase;

class DiscordMessageTest extends TestCase {
	
	public function testContentSetterAndGetter() {
		$msg = new DiscordMessage();
		$msg->setContent("Olá mundo!");

		$this->assertSame("Olá mundo!", $msg->getContent());
	}

	public function testAddEmbed() {
		$embed = new DiscordEmbed();
		$embed->setTitle("Título");

		$msg = new DiscordMessage();
		$msg->addEmbed($embed);

		$this->assertCount(1, $msg->getEmbeds());
		$this->assertEquals("Título", $msg->getFirstEmbed()->getTitle());
	}

}
