<?php

namespace XHProfExporter;

use XHProfExporter\Exporter\ExporterInterface;
use XHProfExporter\Profiler\ProfilerInterface;
use XHProfExporter\Profiler\XHProf;

class XHProfExporter
{
    /**
     * @var ExporterInterface
     */
    private $exporter;

    /**
     * @var ProfilerInterface
     */
    private $profiler;

    /**
     * XHProfExporter constructor.
     *
     * Exporter and profiler can be replaces with your implementation, just implement appropriate interfaces
     *
     * @param ExporterInterface|null $exporter
     * @param ProfilerInterface|null $profiler
     */
    public function __construct(
        ExporterInterface $exporter = null,
        ProfilerInterface $profiler = null
    )
    {
        if (is_null($profiler)) {
            $profiler = new XHProf();
        }
        if (is_null($exporter)) {
            $exporter = new Exporter\XHGuiMongo\Exporter();
        }
        $this->profiler = $profiler;
        $this->exporter = $exporter;
    }

    public function startProfileCollection()
    {
        $this->profiler->startProfileCollection();
    }

    public function flushProfile()
    {
        $collectedProfile = $this->profiler->endProfileCollection();
        $this->exporter->exportProfile($collectedProfile);
    }
}