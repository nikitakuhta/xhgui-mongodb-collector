<?php
declare(strict_types=1);

namespace XHProfExporter\Exporter;

use XHProfExporter\Profile;

interface DataCollectorInterface
{
    public function collectProfileInformation(Profile $profile): array;
}