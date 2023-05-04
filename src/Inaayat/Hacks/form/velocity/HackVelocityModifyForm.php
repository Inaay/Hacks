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

namespace Inaayat\Hacks\form\velocity;

use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackVelocityModifyForm implements Form {

	/** @var Player */
	private $player;

	/** @var float */
	private $horizontal;

	/** @var float */
	private $vertical;

	public function __construct(Player $player, float $horizontal, float $vertical) {
		$this->player = $player;
		$this->horizontal = $horizontal;
		$this->vertical = $vertical;
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
		$h = (float) $data[2];
		$v = (float) $data[3];
		$hackPlugin = Main::getInstance();
		$hackPlugin->modifyVelocityHorizontal($this->player, $h);
		$hackPlugin->modifyVelocityVertical($this->player, $v);
		$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "Velocity value has been modified to H: " . TextFormat::BLUE . $h . TextFormat::GREEN . " V: " . TextFormat::BLUE . $v);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "custom_form",
			"title" => TextFormat::GRAY . "Modify Velocity Values",
			"content" => [
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Current Velocity: H: " . TextFormat::BLUE . $this->horizontal . TextFormat::GRAY . " V: " . TextFormat::BLUE . $this->vertical
				],
				[
					"type" => "label",
					"text" => TextFormat::GRAY . "Default Velocity H: " . TextFormat::BLUE . "0.4" . TextFormat::GRAY . " V: " . TextFormat::BLUE . "0.4"
				],
				[
					"type" => "slider",
					"text" => TextFormat::GRAY . "Horizontal Value",
					"min" => 0.0,
					"max" => 0.4,
					"step" => 0.1,
					"default" => $this->horizontal
				],
				[
					"type" => "slider",
					"text" => TextFormat::GRAY . "Vertical Value",
					"min" => 0.0,
					"max" => 0.4,
					"step" => 0.1,
					"default" => $this->vertical
				]
			]
		];
	}
}