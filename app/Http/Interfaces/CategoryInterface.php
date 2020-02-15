<?php


namespace App\Http\Interfaces;


interface CategoryInterface
{
    /**
     *  get all categories
     *
     * @return mixed
     */
    public function all();


    /**
     *  get count of all categories
     *
     * @return mixed
     */
    public function count();

    /**
     *  add category
     *
     * @param $request
     * @return mixed
     */
    public function createCategory($request);


    /**
     *  update category
     *
     * @param $category
     * @param $request
     * @return mixed
     */
    public function update($category,$request);


    /**
     *  get category by id
     *
     * @param $id
     * @return mixed
     */
    public function getCategoryById($id);

    /**
     *  get list of categories by Api
     *
     * @param $request
     * @return mixed
     */
    public function getCategoriesApi($request);

    /**
     *  get list of categories
     *
     * @return mixed
     */
    public function getArrayOfCategories();

    /**
     *  get count of favourite category
     *
     * @return mixed
     */
    public function getFavouriteCategoryCount();
}
