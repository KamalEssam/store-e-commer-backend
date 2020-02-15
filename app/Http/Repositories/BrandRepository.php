<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\BrandInterface;
use App\Models\Brand;

class BrandRepository extends BaseRepository implements BrandInterface
{
    public $Brand;

    public function __construct()
    {
        $this->Brand = new Brand();
    }

    /**
     *  get all categories
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->Brand::all();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  add brand
     *
     * @param $request
     * @return mixed
     */
    public function createBrand($request)
    {
        try {
            return $this->Brand->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get brand by id
     *
     * @param $id
     * @return mixed
     */
    public function getBrandById($id)
    {
        try {
            return $this->Brand->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  update brand
     *
     * @param $brand
     * @param $request
     * @return mixed
     */
    public function update($brand, $request)
    {
        try {
            return $brand->update($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get list of categories by Api
     *
     * @param $request
     * @return mixed
     */
    public function getBrandsApi($request)
    {
        try {
            return $this->Brand->select(
                'id',
                app()->getLocale() . '_name as name'
            )->get();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get list of categories
     *
     * @return mixed
     */
    public function getArrayOfBrands()
    {
        try {
            return $this->Brand::all()->pluck(app()->getLocale() . '_name', 'id');
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }
}
