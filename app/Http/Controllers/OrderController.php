<?php

namespace App\Http\Controllers;

use App\Http\Filter\OrderFilter;
use App\Http\Requests\StoreOrder;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SubscriptionResource;
use App\Interfaces\Constraint;
use App\Invoice;
use App\Order;
use App\Subscription;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;


class OrderController extends Controller
{

    //TODO enkel admin middleware of gebruiker zelf?
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderFilter $filter)
    {
        return OrderResource::collection(Order::filter($filter)->with('orderable')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        //check model en user
        /** @var TYPE_NAME $validationRules */

        $class = Relation::morphMap()[$request->input('class')];

        //check model attributes
        $request->validate($class::$validationRules);

        //TODO: check of er geen order in progress is

        $object2 = new $class($request->all());

        if ($object2 instanceof Constraint) {
            try {
                $object2->constraint($request);

            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 400);
            }
        }

        $object = $class::create($request->all());

        $object->order()->save(new Order([
            'user_id' => $request->input('user_id')
        ]));

        $object->update();

        return SubscriptionResource::collection(Subscription::userid($request->input('user_id'))->with('rents')->with('reservations')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $invoice = $order->invoice;

        if ($order->orderable()->count()>0){
            $order->orderable->delete();

        }

        $order->forceDelete();


        //check ofdat het de laatste order van de invoice is
        //zoja invoice verwijderen

        if ($invoice->orders()->count() == 0) {

            $order->invoice->pays()->delete();
            $invoice->delete();
            return [];
        }


        if (Invoice::find($invoice->id)) {
            return new InvoiceResource(Invoice::whereId($invoice->id)->with('orders')->first());
        }

    }
}
