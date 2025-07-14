<?php

namespace App\Traits;

use App\Services\PerfectWorldService;

trait ChecksOnlineStatus
{
    /**
     * Check if a role is online using the most efficient method
     * 
     * @param int $roleId
     * @return bool
     */
    protected function checkOnline($roleId)
    {
        $service = app(PerfectWorldService::class);
        return $service->isRoleOnline($roleId);
    }

    /**
     * Check if multiple roles are online
     * 
     * @param array $roleIds
     * @return array
     */
    protected function checkMultipleOnline(array $roleIds)
    {
        $service = app(PerfectWorldService::class);
        return $service->checkMultipleRolesOnline($roleIds);
    }

    /**
     * Get the full online list
     * 
     * @return array
     */
    protected function getOnlineList()
    {
        $service = app(PerfectWorldService::class);
        return $service->getOnlineList();
    }
}