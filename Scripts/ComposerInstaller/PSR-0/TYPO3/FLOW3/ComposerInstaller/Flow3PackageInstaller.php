<?php
namespace TYPO3\FLOW3\ComposerInstaller;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Composer\Package\PackageInterface;

/**
 * FLOW3 Installer-class for Composer
 *
 */
class Flow3PackageInstaller extends \Composer\Installer\LibraryInstaller {

	/**
	 * Check whether the package type is supported by this installer
	 *
	 * @param string $packageType
	 * @return bool
	 */
	public function supports($packageType) {
		return ($packageType === 'library' || 0 === strstr($packageType,'flow3'))?TRUE:FALSE;
	}

	/**
	 * Create the FLOW3 compatible install path
	 *
	 * @param \Composer\Package\PackageInterface $package
	 * @return string
	 */
	public function getInstallPath(PackageInterface $package) {
		$autoloadDefinition = $package->getAutoload();
		if(isset($autoloadDefinition['psr-0'])) {
			$namespace = key($autoloadDefinition['psr-0']);
			$FLOW3StylePackageKey = str_replace('\\','.',$namespace);
		} else {
			$FLOW3StylePackageKey = $package->getName();
		}
		if($FLOW3StylePackageKey === 'Composer') {
			//Composer will not work unless it has 2 levels to the config files
			$FLOW3StylePackageKey = 'composer/composer';
		}
		return $this->vendorDir . '/' . $FLOW3StylePackageKey;
	}
}
