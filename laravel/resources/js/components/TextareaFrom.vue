<script setup lang="ts">
import PlusSvg  from './svgs/PlusSvg.vue'
import {ref} from 'vue'

const content = ref('')
/*contentという名前のリアルアクティブな変数を作り、はじめは中身を空っぽにする*/


const emit = defineEmits(['saved'])
//このコンポーネントはsevedというイベントを親に送れます

/*⭐️以下のコードはJavaScriptの通信処理と何ている。全体として「現在 textarea に入っている content を
POST /api/memos に送る関数」である*/
const saveMemo = async () => {
    /*saveMemoという変数を作る。*/
    if (content.value.length === 0) return
    //空欄ならここでsaveメモをやめる
    const response = await fetch ('/api/memos',{
        /*fetchにより/api/memos に通信を送る。/api/memosは通信先のurl。api.phpに/memosという受付先で*/
        method: 'POST',
        /*POST通信として送ります*/
        headers: {
            /*headersは送るデータについての追加情報*/
            'Content-Type':'application/json'
        },
        body: JSON.stringify({
            /*JavaScriptのオブジェクトをJSON文字列へ変換する*/
            content: content.value,
            /*👆(Laravelに送るためのデータ名):(vueで現在textareaに入っている値)*/
        }),

    })
    if (response.ok) {
        emit('saved')
    }
    //POSTは成功した？という確認。成功していたらsavedイベントを親に送る
}



</script>

<template>
    <div class="memo-card">
        <div class="memo-card-title">
            <PlusSvg />
            <p>新しいメモ</p>
        </div>

        <div class="textarea-wrapper">

            <div
                v-if="content.length === 0"
                class="custom-placeholder">
                <p class="placeholder-main">メモを入力してください...</p>
                <p class="placeholder-sub">(Enterで保存、Shift+Enterで改行)</p>
            </div>

            <textarea
                class="memo-input"
                v-model="content"
                @keydown.enter.exact.prevent="saveMemo">

            </textarea>


            <!--textarea⇨テキスト入力欄を作るためのHTMLタグ
            v-model="text"⇨入力欄に打ち込まれた内容と、システム内部の text というデータを連動させる役割を持っています。
            つまり、ユーザーがこの枠に文字を打ち込むと、自動的に裏側の text のデータもリアルタイムで書き換わります。-->

        </div>

        <button
            class="memo-save"
            :disabled="content.length ===0"
            @click="saveMemo">
            <!--ボタンがクリックされるとsaveMemo()が実行される-->

            <PlusSvg class="save-plus"/>
            <p>メモを保存</p>
        </button>


    </div>

</template>

<style>
.memo-card {
        /*入力欄を囲う白い画面*/
        width: 600px;
        height: 40vh;
        /*ブラウザ画面お高さの40%*/

        margin: 15px auto 0;
        padding: 24px;

        background-color: white;
        border-radius: 12px;

        display: grid;
        grid-template-rows: 1fr 8fr 1fr;
        gap: 10px;
    }


.memo-card-title{
    /*アイコンと新しいメモというタイトルのあるところ*/
    display: flex;
}

.textarea-wrapper {
    position: relative;
}

.custom-placeholder {
    position: absolute;
    top: 14px;
    left: 14px;
    color: #b0b0b0;
    pointer-events: none;
}

.placeholder-main {
    font-size: 14px;
    margin: 0;
}

.placeholder-sub {
    font-size: 12px;
    margin: 4px 0 0;
}

.memo-input{
    /*メモ記入欄*/
    width: 100%;
    height: 100%;
    padding: 20px;
    border-radius: 12px;
    border: 2px solid chocolate;
    box-sizing: border-box;
    resize: none;

}

.memo-save {
    /*保存ボタン*/
    width: 100%;
    padding: 20px;
    display: flex;
    border-radius: 12px;
    justify-content: center;
    align-items: center;
    gap: 8px;
}
.memo-save p{
    /*メモを保存というメッセージ*/
    color: white;
}

.memo-save:disabled{
    /*メモボタン*/
    background-color: #b0b0b0;
    cursor: not-allowed;
}

.memo-save:not(:disabled){
    background-color: chocolate;
    cursor: pointer;
}

.memo-save:not(:disabled):active{
    transform: scale(0.98);
}

.save-plus {
    color: white;
}

</style>
