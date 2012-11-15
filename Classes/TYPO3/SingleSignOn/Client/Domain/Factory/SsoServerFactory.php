<?php
namespace TYPO3\SingleSignOn\Client\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.SingleSignOn.Client".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\SingleSignOn\Client\Exception;

/**
 * A SSO server factory
 *
 * @Flow\Scope("singleton")
 */
class SsoServerFactory {

	/**
	 * @var array
	 */
	protected $serverConfigurations = array();

	/**
	 * Prepare settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		if (isset($settings['server'])) {
			if (!is_array($settings['server'])) {
				throw new Exception('Invalid TYPO3.SingleSignOn.Client.server configuration', 1351688261);
			}
			$this->serverConfigurations = $settings['server'];
		}
	}

	/**
	 * Build a SSO server instance from settings
	 *
	 * @param string $serverIdentifier
	 * @return \TYPO3\SingleSignOn\Client\Domain\Model\SsoServer
	 */
	public function create($serverIdentifier) {
		if (!isset($this->serverConfigurations[$serverIdentifier]) || !is_array($this->serverConfigurations[$serverIdentifier])) {
			throw new Exception('Invalid configuration for server "' . $serverIdentifier . '" in TYPO3.SingleSignOn.Client.server', 1351688340);
		}
		$serverConfiguration = $this->serverConfigurations[$serverIdentifier];
		$ssoServer = new \TYPO3\SingleSignOn\Client\Domain\Model\SsoServer();
		if (!isset($serverConfiguration['serviceBaseUri']) || (string)$serverConfiguration['serviceBaseUri'] === '') {
			throw new Exception('Missing serviceBaseUri setting in TYPO3.SingleSignOn.Client.server.' . $serverIdentifier, 1352719244);
		}
		$serverConfiguration['serviceBaseUri'] = rtrim($serverConfiguration['serviceBaseUri'], '/');
		$ssoServer->setServiceBaseUri($serverConfiguration['serviceBaseUri']);
		$ssoServer->setEndpointUri($serverConfiguration['serviceBaseUri'] . '/authentication');

		if (!isset($serverConfiguration['publicKeyUuid']) || (string)$serverConfiguration['publicKeyUuid'] === '') {
			throw new Exception('Missing publicKeyUuid setting for TYPO3.SingleSignOn.Client.server.' . $serverIdentifier, 1351688420);
		}
		$ssoServer->setPublicKey($serverConfiguration['publicKeyUuid']);
		if (!isset($serverConfiguration['publicKeyUuid']) || (string)$serverConfiguration['publicKeyUuid'] === '') {
			throw new Exception('Missing publicKeyUuid setting for TYPO3.SingleSignOn.Client.server.' . $serverIdentifier, 1351688420);
		}

		// TODO Set service base URI
		return $ssoServer;
	}

}
?>