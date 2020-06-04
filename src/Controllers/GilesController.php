<?php
namespace Jarker\Giles\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class GilesController extends Controller
{
    public function call(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!$appKey = getenv('GILES_APP_KEY')) {
                throw new \Jarker\Giles\Exception\AppKeyNotFoundException('Giles app key is not defined. Please refer to docs.giles.app for more information.');
            }

            if (!$cmdParams = $request->get('cmdParams')) {
                throw new \Jarker\Giles\Exception\CommandNotFoundException('No command was given to Giles.');
            }

            if (!($requestAppKey = $request->get('appKey')) || $requestAppKey !== $appKey) {
                throw new \Jarker\Giles\Exception\AppKeyMisMatchException('The given app key is incorrect.');
            }

            Artisan::call($cmdParams);

            return response()->json([
                'success' => true,
                'message' => Artisan::output()
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}