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

namespace Inaayat\Hacks\form\combat\hitbox;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackHitboxModifyForm implements Form {

	/** @var Player */
	private $player;
	/** @var float */
	private $currentRange;

	public function __construct(Player $player, float $currentRange) {
		$this->player = $player;
		$this->currentRange = $currentRange;
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
		$range = (float) $data[1];
		$hackPlugin = Main::getInstance();
		$hackPlugin->modifyHitboxRange($this->player, $range);
		$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Hitbox range has been modified to " . TextFormat::BLUE . $range);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "custom_form",
			"title" => TextFormat::GRAY . "Modify Hitbox Range",
			"content" => [
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Current Range: " . TextFormat::BLUE . $this->currentRange
				],
				[
					"type" => "slider",
					"text" => TextFormat::GRAY . "New Range",
					"min" => 0.5,
					"max" => 10.0,
					"step" => 0.5,
					"default" => $this->currentRange
				]
			]
		];
	}
}