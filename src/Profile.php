<?php

namespace XHProfExporter;

class Profile
{
    /**
     * @var array
     */
    private $profileData;

    public function __construct(array $profileData)
    {
        $this->profileData = $profileData;
    }

    public function getProfileData(): array
    {
        return $this->profileData;
    }

}