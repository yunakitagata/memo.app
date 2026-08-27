<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ScheduledPayment;

class ScheduledPaymentController extends Controller
{
    public function store(Request $request)
    {
        $scheduledpayment = ScheduledPayment::create(
            $request->only([
                'date',
                'title',
                'amount',
            ])
        );

        return response()->json($scheduledpayment, 201);
    }

    public function index()
    {
        $scheduledpayment = ScheduledPayment::all();
        //取得したメモ一覧を$memosに入れる。//
        return $scheduledpayment;
        //GET/api/memosを送ってきた相手に返す//
    }


    public function delete ($id){

        $scheduledpayment = ScheduledPayment::findOrFail($id);
        //Transactionsテーブルの中からidを探す。見つかったらそれが$transactionに入る//
        $scheduledpayment->delete();
        //その一件を削除する//
        return response()->json([
            'message' => '削除しました'

        ]);
    }

}
