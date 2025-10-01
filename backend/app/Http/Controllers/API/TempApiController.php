<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TempApiController extends Controller
{
    /**
     * Temporary method untuk handle API yang belum ada
     */
    public function handleMissingMethod($method, $parameters = [])
    {
        $controllerName = class_basename($this);
        $modelName = str_replace('Controller', '', $controllerName);
        
        return response()->json([
            'success' => false,
            'message' => "API method {$method} not implemented yet in {$controllerName}",
            'developer_note' => "Please implement {$method} method in {$controllerName}",
            'temp_data' => [
                'method' => $method,
                'parameters' => $parameters,
                'controller' => $controllerName,
                'suggested_model' => $modelName
            ]
        ], 501); // 501 Not Implemented
    }
    
    // Fallback method untuk semua API calls
    public function __call($method, $parameters)
    {
        if (str_starts_with($method, 'api')) {
            return $this->handleMissingMethod($method, $parameters);
        }
        
        return parent::__call($method, $parameters);
    }
}