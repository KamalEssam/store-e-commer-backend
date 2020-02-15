<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\SizeInterface;
use App\Models\Size;

class SizeRepository extends BaseRepository implements SizeInterface
{
    public $size;


    public function __construct()
    {
        $this->size = new Size();
    }

    /**
     *  get all sizes
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->size::all();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  update size
     *
     * @param $size
     * @param $request
     * @return mixed
     */
    public function update($size, $request)
    {
        try {
            return $size->update($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  add size
     *
     * @param $request
     * @return mixed
     */
    public function createSize($request)
    {
        try {
            return $this->size->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get size by id
     *
     * @param $id
     * @return mixed
     */
    public function getSizeById($id)
    {

        try {
            return $this->size->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get instance
     *
     * @return mixed
     */
    public function getInstance()
    {
        return $this->size;
    }

    /**
     *  get array of sizes for variant
     *
     * @return mixed
     */
    public function getArrayOfSizes()
    {
        return $this->size->pluck(app()->getLocale() . '_name as name', 'id');
    }
}
