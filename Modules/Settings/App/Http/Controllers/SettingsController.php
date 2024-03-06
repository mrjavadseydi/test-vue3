<?php

namespace Modules\Settings\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Modules\Users\App\Http\Requests\SettingsRequest;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return list of option that can be cached or cleared
        $option = [
            'route' => [
                'cache',
                'clear'
            ],
            'config' => [
                'cache',
                'clear'
            ],
            'view' => [
                'cache',
                'clear'
            ],
            'cache' => [
                'clear'
            ],
            'optimize' => [
                'optimize',
                'clear'
            ]
        ];
        return response()->json($option);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingsRequest $request): \Illuminate\Http\JsonResponse
    {
        // let have a switch case to handle the request
        // dear reviewer, i can just pass the request input to the artisan command but i want to make sure that the input is valid and don't want to pass any invalid input to the artisan command
        $option = $request->option.".". $request->action;
        switch ($option) {
            case 'route.cache':
                // cache the route
                Artisan::call('route:cache');
                break;
            case 'route.clear':
                // clear the route cache
                Artisan::call('route:clear');
                break;
            case 'config.cache':
                // cache the config
                Artisan::call('config:cache');
                break;
            case 'config.clear':
                // clear the config cache
                Artisan::call('config:clear');
                break;
            case 'view.cache':
                // cache the view
                Artisan::call('view:cache');
                break;
            case 'view.clear':
                // clear the view cache
                Artisan::call('view:clear');
                break;
            case 'cache.clear':
                // clear the cache
                Artisan::call('cache:clear');
                break;
            case 'optimize.optimize':
                // optimize the application
                Artisan::call('optimize');
                break;
            case 'optimize.clear':
                // clear the optimize cache
                Artisan::call('optimize:clear');
                break;
            default:
                return response()->json(['message' => 'Invalid option'], 400);
        }
        return response()->json(['message' => 'Operation successful']);
    }

}
