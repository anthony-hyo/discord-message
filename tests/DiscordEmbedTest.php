<?php

use Anthhyo\Discord\Message\DiscordEmbed;
use PHPUnit\Framework\TestCase;

class DiscordEmbedTest extends TestCase {
	
	public function testTitleSetterAndGetter() {
		$embed = new DiscordEmbed();
		$embed->setTitle("Teste");

		$this->assertSame("Teste", $embed->getTitle());
	}

	public function testAddField() {
		$embed = new DiscordEmbed();
		$embed->addField("Campo 1", "Valor 1");

		$this->assertCount(1, $embed->getFields());
		$this->assertEquals("Campo 1", $embed->getFields()[0]['name']);
	}

	public function testColorFromHex() {
		$embed = new DiscordEmbed();
		$embed->setColorWithHexValue("#FF0000");

		$this->assertEquals(16711680, $embed->getColor()); // 0xFF0000
	}
	
}
