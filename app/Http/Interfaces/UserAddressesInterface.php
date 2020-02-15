<?php


namespace App\Http\Interfaces;


interface  UserAddressesInterface
{

    /**
     *  add new address for user
     *
     * @param $request
     * @return mixed
     */
    public function addAddress($request);

    /**
     *  edit address for user
     *
     * @param $address
     * @param $request
     * @return mixed
     */
    public function editAddress($address, $request);

    /**
     *  remove address form user address list
     *
     * @param $id
     * @return mixed
     */
    public function removeAddredss($id);

    /**
     *  get list off user addresses
     *
     * @param $user_id
     * @return mixed
     */
    public function getAddresses($user_id);

    /**
     *  set default address for user
     *
     * @param $id
     * @return mixed
     */
    public function setDefaultAddress($id);

}


