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

namespace Inaayat\Hacks\form\movement\speed;

use Inaayat\Hacks\form\movement\MovementForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackSpeedForm implements Form {

	/**
	 * @param Player $player
	 * @param mixed $data
	 * 
	 * @return void
	 */
	public function handleResponse(Player $player, $data): void {
		$hackPlugin = Main::getInstance();
		if ($data === null) {
			return;
		}
		switch ($data) {
			case 0:
				if ($hackPlugin->hasSpeed($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Speed is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled Speed. Amount: " . TextFormat::BLUE . "0.5");
					$hackPlugin->enableSpeed($player, (float) 0.5);
				}
				break;
			case 1:
				if ($hackPlugin->hasSpeed($player)) {
					$player->sendForm(new HackSpeedModifyForm($player, (float) Main::getInstance()->getSpeedAmount($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Speed is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasSpeed($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Speed is not enabled");
				} else {
					$hackPlugin->disableSpeed($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled Speed.");
				}
				break;
			case 3:
				$player->sendForm(new MovementForm($player));
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "form",
			"title" => TextFormat::GRAY . "Speed",
			"content" => TextFormat::DARK_RED . "Select an option below:",
			"buttons" => [
				[
					"text" => TextFormat::GREEN . "Enable"
				],
				[
					"text" => TextFormat::BLUE . "Modify"
				],
				[
					"text" => TextFormat::RED . "Disable"
				],
				[
					"text" => TextFormat::DARK_RED . "Go Back",
				]
			]
		];
	}
}