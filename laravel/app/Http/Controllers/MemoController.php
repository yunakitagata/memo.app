<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function store (Request $request){
        $memo = Memo::create([
            'content' => $request['content']
        ]);

        return $memo;
    }

    public function index (Request $request){
        $memos = Memo::all();
        //取得したメモ一覧を$memosに入れる。//
        return $memos;
        //GET/api/memosを送ってきた相手に返す//
    }

    public function delete (Request $request){
        $memos = Memo::all();
        //取得したメモ一覧を$memosに入れる。//
        return $memos;
        //GET/api/memosを送ってきた相手に返す//
    }
}
