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

namespace Inaayat\Hacks\command;

use Inaayat\Hacks\form\HackForm;
use Inaayat\Hacks\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\utils\TextFormat;

class HackCommand extends Command implements PluginOwned {

	public function __construct() {
		parent::__construct("hacks", "Server-side hacks", "/hacks", ["hack", "cheat"]);
		$this->setPermission("hacks.command");
	}

	/**
	 * @param CommandSender $sender
	 * @param string $commandLabel
	 * @param array $args
	 * 
	 * @return bool
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
		if ($sender instanceof Player) {
			$sender->sendForm(new HackForm($sender));
		} else {
			$sender->sendMessage(Main::PREFIX . TextFormat::RED . "You must be in-game to use this command!");
		}
		return true;
	}

	/**
	 * @return Main
	 */
	public function getOwningPlugin(): Main {
		return Main::getInstance();
	}
}