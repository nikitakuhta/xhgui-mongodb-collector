### Simple XHProf data exporter.

Now it can be used to export xhprof profiles to XHGui MongoDB database. Easy to use in middleware.

Example:
```php
use XHProfExporter\Exporter\XHGuiMongo\Configuration;
use XHProfExporter\Exporter\XHGuiMongo\Exporter;
use XHProfExporter\XHProfExporter;

// create XHProf exporter instance with appropriate settings 
$collector = new XHProfExporter(
    new Exporter(
        new Configuration('mongodb://mongo_url:27017', 'xhprof')
    )
);
$collector->startProfileCollection();
        
// request execution

// flush collected xhprof profile to XHGui database
$collector->flushProfile();
```

You can extend library, using your own exporters and profilers. Just use your implementation in XHProfExporter constuctor, or override existing exporter and profiler.
