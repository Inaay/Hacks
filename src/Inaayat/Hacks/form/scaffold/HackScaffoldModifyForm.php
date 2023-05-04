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

namespace Inaayat\Hacks\form\scaffold;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackScaffoldModifyForm implements Form {

	/** @var Player */
	private $player;
	/** @var int */
	private $currentExtend;

	public function __construct(Player $player, int $currentExtend) {
		$this->player = $player;
		$this->currentExtend = $currentExtend;
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
		$extend = (int) $data[1];
		$hackPlugin = Main::getInstance();
		$hackPlugin->modifyScaffoldExtend($this->player, $extend);
		$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Scaffold extend has been modified to " . TextFormat::BLUE . $extend);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "custom_form",
			"title" => TextFormat::GRAY . "Extend is coming soon this does nothing right now", // TextFormat::GRAY . "Modify Scaffold Extend"
			"content" => [
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Current Extend: " . TextFormat::BLUE . $this->currentExtend
				],
				[
					"type" => "slider",
					"text" => TextFormat::GRAY . "New Extend",
					"min" => 2.0,
					"max" => 10.0,
					"step" => 1,
					"default" => $this->currentExtend
				]
			]
		];
	}
}