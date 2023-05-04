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

namespace Inaayat\Hacks\form\speed;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackSpeedModifyForm implements Form {

	/** @var Player */
	private $player;
	/** @var float */
	private $currentSpeed;

	public function __construct(Player $player, float $currentSpeed) {
		$this->player = $player;
		$this->currentSpeed = $currentSpeed;
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
		$amount = (float) $data[2];
		$hackPlugin = Main::getInstance();
		$hackPlugin->modifySpeedAmount($this->player, $amount);
		$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Speed amount has been modified to " . TextFormat::BLUE . $amount);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "custom_form",
			"title" => TextFormat::GRAY . "Modify Speed Amount",
			"content" => [
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Current Speed: " . TextFormat::BLUE . $this->currentSpeed
				],
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Default Speed: " . TextFormat::BLUE . "0.10"
				],
				[
					"type" => "slider",
					"text" => TextFormat::GRAY . "New Speed",
					"min" => 0.15,
					"max" => 3.0,
					"step" => 0.1,
					"default" => $this->currentSpeed
				]
			]
		];
	}
}