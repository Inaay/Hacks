<?php

/**
*
*  ██ ███    ██  █████   █████  ██    ██  █████  ████████
*  ██ ████   ██ ██   ██ ██   ██  ██  ██  ██   ██    ██
*  ██ ██ ██  ██ ███████ ███████   ████   ███████    ██
*  ██ ██  ██ ██ ██   ██ ██   ██    ██    ██   ██    ██
*  ██ ██   ████ ██   ██ ██   ██    ██    ██   ██    ██
*
* @author Inaayat
* @link https://github.com/Inaay
*
*/

declare(strict_types=1);

namespace Inaayat\Hacks\form\nuker;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackNukerModifyForm implements Form {

	/** @var Player */
	private $player;

	/** @var int */
	private $currentRadius;

	public function __construct(Player $player, int $currentRadius) {
		$this->player = $player;
		$this->currentRadius = $currentRadius;
	}

	/**
	 * @param Player $player
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public function handleResponse(Player $player, $data): void {
		if ($data === null) {
			return;
		}
		$radius = (int) $data[1];
		$hackPlugin = Main::getInstance();
		$hackPlugin->modifyNukerRadius($this->player, $radius);
		$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Nuker Radius has been modified to " . TextFormat::BLUE . $radius);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "custom_form",
			"title" => TextFormat::GRAY . "Modify Nuker Radius", // TextFormat::GRAY . "Modify Scaffold Extend"
			"content" => [
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Current Radius: " . TextFormat::BLUE . $this->currentRadius
				],
				[
					"type" => "slider",
					"text" => TextFormat::GRAY . "New Radius",
					"min" => 2.0,
					"max" => 10.0,
					"step" => 1,
					"default" => $this->currentRadius
				]
			]
		];
	}
}