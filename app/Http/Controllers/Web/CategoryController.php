<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Http\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryRequest;
use DB;

class CategoryController extends WebController
{

    public $categoryRepo;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     *  list all categories we have got
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryRepo->all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     *  create new category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     *  store the new category
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(CategoryRequest $request)
    {
        // add Category
        DB::beginTransaction();
        try {

            if (!$request->has('is_popular')) {
                $request['is_popular'] = 0;
            }

            // check for category popularity
            if ($request['is_popular'] == 1 && $this->categoryRepo->getFavouriteCategoryCount() >= 4) {
                return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.favourite_category_number_exceeded'));
            }

            $category = $this->categoryRepo->createCategory($request);
            if ($category) {
                DB::commit();
            } else {
                DB::rollback();
                // log error
                return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.category_add_err'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.category_add_err'));
        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.category_add_ok'), 'categories.index');
    }

    /**
     *  get one category to edit
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryRepo->getCategoryById($id);
        if ($category) {
            return view('admin.categories.edit', compact('category'));
        }
        return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.category_not_found'));
    }

    /**
     * Update the category
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(CategoryRequest $request, $id)
    {

        if (!$request->has('is_popular')) {
            $request['is_popular'] = 0;
        }

        $category = $this->categoryRepo->getCategoryById($id);
        if (!$category) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.category_not_found'));
        }

        if ($request['is_popular'] == 1 && $category->is_popular == 0 && $this->categoryRepo->getFavouriteCategoryCount() >= 4) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.favourite_category_number_exceeded'));
        }

        DB::beginTransaction();
        // update category data
        try {
            $this->categoryRepo->update($category, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.category_edit_err'));
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.category_edit_ok'), 'categories.index');
    }

    /**
     * Remove the category
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->deleteItem($this->categoryRepo->Category, $id);
    }
}
