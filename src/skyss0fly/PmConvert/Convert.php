<?php

namespace skyss0fly\PmPluginConversion;

use pocketmine\plugin\PluginBase;
use pocketmine\command\ConsoleCommandSender;

class Main extends PluginBase {
public $code = $Code;
  public function onLoad(): void {

    $this->getLogger("Successfully Loaded PmPluginConversion. usage: /convert PluginName PMAPIVersion");
  }



public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
    if ($command->getName() === "convert") {
        if (count($args) < 2) {
            $sender->sendMessage("Usage: /convert pluginname pmapiversion");
            return false;
        }
        
        $pluginName = $args[0];
        $pmapiversion = $args[1];
        
        // Your code to handle the conversion using $pluginName and $pmapiversion
        
        $sender->sendMessage("Conversion completed successfully!");
        return true;
    }
    
    return false;
}
  
function convertPhp7ToPhp8($code) {
    // Replace deprecated functions
    $code = str_replace("mysql_", "mysqli_", $code);
    
    // Replace deprecated syntax
    $code = preg_replace("/\b(array)\s*\(/", "[$1](", $code);
    
    // Update error handling
    $code = str_replace("set_error_handler", "set_exception_handler", $code);
    
    // Update type declarations
    $code = preg_replace("/\b(int|float|bool|string|resource|object|array|callable|iterable)\b/", "$1", $code);
    
    // Update null coalescing operator
    $code = preg_replace("/\b(\$\w+)\s*\?\?\s*(\$\w+)\b/", "isset($1) ? $1 : $2", $code);
    
    return $code;
}
