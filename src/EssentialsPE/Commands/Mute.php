<?php
namespace EssentialsPE\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

use EssentialsPE\API\Sessions;

class Mute extends Command{
    public $sessions;
    
    /** @return Mute */
    public static function get(Player $player){
        return $this->sessions[$player];
    }
    
    public static function set(Player $player){
        return $this->sessions[$player];
    }

    public function __construct() {
        parent::__construct("mute", "Mute/unmute a player", "/mute <player>", ["silence"]);
        $this->setPermission("essentials.mute.use");
        
        $this->file = new Sessions();
    }
    
    public function execute(CommandSender $sender, $alias, array $args) {
        if(!$this->testPermission($sender)){
            return false;
        }
        if(count($args) == 0 || count($args) > 1){
            $sender->sendMessage(TextFormat::RED . "Usage: " . $this->getUsage());
        }else{
            if(!$args[0] instanceof Player){
                $sender->sendMessage(TextFormat::RED . "[Error] Player not found.");
            }else{
                if(!$this->file->exists($args[0])){
                    $this->file->set($args[0]);
                    $sender->sendMessage(TextFormat::YELLOW . "$args[0] has been muted!");
                }else{
                    $this->file->remove($args[0]);
                    $sender->sendMessage(TextFormat::YELLOW . "$args[0] has been unmuted!");
                }
            }
        }
    }
}
