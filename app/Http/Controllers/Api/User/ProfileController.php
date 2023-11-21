<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;

use App\Http\Requests\Api\User\{
    UpdateProfileRequest,
    UpdatePhoneRequest,
    CheckOtpToUpdateRequest,
    EditPasswordRequest,
    DeleteAccountRequest
};
use App\Models\Country;
use App\Http\Resources\Api\User\SimpleResource;
use Illuminate\Support\Arr;
class ProfileController extends Controller
{
    public $helper;
    public function __construct()
    {
        $this->helper = new Helpers();

    }

    /**
     * Update Profile By Image And Fullname
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user = auth('api')->user();
            $user->update($request->validated());
            \DB::commit();
            $token = $user->createToken('moawen')->accessToken;
            $user = SimpleResource::make($user);
            $data = data_set($user, 'token', $token);

            return $this->helper->responseJson('success', trans('api.auth_user_update_success'), 200, ['user' => $user]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return $this->helper->responseJson('failed', trans('api.auth_something_went_wrong'), 422, null);

        }
    }


    /**
     * update profile by phone
     * check user exists or not
     */
    public function sendOtpToCheckPhone(UpdatePhoneRequest $request)
    {
        $user = auth('api')->user();
        $user->update(['otp' => 1111, "updated_phone" => $request->phone, "updated_country_code" => $request->country_code]);
        $data = ['id' => $user->id, 'phone' => $user->updated_phone, 'otp' => $user->otp, "country_code" => $user->updated_country_code];
        return $this->helper->responseJson('success', trans('api.auth_user_update_success_complete'), 200, ['user' => $data]);


    }




    public function updatePhone(CheckOtpToUpdateRequest $request)
    {
        $user = auth('api')->user();

        if ($user->otp != $request->otp) {
            return $this->helper->responseJson('failed', trans('api.otp_not_correct'), 422, null);
        }
        if ($user->updated_phone != $request->phone && $user->updated_phonecode != $request->country_code) {
            return $this->helper->responseJson('failed', trans('api.plz_enter_phone_correct'), 422, null);
        }
        $user->update([
            'phone' => $request->phone,
            'otp' => null,
            'country_code' => $request->country_code,
            "updated_phone" => null,
            "updated_country_code" => null
        ]);
        $country_flag = Country::where("country_code", $request->country_code)->first();
        $user_data = ['phone' => $user->phone, 'country_code' => $user->country_code, "flag" => $country_flag->flag];
        return $this->helper->responseJson('success', trans('api.auth_user_update_success'), 200, ['user' => $user_data]);

    }


    /**
     * Edit Password
     */


    public function editPassword(EditPasswordRequest $request)
    {


        \DB::beginTransaction();
        try {
            $user = auth('api')->user();

            $user->update(Arr::only($request->validated(), ['password']));
            \DB::commit();

            $data = ['user_id' => $user->id, 'image' => $user->image, 'first_name' => $user->fname];


            return $this->helper->responseJson('success', trans('api.auth_password_updated_success'), 200, ['user' => $data]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return $this->helper->responseJson('failed', trans('api.auth_something_went_wrong'), 422, null);

        }

    }

    public function showProfile()
    {
        $user = auth('api')->user();
        $token = $user->createToken('toter')->accessToken;
        $user = SimpleResource::make($user);

        $data = data_set($user, 'token', $token);

        return response()->json(['result' => 'success', 'message' => trans('api.auth_data_retreive_success'), 'status' => 200, 'data' => ['user' => $user]]);

    }


    public function deleteAccount(DeleteAccountRequest $request)
    {
        ///check password

        if (\Hash::check($request->password, auth('api')->user()->password)) {
            auth('api')->user()->delete();
            return response()->json(['result' => 'success', 'message' => trans('api.user_delete_success'), 'status' => 200, 'data' => null]);

        } else {
            return response()->json(['result' => 'failed', 'message' => trans('api.pass_not_correct'), 'status' => 400, 'data' => null], (int) 400);

        }

    }


}
