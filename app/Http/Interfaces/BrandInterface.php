<?php


namespace App\Http\Interfaces;


interface BrandInterface
{
    /**
     *  get all brands
     *
     * @return mixed
     */
    public function all();


    /**
     *  add brand
     *
     * @param $request
     * @return mixed
     */
    public function createBrand($request);


    /**
     *  update brand
     *
     * @param $brand
     * @param $request
     * @return mixed
     */
    public function update($brand,$request);


    /**
     *  get brand by id
     *
     * @param $id
     * @return mixed
     */
    public function getBrandById($id);

    /**
     *  get list of brands by Api
     *
     * @param $request
     * @return mixed
     */
    public function getBrandsApi($request);

    /**
     *  get list of brands
     *
     * @return mixed
     */
    public function getArrayOfBrands();
}
