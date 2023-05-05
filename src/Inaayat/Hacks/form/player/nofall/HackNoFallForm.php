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

namespace Inaayat\Hacks\form\player\nofall;

use Inaayat\Hacks\form\player\PlayerForm;
use Inaayat\Hacks\Main;
use pocketmine\form\Form;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HackNoFallForm implements Form {

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
				if ($hackPlugin->hasNoFall($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "NoFall is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled NoFall. Percentage: " . TextFormat::BLUE . "50%");
					$hackPlugin->enableNoFall($player, 50);
				}
				break;
			case 1:
				if ($hackPlugin->hasNoFall($player)) {
					$player->sendForm(new HackNoFallModifyForm($player, (int) Main::getInstance()->getNoFallPercentage($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "NoFall is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasNoFall($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "NoFall is not enabled");
				} else {
					$hackPlugin->disableNoFall($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled NoFall.");
				}
				break;
			case 3:
				$player->sendForm(new PlayerForm($player));
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "form",
			"title" => TextFormat::GRAY . "NoFall",
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