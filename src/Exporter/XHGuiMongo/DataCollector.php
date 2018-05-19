<?php
declare(strict_types=1);

namespace XHProfExporter\Exporter\XHGuiMongo;

use MongoDB\BSON\UTCDateTime;
use XHProfExporter\Profile;

class DataCollector
{
    public function collectProfileInformation(Profile $profile): array
    {
        return [
            'profile' => $this->transformProfile($profile->getProfileData()),
            'meta' => [
                'url' => $this->getUri(),
                'SERVER' => $_SERVER,
                'get' => $_GET,
                'env' => $_ENV,
                'request_ts' => $requestTs = new UTCDateTime($time * 1000),
                'request_ts_micro' => $requestTs,
                'request_date' => date('Y-m-d', $time),
            ],
        ];
    }

    private function transformProfile(array $profile): array
    {
        $transformedProfile = [];
        foreach ($profile as $key => $value) {
            $transformedProfile[strtr($key, ['.' => '_'])] = $value;
        }
        return $transformedProfile;
    }

    private function getUri(): string
    {
        $uri = array_key_exists('REQUEST_URI', $_SERVER)
            ? $_SERVER['REQUEST_URI']
            : null;

        if (empty($uri) && isset($_SERVER['argv'])) {
            $cmd = basename($_SERVER['argv'][0]);
            $uri = $cmd . ' ' . implode(' ', array_slice($_SERVER['argv'], 1));
        }
        return $uri;
    }

    private function getTime(): int
    {
        $time = array_key_exists('REQUEST_TIME', $_SERVER)
            ? (int) $_SERVER['REQUEST_TIME']
            : time();
    }

}