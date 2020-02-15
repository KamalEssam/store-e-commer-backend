<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\CategoryInterface;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    public $Category;

    private const POPULAR_NUM = 4;

    public function __construct()
    {
        $this->Category = new Category();
    }

    /**
     *  get all categories
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->Category::all();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    public function getPopularCount()
    {
        return $this->Category->where('is_popular', 1)->count();
    }

    /**
     *  add category
     *
     * @param $request
     * @return mixed
     */
    public function createCategory($request)
    {
        try {
            return $this->Category->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get category by id
     *
     * @param $id
     * @return mixed
     */
    public function getCategoryById($id)
    {
        try {
            return $this->Category->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get count of all categories
     *
     * @return mixed
     */
    public function count()
    {
        try {
            return $this->Category::count();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  update category
     *
     * @param $category
     * @param $request
     * @return mixed
     */
    public function update($category, $request)
    {
        try {
            return $category->update($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    public function category()
    {
        return $this->Category;
    }

    /**
     *  get list of categories by Api
     *
     * @param $request
     * @return mixed
     */
    public function getCategoriesApi($request)
    {
        try {
            return $this->Category->select(
                'id',
                app()->getLocale() . '_name as name',
                'is_popular',
                'image'
            )->where(function ($query) use ($request) {
                if ($request->has('is_popular') && $request->get('is_popular') == 1) {
                    $query->where('is_popular', 1);
                }
            })->get();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get list of categories
     *
     * @return mixed
     */
    public function getArrayOfCategories()
    {
        try {
            return $this->Category::all()->pluck(app()->getLocale() . '_name', 'id');
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get count of favourite category
     *
     * @return mixed
     */
    public function getFavouriteCategoryCount()
    {
        return $this->Category->where('is_popular', 1)->count();
    }
}
