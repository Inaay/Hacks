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

class HackVelocityForm implements Form {

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
				if ($hackPlugin->hasVelocity($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Velocity is already enabled");
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have enabled Velocity. H: " . TextFormat::BLUE . "0.35 " . TextFormat::GREEN . "V: " . TextFormat::BLUE . "0.35");
					$hackPlugin->enableVelocity($player, (float) 0.35, (float) 0.35);
				}
				break;
			case 1:
				if ($hackPlugin->hasVelocity($player)) {
					$player->sendForm(new HackVelocityModifyForm($player, (float) Main::getInstance()->getVelocityHorizontal($player), (float) Main::getInstance()->getVelocityVertical($player)));
				} else {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Velocity is not enabled");
				}
				break;
			case 2:
				if (!$hackPlugin->hasVelocity($player)) {
					$player->sendMessage(Main::PREFIX . TextFormat::RED . "Velocity is not enabled");
				} else {
					$hackPlugin->disableVelocity($player);
					$player->sendMessage(Main::PREFIX . TextFormat::GREEN . "You have disabled Velocity.");
				}
				break;
		}
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array {
		return [
			"type" => "form",
			"title" => TextFormat::GRAY . "Velocity",
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
				]
			]
		];
	}
}