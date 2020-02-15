<?php


namespace App\Http\Repositories;


use App\Http\Interfaces\ProductInterface;
use App\Models\product;
use DB;

class ProductRepository extends BaseRepository implements ProductInterface
{
    public $product;

    public function __construct()
    {
        $this->product = new product();
    }

    /**
     *  get all products
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->product::all();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  add product
     *
     * @param $request
     * @return mixed
     */
    public function createProduct($request)
    {
        try {
            return $this->product->create($request->all());
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  get product by id
     *
     * @param $id
     * @return mixed
     */
    public function getProductById($id)
    {
        try {
            return $this->product->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get variant by id
     *
     * @param $id
     * @return mixed
     */
    public function getVaraintById($id)
    {
        try {
            return DB::table('product_colors')->find($id);
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
            return $this->product::count();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  update product
     *
     * @param $product
     * @param $request
     * @return mixed
     */
    public function update($product, $request)
    {
        try {
            $product->update($request->all());
            return $product;
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get list of products by Api
     *
     * @param $request
     * @return mixed
     */
    public function getProductsApi($request)
    {

        $offset = (isset($request->offset) && !empty($request->offset)) ? $request->offset : 0;
        $limit = (isset($request->limit) && !empty($request->limit)) ? $request->limit : 10;

        try {
            return $this->product
                ->where(function ($query) use ($request) {
                    if ($request->has('category_id') && request('category_id') != '-1') {
                        $query->where('category_id', $request['category_id']);
                    }
                })
                ->where(function ($query) use ($request) {
                    if ($request->has('keyword')) {
                        $query->where('en_name', 'like', '%' . $request['keyword'] . '%')
                            ->orWhere('ar_name', 'like', '%' . $request['keyword'] . '%');
                    }
                })
                ->select(
                    'id',
                    app()->getLocale() . '_name as name',
                    'image',
                    'category_id',
                    'brand_id',
                    'price',
                    'no_of_views',
                    'no_on_buys',
                    app()->getLocale() . '_desc as desc'
                )
                ->with(array(
                    'category' => function ($query) {
                        $query->select('id', app()->getLocale() . '_name as name');
                    },
                    'brand' => function ($query) {
                        $query->select('id', app()->getLocale() . '_name as name');
                    },
                    'colors' => function ($query) {
                        $query->select('product_colors.id', app()->getLocale() . '_name as name', 'quantity');
                    },
                    'colors.sizes' => function ($query) {
                        $query->select('color_sizes.id', 'sizes.' . app()->getLocale() . '_name as name');
                    }))
                ->offset($offset)
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }


    /**
     *  get list of products by Api
     *
     * @param $product_id
     * @return mixed
     */
    public function getProductDetails($product_id)
    {
        try {
            return $this->product
                ->where('id', $product_id)
                ->select(
                    'id',
                    app()->getLocale() . '_name as name',
                    'image',
                    'category_id',
                    'brand_id',
                    'price',
                    'no_of_views',
                    'no_on_buys',
                    app()->getLocale() . '_desc as desc'
                )
                ->with(array(
                    'colors' => function ($query) {
                        $query->select('product_colors.id', app()->getLocale() . '_name as name', 'quantity');
                    },
                    'colors.sizes' => function ($query) {
                        $query->select('color_sizes.id', 'sizes.' . app()->getLocale() . '_name as name');
                    }
                ))
                ->first();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get list of all products to select from
     *
     * @return mixed
     */
    public function getProductsList()
    {
        try {
            return $this->product::all()->pluck(app()->getLocale().'_name', 'id');
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  add product from import
     *
     * @param $product
     * @return mixed
     */
    public function addProductsFromImport($product)
    {
        try {
            return $this->product->create($product);
        } catch (\Exception $e) {
            self::logErr($e->getMessage());
            return false;
        }
    }

    /**
     *  update product variant (quantity)
     *
     * @param $variant_id
     * @param $qty
     * @return bool|int
     */
    public function updateVaraintQuantity($variant_id, $qty)
    {
        try {
            return DB::table('product_colors')->where('id', $variant_id)->update([
                'quantity' => $qty
            ]);
        } catch (\Exception $e) {
            self::logErr($e->getMessage());
            return false;
        }
    }

    public function updateVariantSizes($id, $request)
    {
        DB::beginTransaction();
        try {
            // get current sizes
            $current_sizes = DB::table('color_sizes')
                ->where('variant_id', $id)
                ->pluck('size_id')
                ->toArray();

            // inserted sizes
            $given_sizes = $request['sizes'];

            // get removed sizes
            $removed_sizes = array_diff($current_sizes, $given_sizes);
            if (count($removed_sizes)) {
                DB::table('color_sizes')
                    ->whereIn('size_id', $removed_sizes)
                    ->delete();
            }

            // get only new inserted sizes and insert it
            $inserted_sizes = array_diff($given_sizes, $current_sizes);
            $new_sizes = [];
            if (count($inserted_sizes)) {
                foreach ($inserted_sizes as $size) {
                    $new_sizes[] = ['variant_id' => $id, 'size_id' => $size];
                }
                DB::table('color_sizes')->insert($new_sizes);
            }

        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            DB::rollBack();
        }

        DB::commit();
    }
}
