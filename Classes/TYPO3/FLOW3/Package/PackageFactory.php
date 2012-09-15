<?php
namespace TYPO3\FLOW3\Package;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Utility\Files;

class PackageFactory {

	public static function buildPackage($packagesBasePath, $manifestPath, $packageKey, $classesPath) {
		$packageClassPathAndFilename = Files::concatenatePaths(array($packagesBasePath, $manifestPath, 'Classes/' . str_replace('.','/',$packageKey) . '/Package.php'));
		if (file_exists($packageClassPathAndFilename)) {
			require_once($packageClassPathAndFilename);
			/**
			 * @todo there should be a general method for getting Namespace from $packageKey
			 * @todo it should be tested if the package class implements the interface
			 */
			$packageClassName = str_replace('.', '\\', $packageKey) . '\Package';
			if (!class_exists($packageClassName)) {
				throw new \TYPO3\FLOW3\Package\Exception\CorruptPackageException(sprintf('The package "%s" does not contain a valid package class. Check if the file "%s" really contains a class called "%s".', $packageKey, $packageClassPathAndFilename, $packageClassName), 1327587091);
			}
		} else {
			$packageClassName = 'TYPO3\FLOW3\Package\Package';
		}
		$packagePath = Files::concatenatePaths(array($packagesBasePath, $manifestPath)) . '/';

		$package = new $packageClassName($packageKey, $packagePath, $classesPath);
		return $package;
	}

	public static function buildPackageFromStateConfiguration($stateConfiguration) {
	}

	public static function buildStateConfigurationFromPath($packagePath, $packagesBasePath, $currentConfiguration) {

		if (isset($currentConfiguration['state'])) {
			$stateConfiguration['state'] = $currentConfiguration['state'];
		} else {
			$stateConfiguration['state'] = 'active';
		}

		$stateConfiguration['packagePath'] = str_replace($packagesBasePath, '', $packagePath);

		// Change this to read the target from Composer or any other source
		$stateConfiguration['classesPath'] = Package::DIRECTORY_CLASSES;

		return $stateConfiguration;
	}

	/**
	 * @param $manifestPath
	 * @return string
	 */
	public static function getPackageKeyFromManifestPath($manifestPath,$packagesBasePath) {
		$composerJson = file_get_contents($manifestPath . '/composer.json');
		$manifest = json_decode($composerJson);
		if (substr($manifest->type, 0, 6) === 'flow3-') {
			$relativePackagePath = substr($manifestPath, strlen($packagesBasePath));
			$packageKey = substr($relativePackagePath, strpos($relativePackagePath, '/') + 1, -1);
			/**
			 * @todo check that manifest name and directory follows convention
			 */
			/*				if($manifest->name !== strtolower($directoryName)) {
				   throw new \TYPO3\FLOW3\Package\Exception\InvalidPackageKeyException('buuh!');
			   }*/
		} else {
			$packageKey = str_replace('/', '.', $manifest->name);

			if (isset($manifest->autoload) && isset($manifest->autoload->{"psr-0"})) {
				$namespaces = array_keys(get_object_vars($manifest->autoload->{"psr-0"}));
				foreach ($namespaces as $namespace) {
					$namespaceLead = substr($namespace, 0, strlen($manifest->name));
					$dottedNamespaceLead = str_replace('\\', '.', $namespaceLead);
					if (strtolower($dottedNamespaceLead) === $packageKey) {
						$packageKey = $dottedNamespaceLead;
					}
				}
			}
		}
		$packageKey = preg_replace('/[^A-Za-z0-9.]/', '', $packageKey);
		return $packageKey;
	}


}