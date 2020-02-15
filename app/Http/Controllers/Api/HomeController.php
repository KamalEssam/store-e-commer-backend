<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Traits\MailTrait;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;
use Validator;

class HomeController extends ApiController
{
    use MailTrait;

    public function __construct(Request $request)
    {
        $this->setLang($request);
    }

    /**
     *  get list of categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request)
    {
        $categories = (new CategoryRepository())->getCategoriesApi($request);
        if (!$categories) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('admin.category_not_found'), '', '');
        }

        return self::jsonResponse(true, self::CODE_OK, trans('admin.categories'), '', $categories);
    }

    /**
     *  get list of products
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function products(Request $request)
    {
        $categories = (new ProductRepository())->getProductsApi($request);

        if (!$categories) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('admin.product_not_found'), '', '');
        }

        return self::jsonResponse(true, self::CODE_OK, trans('admin.products'), '', $categories);
    }


    /**
     *  get product details
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function productDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric|exists:products,id'
        ]);

        // raise errors if validation errors ..
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }
        $product = (new ProductRepository())->getProductDetails($request->get('product_id'));
        if (!$product) {
            return self::jsonResponse(false, self::CODE_NOT_FOUND, trans('admin.product_not_found'), '', '');
        }

        return self::jsonResponse(true, self::CODE_OK, trans('admin.product'), '', $product);
    }


    /**
     *  create new order
     *
     * @param Request $request
     * @return Request
     * @throws \Throwable
     */
    public function createOrder(Request $request)
    {
        $auth = auth()->guard('api')->user();

        // check if user exists
        if (!$auth) {
            return self::jsonResponse(false, self::CODE_UNAUTHORIZED, trans('api.validation_err'));
        }

        $validator = Validator::make($request->all(), [
            'orders' => 'required',
        ]);

        // raise errors if validation errors ..
        if ($validator->fails()) {
            return self::jsonResponse(false, self::CODE_VALIDATION, trans('api.validation_err'), $validator->errors());
        }

        DB::beginTransaction();
        try {
            $the_order = Order::create(
                [
                    'user_id' => $auth->id,
                    'status' => 1
                ]
            );

            // add the order
            foreach ($request['orders'] as $order) {
                $the_order->products()->attach($order['size_id'], [
                    'quantity' => $order['qty'],
                    'product_id' => $order['product_id']
                ]);
            }

            // Send Email to the Premi management
            // send activation link to the user
            $data = [
                'view' => 'emails.requestAlert',
                'subject' => 'new order',
                'to' => 'm.fathy@rkanjel.com',
                'name' => $auth->name,
                'id' => $the_order->id,
            ];

            $this->sendMailTraitFun($data);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            DB::rollBack();
            return self::jsonResponse(false, self::CODE_INTERNAL_ERR, trans('api.internal_err'), $validator->errors());

        }

        DB::commit();
        // if ok send an empty class
        return self::jsonResponse(true, self::CODE_OK, trans('api.order-sent-successfully'));
    }
}
