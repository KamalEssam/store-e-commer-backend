<?php


namespace App\Http\Interfaces;


interface OrderInterface
{
    /**
     *  get all Orders
     *
     * @return mixed
     */
    public function all();

    /**
     *  show  all Orders
     *
     * @param $id
     * @return mixed
     */
    public function getOrderDetails($id);

    /**
     *  get order by id
     *
     * @param $id
     * @return mixed
     */
    public function getOrderById($id);

}
