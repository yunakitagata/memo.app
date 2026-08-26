<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $transaction = Transaction::create(
            $request->only([
                'type',
                'date',
                'title',
                'amount',
                'category',
            ])
        );

        return response()->json($transaction, 201);
    }

    public function index()
    {
        $transactions = Transaction::all();
        //取得したメモ一覧を$memosに入れる。//
        return $transactions;
        //GET/api/memosを送ってきた相手に返す//
    }

    public function delete($id){
        //削除したい記録のidを受け取る関数//
        $transaction = Transaction::findOrFail($id);
        //Transactionsテーブルの中からidを探す。見つかったらそれが$transactionに入る//
        $transaction->delete();
        //その一件を削除する//
        return response()->json([
            'message' => '削除しました'

        ]);

    }

}
