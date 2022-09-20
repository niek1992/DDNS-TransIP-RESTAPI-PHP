<?php

namespace Transip\Api\Library\Repository;

use Transip\Api\Library\Entity\TrafficPoolInformation;

class TrafficPoolRepository extends ApiRepository
{
    public const RESOURCE_NAME = 'traffic-pool';

    /**
     * @return TrafficPoolInformation[]
     */
    public function getTrafficPool(): array
    {
        return $this->getByVpsName('');
    }

    /**
     * @param string $vpsName
     * @return TrafficPoolInformation[]
     */
    public function getByVpsName(string $vpsName): array
    {
        $response           = $this->httpClient->get($this->getResourceUrl($vpsName));
        $TrafficDatasArray        = $this->getParameterFromResponse($response, 'trafficPoolInformation');
        $trafficPoolInformation = [];
        foreach ($TrafficDatasArray as $TrafficDataArray) {
            $trafficPoolInformation[] = new TrafficPoolInformation($TrafficDataArray);
        }
        return $trafficPoolInformation;
    }
}
