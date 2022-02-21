<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ServiceTrait;
use Illuminate\Http\Request;
use \Validator;
use App\Model\CourierType;

class ServiceController extends Controller
{
    use ServiceTrait;

    public function showShippingCost(Request $request) {
        try{           
            $validator = $this->validateInputData($request);
            if($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $result = $this->calculateShippingCost($request);
            return $this->sendResponse($result, 'Shipping Cost calculated successfully.');
        }catch(\Exception $ex) {
            \Log::error('showShippingCost(): '.$ex->getMessage());
            return $this->sendError($ex->getMessage(), '', 503);
        }
    }

    private function validateInputData($request) {
        $validator = Validator::make($request->all(), [
            'weight' => 'required|int|max:500',
            'route' => 'required|min:3|max:3',
            'type' => 'required|min:7|max:7',
        ]);

        return $validator;
    }

    private function calculateShippingCost($request) {    
        $weight = (int) $request->weight;
        $route = $request->route;
        $type = $request->type;

        $routes = ['ISD' => 60, 'OSD' => 120];
        $fee = CourierType::where(['name' => $type, 'status' => 'Active'])->first();
        $result = $weight * $fee->price + $routes[$route];

        return $result;
    }
}
