<?php



/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\SavesConfigSettings;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;

class ServiceController extends Controller
{
    use SavesConfigSettings;
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $services = Service::all();

        foreach ($services as $service) {
            $request->validate([
                $service->key . '_price' => 'required|numeric'
            ]);
            $service->enabled = $request->has($service->key . '_enabled');
            $service->price = $request->{$service->key . '_price'};
            $service->save();
        }

        return redirect(route('service.index'))->with('success', __('service.config_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequest $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }

    public function settings()
    {
        return view('admin.service.settings');
    }

    public function updateSettings(ServiceRequest $request)
    {
        $configs = $request->except('_token');
        
        // Prepare settings with pw-config prefix
        $settings = [];
        foreach ($configs as $config => $value) {
            $settings['pw-config.' . $config] = $value;
        }
        
        // Write all settings at once
        $this->writeConfigMany($settings);
        
        // Clear and re-cache config after all writes are complete
        \Artisan::call('config:clear');
        \Artisan::call('config:cache');
        
        // Simple redirect back with query parameter
        $url = url()->previous();
        if (strpos($url, '?') !== false) {
            $url .= '&saved=1';
        } else {
            $url .= '?saved=1';
        }
        
        return redirect($url);
    }
}
