<?php
/**
 * Refer to LICENSE.txt distributed with the Temando Shipping module for notice of license
 */
namespace Temando\Shipping\Rest\EntityMapper;

use Temando\Shipping\Model\LocationInterface;
use Temando\Shipping\Model\LocationInterfaceFactory;
use Temando\Shipping\Rest\Response\DataObject\Location;

/**
 * Map API data to application data object
 *
 * The location response mapper is responsible for transforming the merchant's
 * locations, i.e. stores, warehouses, etc.
 *
 * @package  Temando\Shipping\Rest
 * @author   Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.temando.com/
 */
class LocationResponseMapper
{
    /**
     * @var LocationInterfaceFactory
     */
    private $locationFactory;

    /**
     * LocationResponseMapper constructor.
     *
     * @param LocationInterfaceFactory $locationFactory
     */
    public function __construct(LocationInterfaceFactory $locationFactory)
    {
        $this->locationFactory = $locationFactory;
    }

    /**
     * Map a merchant location.
     *
     * @param Location $apiLocation
     * @return LocationInterface
     */
    public function map(Location $apiLocation): LocationInterface
    {
        $location = $this->locationFactory->create(['data' => [
            LocationInterface::LOCATION_ID => $apiLocation->getId(),
            LocationInterface::NAME => $apiLocation->getAttributes()->getName(),
            LocationInterface::UNIQUE_IDENTIFIER => $apiLocation->getAttributes()->getUniqueId(),
            LocationInterface::TYPE => $apiLocation->getAttributes()->getType(),
            LocationInterface::STREET => $apiLocation->getAttributes()->getAddress()->getLines(),
            LocationInterface::POSTAL_CODE => $apiLocation->getAttributes()->getAddress()->getPostalCode(),
            LocationInterface::IS_DEFAULT => (bool)$apiLocation->getAttributes()->getIsDefault(),
        ]]);

        return $location;
    }
}
