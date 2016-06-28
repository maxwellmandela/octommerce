<?php namespace Octommerce\Octommerce\Components;

use Auth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Octommerce\Octommerce\Models\Order as OrderModel;
use ApplicationException;

class OrderList extends ComponentBase
{

    public $orderPage;
    public $orders;
    public $ordersDetail;

    public function componentDetails()
    {
        return [
            'name'        => 'Order List',
            'description' => 'Displays a list of orders belonging to a user.'
        ];
    }

    public function defineProperties()
    {
        return [
            'orderPage' => [
                'title'       => 'Order page',
                'description' => 'Name of the invoice page file for the invoice links. This property is used by the default component partial.',
                'type'        => 'dropdown',
            ],

            'orderNo' => [
                'title'       => 'Order ID',
                'description' => 'The ID of order',
                'default'     => '{{ :orderno }}',
                'type'        => 'text',
            ],
        ];
    }

    public function getInvoicePageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->orderPage = $this->page['orderPage'] = $this->property('orderPage');
        $this->orders = $this->page['orders'] = $this->loadOrders();
        $this->order = $this->page['order'] = OrderModel::whereOrderNo($this->property('orderNo'))->first();
        $this->ordersDetail = $this->page['ordersDetail'] = $this->loadOrdersDetail();
    }

    public function user()
    {
        if(!Auth::check()) {
            return null;
        }

        return Auth::getUser();
    }

    protected function loadOrders()
    {
        if (!$user = $this->user()) {
            throw new ApplicationException('You must be logged in');
        }

        $orders = OrderModel::orderBy('created_at', 'desc')->get();

        // $orders->each(function($order) {
        //     $order->setUrlPageName($this->orderPage);
        // });

        return $orders;
    }

    protected function loadOrdersDetail()
    {
        if (!$user = $this->user()) {
            throw new ApplicationException('You must be logged in');
        } else {
            if($order = OrderModel::whereOrderNo($this->property('orderno'))->first()) {
                $ordersDetail = $order->products;
                return $ordersDetail;
            }
        }

        return null;
    }

}