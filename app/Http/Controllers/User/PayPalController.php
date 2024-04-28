<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Food;
use Carbon\Carbon;

class PayPalController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_SANDBOX_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_SANDBOX_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function pay(Request $request)
    {
        foreach($request->quantity as $key => $value){
            $detail = OrderDetail::find($key);
            $food_price = isset($detail->food->price) ? $detail->food->price * $value : $detail->total_price;
            OrderDetail::where('id',$key)->update([
                'quantity' => $value,
                'total_price' => $food_price,
            ]);
        }

        $sum_price = OrderDetail::OrderId($request->orderID)->sum('total_price');

        Order::find($request->orderID)->update([
            'total_price' => $sum_price,
        ]);

        try{
            $response = $this->gateway->purchase([
                'amount' => $sum_price,
                'currency' => env('PAYPAL_SANDBOX_CURRENCY'),
                'returnUrl' => url('success').'?orderID='.$request->orderID,
                'cancelUrl' => url('error'),
            ])->send();
            if($response->isRedirect()){
                $returnResponse = [
                    'redirectUrl' => $response->getRedirectUrl()
                ];
            }else{
                $returnResponse = [
                    'message' => $response->getMessage()
                ];
            }

            return response($returnResponse, 200);

        }catch (\Throwable $th){
            return $th->getMessage();
        }
    }
    
    public function success(Request $request)
    {
        if($request->input('paymentId') && $request->input('PayerID')){
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();
            if($response->isSuccessful()){
                $arr = $response->getData();

                $payment = new Payment();
                $payment->order_id = $request->input('orderID');
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_SANDBOX_CURRENCY');
                $payment->payment_status = $arr['state'];

                $payment->save();

                $order = Order::find($request->input('orderID'));
                $order->update([
                    'payment_id' => $arr['id'],
                    'payment_date' => Carbon::now(),
                ]);

                return view('restaurant.receipt',compact('order'));
            }else{
                return $response->getMessage();
            }
        }else{
            return 'Payment declined';
        }
    }

    public function error()
    {
        return 'user declined';
    }
}
