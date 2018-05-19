<?php
declare(strict_types=1);

namespace XHProfExporter\Exporter;

use XHProfExporter\Profile;

interface ExporterInterface
{
    public function exportProfile(Profile $profile): void;
}