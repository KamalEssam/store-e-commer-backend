<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\UserAddressesInterface;
use App\Models\UserAddresses;

class UserAddressesRepository extends BaseRepository implements UserAddressesInterface
{
    public $userAddresses;


    public function __construct()
    {
        $this->userAddresses = new UserAddresses();
    }


    /**
     *  add new address for user
     *
     * @param $request
     * @return mixed
     */
    public function addAddress($request)
    {
        try {
            return $this->userAddresses->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  edit address for user
     *
     * @param $address
     * @param $request
     * @return mixed
     */
    public function editAddress($address, $request)
    {
        try {
            return $address->update($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  remove address form user address list
     *
     * @param $id
     * @return mixed
     */
    public function removeAddredss($id)
    {
        $this->userAddresses->find($id)->delete();
    }

    /**
     *  get list off user addresses
     *
     * @param $user_id
     * @return mixed
     */
    public function getAddresses($user_id)
    {
        return $this->userAddresses->where('user_id', $user_id)->get();
    }

    /**
     *  set default address for user
     *
     * @param $id
     * @return mixed
     */
    public function setDefaultAddress($id)
    {
        try {
            $this->userAddresses->where('id', '!=', $id)->update(['is_default' => false]);
            $this->userAddresses->where('id', '=', $id)->update(['is_default' => true]);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }

        return true;
    }
}
