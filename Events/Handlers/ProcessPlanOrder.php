<?php

namespace Modules\Iplan\Events\Handlers;

use Modules\Iplan\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;

class ProcessPlanOrder
{

    private $logtitle;

    public function __construct()
    {
        $this->logtitle = '[IPLAN-SUBSCRIPTION]::';
    }

    public function handle($event)
    {
        $order = $event->order;
        //Order is Proccesed
        if($order->status_id==13){

            foreach($order->orderItems as $item){

                switch($item->entity_type){
                  case 'Modules\Iplan\Entities\Plan':
                      //Get plan Id form setting
                      $planIdInOrderItem = $item->entity_id;
                      //Get user registered data
                      $user = $order->customer;

                      //Create subscription
                      if ($planIdInOrderItem && $user) {
                          //Init subscription controller
                          $subscriptionController = app('Modules\Iplan\Http\Controllers\Api\SubscriptionController');
                          //Create subscription
                          $subscriptionController->create(new Request([
                              'attributes' => [
                                  'entity' => "Modules\\User\\Entities\\Sentinel\\User",
                                  'entity_id' => $user->id,
                                  'plan_id' => $planIdInOrderItem,
                              ]
                          ]));
                          //Log
                          \Log::info("{$this->logtitle}Order Completed | Register subscription Id {$planIdInOrderItem} to user ID {$user->id}");
                      }
                    break;
                }

            }

        }// end If


    }// If handle



}