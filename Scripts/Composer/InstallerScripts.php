<?php
namespace TYPO3\FLOW3\Composer;

use Composer\Script\Event;

class InstallerScripts
{
	static public function postUpdateAndInstall(Event $event) {
		var_dump($event);
	}
}