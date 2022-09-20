<?php

namespace Transip\Api\Library\Repository\Haip;

use Transip\Api\Library\Entity\Vps\IpAddress;
use Transip\Api\Library\Repository\ApiRepository;
use Transip\Api\Library\Repository\HaipRepository;

class IpAddressRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'ip-addresses';

    /**
     * @return string[]
     */
    protected function getRepositoryResourceNames(): array
    {
        return [HaipRepository::RESOURCE_NAME, self::RESOURCE_NAME];
    }

    /**
     * @param string $haipName
     * @return string[]
     */
    public function getByHaipName(string $haipName): array
    {
        $response         = $this->httpClient->get($this->getResourceUrl($haipName));
        $ipAddressesArray = $this->getParameterFromResponse($response, 'ipAddresses');

        return $ipAddressesArray;
    }

    /**
     * @param string $haipName
     * @param string[] $ipAddresses
     * @return void
     */
    public function update(string $haipName, array $ipAddresses): void
    {
        $url = $this->getResourceUrl($haipName);
        $this->httpClient->put($url, ['ipAddresses' => $ipAddresses]);
    }

    public function delete(string $haipName): void
    {
        $url = $this->getResourceUrl($haipName);
        $this->httpClient->delete($url);
    }
}
