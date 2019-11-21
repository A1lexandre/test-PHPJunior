<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RouteService;
use App\Validators\RouteValidator;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;

class RouteController extends Controller
{

    protected $service;
    protected $validator;

    public function __construct(RouteService $routeService, RouteValidator $routeValidator) {

      $this->service = $routeService;
      $this->validator = $routeValidator;

    }

    public function getBestRoute(Request $request) {

      $validator = Validator::make($request->query(), 
                            $this->validator->rules(),
                            $this->validator->messages());

      if ($validator->fails()) {
        return response($validator->errors(), 400);
      }      

      $dados = $this->service->calcMinRoute($request->query());

      return response($dados, 200);

    }
}
