<?php
namespace TYPO3\FLOW3\Composer;

use Composer\Script\Event;
use TYPO3\FLOW3\Utility\Files;

class InstallerScripts
{
	static public function postUpdateAndInstall(Event $event) {
		Files::createDirectoryRecursively('Configuration');
		Files::copyDirectoryRecursively('Packages/Framework/TYPO3.FLOW3/Resources/Private/Installer', '.');
	}

}