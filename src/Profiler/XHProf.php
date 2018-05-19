<?php
declare(strict_types=1);

namespace XHProfExporter\Profiler;

use XHProfExporter\Profile;

class XHProf implements ProfilerInterface
{

    public function startProfileCollection()
    {
        xhprof_enable(
            XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY,
            [
                'ignored' => ['call_user_func', 'call_user_func_array'],
            ]
        );
    }

    public function endProfileCollection(): Profile
    {
        return new Profile(xhprof_disable());
    }
}