<?php
declare(strict_types=1);

namespace XHProfExporter\Exporter\XHGuiMongo;

use MongoDB\Client;
use XHProfExporter\Exporter\ExporterInterface;
use XHProfExporter\Profile;

class Exporter implements ExporterInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var \MongoDB\Collection
     */
    private $collection;

    /**
     * @var DataCollector
     */
    private $dataCollector;

    /**
     * Can be used to partially override default configuration
     *
     * @return Configuration
     */
    public static function getDefaultConfiguration(): Configuration
    {
        return new Configuration();
    }

    public function __construct(Configuration $configuration = null, DataCollector $dataCollector = null)
    {
        if (is_null($configuration)) {
            $configuration = self::getDefaultConfiguration();
        }
        $this->client = new Client( $configuration->getMongoConnectionString());
        $this->collection = $this->client->{$configuration->getMongoDatabase()}->results;
        if (is_null($dataCollector)) {
            $dataCollector = new DataCollector();
        }
        $this->dataCollector = $dataCollector;
    }

    /**
     * {@inheritdoc}
     */
    public function exportProfile(Profile $profile): void
    {
        $this->collection->insertOne($this->dataCollector->collectProfileInformation($profile));
    }
}