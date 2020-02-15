<?php


namespace App\Http\Repositories;

use App\Http\Interfaces\OrderInterface;
use App\Models\Order;
use DB;

class OrderRepository extends BaseRepository implements OrderInterface
{
    public $order;

    public function __construct()
    {
        $this->order = new Order();
    }


    /**
     *  get all Orders
     *
     * @return mixed
     */
    public function all()
    {
        try {
            return $this->order::orderBy('created_at', 'desc')->orderBy('status', 'asc')
                ->get();
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  show  all Orders
     *
     * @param $id
     * @return mixed
     */
    public function getOrderDetails($id)
    {
        try {
            return
                $this->order
                    ->where('id', $id)
                    ->with(array(
                        'user' => function ($query) {
                            $query->select('id', 'name', 'email', 'mobile');
                        },
                        'products',
                        'products.variant.product' => function ($query) {
                            $query->select('id', app()->getLocale() . '_name as name','price');
                        },
                        'products.color' => function ($query) {
                            $query->select('id', app()->getLocale() . '_name as name');
                        },
                        'products.size' => function ($query) {
                            $query->select('id', app()->getLocale() . '_name as name');
                        }
                    ))->first();

        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }

    /**
     *  get order by id
     *
     * @param $id
     * @return mixed
     */
    public function getOrderById($id)
    {
        try {
            return $this->order->find($id);
        } catch (\Exception $e) {
            return self::catchExceptions($e->getMessage());
        }
    }
}
