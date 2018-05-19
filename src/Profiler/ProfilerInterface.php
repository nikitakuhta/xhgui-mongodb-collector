<?php

namespace XHProfExporter\Profiler;

use XHProfExporter\Profile;

interface ProfilerInterface
{
    public function startProfileCollection();
    public function endProfileCollection(): Profile;
}