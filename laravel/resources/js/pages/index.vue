<script setup lang="ts">
import { ref, onMounted } from 'vue'
import TextareaFrom from "@/components/TextareaFrom.vue";
import PlusSvg  from '@/components/svgs/PlusSvg.vue';
import DocumentSvg from "@/components/svgs/DocumentSvg.vue";
import TrashSvg from "@/components/svgs/TrashSvg.vue";

type Memo = {
    id: number
    content: string
    created_at: string
    updated_at: string
}
const memos = ref<Memo[]>([])
//空っぽのmemos一覧を用意する。<Memo[]>の型の指定。Memo[]はMemo型のデータが複数入る配列。上にtype Memoを定義しているので

const getMemos = async () =>{
    //これらはメモを取得する処理
    const response = await fetch('/api/memos',{
        //fetchによりapi/memos通信を送っている。そして返ってきたものをresponseに送っている
        method: 'GET',
        //データを送信するためのGET通信です
    })
    memos.value = await response.json()
    //ここでvalueが付くのはmemos自体を入れ替えるのではなくvueが監視している箱はそのままにして、中身のvalueを変えるから
}

onMounted(()=>{
    //index.vueが画面に表示されたらgetMemos()を実行してという意味になる。ポイントは画面に表示されたら自動実行されたい処理であるということ
    getMemos()
})

memos.value.length

</script>

<template>
    <main class="pt-8 bg-primary-50 min-h-screen">
        <!-- "p-8"は　paddingを大きめに作り要素の内側に余白を作る。
        "bg-primary-50"は背景色を指定している
        "min-h-screen"は最低でも画面1枚分の高さにする。中身が少なくても縦方向に画面いっぱいにまで広がる-->

        <TextareaFrom @saved="getMemos" />
        <!--savedイベントが起きたらgetMemosが実行される-->
        <div class="test">

            <div class="memo-stock">
                <DocumentSvg />
                <h2>保存されたメモ</h2>
                <span class="memo-count">{{ memos.length }}件</span>
                <!--一方、templateではvueがvalueを自動的に省略してくれているのでかいていない-->
            </div>

            <div class="memo-item"
                 v-for="memo in memos"
                 :key="memo.id"
            >
                <p class="memo-title">{{ memo.content }}</p>
                <p class="memo-date">{{ memo.created_at}}</p>


                <div class="trashbox">
                    <TrashSvg />
                </div>

            </div>
        </div>

    </main>



</template>

<style>
.test{
    width: 600px;
    margin: 15px auto 0;
    padding: 24px;

}
.memo-stock{
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 8px;
}
.memo-item {
    width: 600px;
    height: 80px;
    margin: 15px auto 0;
    padding: 24px;
    background-color: white;
    border-radius: 12px;
    position: relative;
}
.memo-date{
    position: absolute;
    right: 20px;
    bottom: 0px;
    font-size: 10px;
    color: #b0b0b0;
}
.memo-count{
    margin-left: auto;
    /*左側の余白を可能な限り大きく取る*/
    padding: 6px 14px;
    border-radius: 20px;
    background-color: #ffedd5;
}
.trashbox{
    position: absolute;
    right: 20px;
    top: 10px;
    color: #b0b0b0;
}
</style>
