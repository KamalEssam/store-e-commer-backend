<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Http\Interfaces\BrandInterface;
use App\Http\Requests\BrandRequest;
use DB;

class BrandController extends WebController
{
    public $brandRepo;

    public function __construct(BrandInterface $brandRepository)
    {
        $this->brandRepo = $brandRepository;
    }

    /**
     *  list all brands we have got
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $brands = $this->brandRepo->all();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     *  create new brand
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     *  store the new brand
     *
     * @param BrandRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(BrandRequest $request)
    {
        // add Brand
        DB::beginTransaction();
        try {
            $brand = $this->brandRepo->createBrand($request);
            if ($brand) {
                DB::commit();
            } else {
                DB::rollback();
                // log error
                return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.brand_add_err'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.brand_add_err'));
        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.brand_add_ok'), 'brands.index');
    }

    /**
     *  get one brand to edit
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $brand = $this->brandRepo->getBrandById($id);
        if ($brand) {
            return view('admin.brands.edit', compact('brand'));
        }
        return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.brand_not_found'));
    }

    /**
     * Update the brand
     *
     * @param BrandRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = $this->brandRepo->getBrandById($id);
        if (!$brand) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.brand_not_found'));
        }

        DB::beginTransaction();
        // update brand data
        try {
            $this->brandRepo->update($brand, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.brand_edit_err'));
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.brand_edit_ok'), 'brands.index');
    }

    /**
     * Remove the brand
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->deleteItem($this->brandRepo->Brand, $id);
    }
}
