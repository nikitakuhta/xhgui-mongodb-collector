### Easy-to-use XHProf data collector & exporter.

This library can be used to collect profiles and save them to any external storage (like XHGui database).
At the moment it can be used to export xhprof profiles to XHGui MongoDB database. Library can be extended with any custom profile or exporter.

Example of use:
```php
<?php

use XHProfExporter\Exporter\XHGuiMongo\Configuration;
use XHProfExporter\Exporter\XHGuiMongo\Exporter;
use XHProfExporter\XHProfExporter;

// create XHProf exporter instance with appropriate settings 
$collector = new XHProfExporter(
    new Exporter(
        new Configuration('mongodb://mongodbhost:27017', 'xhprof', 'results')
    )
);
$collector->startProfileCollection();
        
// request execution

// flush collected xhprof profile to XHGui database
$collector->flushProfile();
```

You can extend library, using your own exporters and profilers. Just use your implementation in XHProfExporter constuctor, or override existing exporter and profiler.

#### Extend profiler
You can override profiler, if you need (e.g. if you use another implementation of xhprof, like `tideways_xhprof` or `uprofiler`);
Example:
```php
<?php

use XHProfExporter\Profile;
use XHProfExporter\Profiler\ProfilerInterface;

/*
 * Create your custom profiler
 */
class Uprofiler implements ProfilerInterface
{

    public function startProfileCollection()
    {
        uprofiler_enable();
    }

    public function endProfileCollection(): Profile
    {
        return new Profile(uprofiler_disable());
    }
}

$collector = new XHProfExporter(
    new Exporter(
        new Configuration('mongodb://mongodbhost:27017')
    ),
    new Uprofiler() // use your custom profiler in XHProfExporter
);
$collector->startProfileCollection();
        
```

#### Extend exporter
You can create your own exporter and use in XHProfExporter class, if your custom class will implement `namespace XHProfExporter\Exporter\ExporterInterface`. Due to this you can export any data in any GUI tool. 

Also you can override default DataCollector, that collects additional data for XHGui (like url, execution time e.t.c.).
Example:
```php
<?php

use XHProfExporter\Exporter\XHGuiMongo\Configuration;
use XHProfExporter\Exporter\XHGuiMongo\DataCollector;
use XHProfExporter\Exporter\XHGuiMongo\Exporter;
use XHProfExporter\Profile;
use XHProfExporter\XHProfExporter;


// override default data collector, or create a new one, implements DataCollectorInterface
class CustomDataCollector extends DataCollector
{
    public function collectProfileInformation(Profile $profile): array
    {
        $data = parent::collectProfileInformation($profile);
        $data['additional_information'] = 'some additional information';
        return $data;
    }
}

$collector = new XHProfExporter(
    new Exporter(
        new Configuration('mongodb://mongodbhost:27017'),
        new CustomDataCollector() // pass your custom data collector to Exporter
    )
);
$collector->startProfileCollection();
```

### Laravel middleware example with XHProf and XHGui
```php
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use XHProfExporter\Exporter\XHGuiMongo\Configuration;
use XHProfExporter\Exporter\XHGuiMongo\Exporter;
use XHProfExporter\XHProfExporter;

class Xhprof extends Middleware
{
    public function handle($request, \Closure $next)
    {
        $collector = new XHProfExporter(
            new Exporter(
                new Configuration('mongodb://mongodbhost:27017', 'xhprof')
            )
        );
        $collector->startProfileCollection();

        $result = $next($request);
        $collector->flushProfile();
        return $result;
    }
}
```
Just add this middleware to Kernel.php, and then all your requests will be logged into XHGui.
