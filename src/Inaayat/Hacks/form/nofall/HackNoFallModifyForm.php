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

namespace Inaayat\Hacks\form\nofall;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackNoFallModifyForm implements Form {

	/** @var Player */
	private $player;

	/** @var float */
	private $currentPercentage;

	public function __construct(Player $player, int $currentPercentage) {
		$this->player = $player;
		$this->currentPercentage = $currentPercentage;
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
		$percentage = (int) $data[1];
		$hackPlugin = Main::getInstance();
		$hackPlugin->modifyNoFallPercentage($this->player, $percentage);
		$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "NoFall Percentage has been modified to " . TextFormat::BLUE . $percentage . TextFormat::GREEN . "%");
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "custom_form",
			"title" => TextFormat::GRAY . "Modify NoFall Percentage",
			"content" => [
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Current Percentage: " . TextFormat::BLUE . $this->currentPercentage . TextFormat::GRAY . "%"
				],
				[
					"type" => "slider",
					"text" => TextFormat::GRAY . "New Percentage",
					"min" => 5,
					"max" => 100,
					"step" => 5,
					"default" => $this->currentPercentage
				]
			]
		];
	}
}