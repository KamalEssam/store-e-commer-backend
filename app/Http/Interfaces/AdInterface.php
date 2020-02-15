<?php


namespace App\Http\Interfaces;


interface AdInterface
{
    /**
     *  get all ad
     *
     * @return mixed
     */
    public function all();

    /**
     *  add ad
     *
     * @param $request
     * @return mixed
     */
    public function createAd($request);

    /**
     *  get ad by id
     *
     * @param $id
     * @return mixed
     */
    public function getAdById($id);


    /**
     *  update ad
     *
     * @param $ad
     * @param $request
     * @return mixed
     */
    public function update($ad, $request);


    /**
     *  get list of ads by Api
     *
     * @return mixed
     */
    public function getAdsApi();
}
