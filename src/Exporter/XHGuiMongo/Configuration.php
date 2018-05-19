<?php
declare(strict_types=1);

namespace XHProfExporter\Exporter\XHGuiMongo;

class Configuration
{
    /**
     * @var string
     */
    private $mongoConnectionString;

    /**
     * @var string
     */
    private $mongoDatabase;
    /**
     * @var string
     */
    private $mongoCollection;

    public function __construct(
        string $mongoConnectionString = '127.0.0.1',
        string $mongoDatabase = 'xhgui',
        string $mongoCollection = 'results'
    ) {
        $this->mongoConnectionString = $mongoConnectionString;
        $this->mongoDatabase = $mongoDatabase;
        $this->mongoCollection = $mongoCollection;
    }

    public function getMongoConnectionString(): string
    {
        return $this->mongoConnectionString;
    }

    public function getMongoDatabase(): string
    {
        return $this->mongoDatabase;
    }

    public function getMongoCollection(): string
    {
        return $this->mongoCollection;
    }

    /**
     * Can be used to partially override default configuration
     *
     * @param string $mongoConnectionString
     */
    public function setMongoConnectionString(string $mongoConnectionString)
    {
        $this->mongoConnectionString = $mongoConnectionString;
    }

    /**
     * Can be used to partially override default configuration
     *
     * @param string $mongoDatabase
     */
    public function setMongoDatabase(string $mongoDatabase)
    {
        $this->mongoDatabase = $mongoDatabase;
    }

    /**
     * Can be used to partially override default configuration
     *
     * @param string $mongoCollection
     */
    public function setMongoCollection(string $mongoCollection)
    {
        $this->mongoCollection = $mongoCollection;
    }
}