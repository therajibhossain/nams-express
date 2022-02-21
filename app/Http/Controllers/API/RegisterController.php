<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ServiceTrait;
use App\User;
use Illuminate\Support\Facades\Auth;
use \Validator;


class RegisterController extends Controller
{
    use ServiceTrait;
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        }catch(\Exception $ex) {
            \Log::error('showShippingCost(): '.$ex->getMessage());
            return $this->sendError($ex->getMessage(), '', 503);
        }
    }
}