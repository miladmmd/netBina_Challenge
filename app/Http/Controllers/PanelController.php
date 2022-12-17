<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class PanelController extends Controller
{

    /**
     * get user that login with relations
     * @return JsonResponse
     */
    public function index()
    {
         return response()->json(new UserResource(auth()->user()), Response::HTTP_OK);
    }
}
