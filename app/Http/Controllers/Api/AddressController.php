<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Interfaces\UserAddressesInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Validator;

class AddressController extends ApiController
{

    public $userAddresses;

    public function __construct(Request $request, UserAddressesInterface $userRepository)
    {
        $this->setLang($request);

        $this->userAddresses = $userRepository;
    }

    /**
     *  add new address for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'type' => 'required|in:home,work,others',
            'street_name' => 'required',
            'building_no' => 'required',
            'apartment_no' => 'required',
            'floor_no' => 'required',
        ]);

        // raise errors if validation errors ..
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }

        $auth = auth()->guard('api')->user();
        $request['user_id'] = $auth->id;

        $this->userAddresses->addAddress($request);

        return self::jsonResponse(true, self::CODE_OK, trans('admin.address_add_ok'));
    }

    /**
     *  get list of user addresses
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAddresses(Request $request)
    {
        $auth = auth()->guard('api')->user();
        $addresses = $this->userAddresses->getAddresses($auth->id) ?? new Collection();

        return self::jsonResponse(true, self::CODE_OK, trans('admin.add_addresses'), '', $addresses);
    }

    /**
     *  remove address
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        // raise errors if validation errors ..
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }
        $this->userAddresses->removeAddredss($request['address_id']);
        return self::jsonResponse(true, self::CODE_OK, trans('admin.address_edit_ok'));
    }

    public function setDefaultAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        // raise errors if validation errors ..
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }
        $this->userAddresses->setDefaultAddress($request['address_id']);
        return self::jsonResponse(true, self::CODE_OK, trans('admin.address_edit_ok'));
    }
}
