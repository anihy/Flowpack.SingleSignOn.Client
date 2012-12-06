<?php
namespace TYPO3\SingleSignOn\Client\Domain\Factory;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.SingleSignOn.Client".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\SingleSignOn\Client\Exception;

/**
 * A SSO client factory
 *
 * @Flow\Scope("singleton")
 */
class SsoClientFactory {

	/**
	 * @var string
	 */
	protected $clientServiceBaseUri;

	/**
	 * @var string
	 */
	protected $clientKeyPairUuid;

	/**
	 * Prepare settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		if (isset($settings['client']['serviceBaseUri'])) {
			$this->clientServiceBaseUri = $settings['client']['serviceBaseUri'];
		}
		if (isset($settings['client']['keyPairUuid'])) {
			$this->clientKeyPairUuid = $settings['client']['keyPairUuid'];
		}
	}

	/**
	 * Build a SSO client instance from settings
	 *
	 * Note: Every SSO entry point and authentication provider uses the same SSO client.
	 *
	 * @return \TYPO3\SingleSignOn\Client\Domain\Model\SsoClient
	 */
	public function create() {
		$ssoClient = new \TYPO3\SingleSignOn\Client\Domain\Model\SsoClient();
		if ((string)$this->clientServiceBaseUri === '') {
			throw new Exception('Missing TYPO3.SingleSignOn.Client.client.serviceBaseUri setting', 1351075078);
		}
		$ssoClient->setServiceBaseUri($this->clientServiceBaseUri);
		if ((string)$this->clientKeyPairUuid === '') {
			throw new Exception('Missing TYPO3.SingleSignOn.Client.client.keyPairUuid setting', 1351075159);
		}
		$ssoClient->setKeyPairUuid($this->clientKeyPairUuid);
		return $ssoClient;
	}

}
?>