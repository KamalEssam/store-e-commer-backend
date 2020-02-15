<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Http\Interfaces\SizeInterface;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SizeRequest;
use DB;

class SizesController extends WebController
{

    public $sizeRepo;

    public function __construct(SizeInterface $sizeRepository)
    {
        $this->sizeRepo = $sizeRepository;
    }

    /**
     *  list all sizes we have got
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sizes = $this->sizeRepo->all();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     *  create new sizes
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     *  store the new sizes
     *
     * @param SizeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SizeRequest $request)
    {
        // add size
        DB::beginTransaction();
        try {
            $size = $this->sizeRepo->createSize($request);
            if ($size) {
                DB::commit();
            } else {
                DB::rollback();
                // log error
                return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.size_added_err'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.size_added_err'));
        }

        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.size_added_ok'), 'sizes.index');
    }

    /**
     *  get one size to edit
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $size = $this->sizeRepo->getSizeById($id);
        if ($size) {
            return view('admin.sizes.edit', compact('size'));
        }
        return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.size_not_found'));
    }

    /**
     * Update the category
     *
     * @param SizeRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SizeRequest $request, $id)
    {
        $size = $this->sizeRepo->getSizeById($id);
        if (!$size) {
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.size_not_found'));
        }

        DB::beginTransaction();
        // update category data
        try {
            $this->sizeRepo->update($size, $request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // log error
            self::logErr($e->getMessage());
            return $this->messageAndRedirect(self::STATUS_ERR, trans('admin.size_edit_err'));
        }
        return $this->messageAndRedirect(self::STATUS_OK, trans('admin.size_edit_ok'), 'sizes.index');
    }

    /**
     * Remove the size
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return $this->deleteItem($this->sizeRepo->getInstance(), $id);
    }
}
