<?php

namespace App\Services;

use hrace009\PerfectWorldAPI\API;
use Illuminate\Support\Facades\Cache;

class PerfectWorldService
{
    protected $api;
    protected $onlineCache = [];
    protected $cacheTime = 30; // Cache for 30 seconds

    public function __construct()
    {
        $this->api = new API();
    }

    /**
     * Check if a specific role is online using the most efficient method available
     * 
     * @param int $roleId
     * @return bool
     */
    public function isRoleOnline($roleId)
    {
        // Method 1: Try using getRoleStatus (most efficient if it works)
        $statusCheck = $this->checkRoleStatusMethod($roleId);
        if ($statusCheck !== null) {
            return $statusCheck;
        }

        // Method 2: Use cached online list (fallback method)
        return $this->checkOnlineListMethod($roleId);
    }

    /**
     * Check online status using getRoleStatus method
     * This is more efficient as it only queries one specific role
     * 
     * @param int $roleId
     * @return bool|null Returns null if method fails
     */
    protected function checkRoleStatusMethod($roleId)
    {
        try {
            // Check if server is online first
            if (!$this->api->online) {
                return false;
            }

            // Try to get role status
            $roleStatus = $this->api->getRoleStatus($roleId);
            
            // Check various indicators that might show online status
            if (is_array($roleStatus)) {
                // worldtag > 0 usually means the player is in a world/map (online)
                if (isset($roleStatus['worldtag']) && $roleStatus['worldtag'] > 0) {
                    return true;
                }
                
                // Check if there's a position set (another indicator of being online)
                if (isset($roleStatus['posx']) && isset($roleStatus['posy']) && isset($roleStatus['posz'])) {
                    // If all positions are not zero, player is likely online
                    if ($roleStatus['posx'] != 0 || $roleStatus['posy'] != 0 || $roleStatus['posz'] != 0) {
                        return true;
                    }
                }
                
                // If we got a valid response but no clear online indicators, assume offline
                return false;
            }
        } catch (\Exception $e) {
            // If getRoleStatus fails, return null to try fallback method
            \Log::debug('getRoleStatus failed for role ' . $roleId . ': ' . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Check online status using the full online list (less efficient fallback)
     * 
     * @param int $roleId
     * @return bool
     */
    protected function checkOnlineListMethod($roleId)
    {
        // Check if server is online
        if (!$this->api->online) {
            return false;
        }

        // Use cached online list if available
        $cacheKey = 'pw_online_list';
        $onlineList = Cache::remember($cacheKey, $this->cacheTime, function () {
            return $this->api->getOnlineList();
        });

        // Check if role is in online list
        foreach ($onlineList as $player) {
            if ($player['roleid'] == $roleId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get full online list with caching
     * 
     * @return array
     */
    public function getOnlineList()
    {
        if (!$this->api->online) {
            return [];
        }

        $cacheKey = 'pw_online_list';
        return Cache::remember($cacheKey, $this->cacheTime, function () {
            return $this->api->getOnlineList();
        });
    }

    /**
     * Get online status for multiple roles efficiently
     * 
     * @param array $roleIds
     * @return array Associative array with roleId => bool
     */
    public function checkMultipleRolesOnline(array $roleIds)
    {
        $results = [];
        
        // If server is offline, all roles are offline
        if (!$this->api->online) {
            foreach ($roleIds as $roleId) {
                $results[$roleId] = false;
            }
            return $results;
        }

        // Get the full online list once
        $onlineList = $this->getOnlineList();
        
        // Create a hash map for O(1) lookup
        $onlineMap = [];
        foreach ($onlineList as $player) {
            $onlineMap[$player['roleid']] = true;
        }

        // Check each role
        foreach ($roleIds as $roleId) {
            $results[$roleId] = isset($onlineMap[$roleId]);
        }

        return $results;
    }

    /**
     * Clear online list cache
     */
    public function clearOnlineCache()
    {
        Cache::forget('pw_online_list');
    }

    /**
     * Get server online status
     * 
     * @return bool
     */
    public function isServerOnline()
    {
        return $this->api->online;
    }
}