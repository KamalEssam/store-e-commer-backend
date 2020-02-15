<?php


namespace App\Http\Interfaces;


interface SizeInterface
{
    /**
     *  get all size
     *
     * @return mixed
     */
    public function all();

    /**
     *  get instance
     *
     * @return mixed
     */
    public function getInstance();

    /**
     *  add size
     *
     * @param $request
     * @return mixed
     */
    public function createSize($request);

    /**
     *  get size by id
     *
     * @param $id
     * @return mixed
     */
    public function getSizeById($id);


    /**
     *  update size
     *
     * @param $ad
     * @param $request
     * @return mixed
     */
    public function update($ad, $request);

    /**
     *  get array of sizes for variant
     *
     * @return mixed
     */
    public function getArrayOfSizes();
}
