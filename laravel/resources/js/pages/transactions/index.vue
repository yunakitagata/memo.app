<script setup lang="ts">
import {onMounted, ref, computed} from 'vue'
import PlusSvg  from '../../components/svgs/PlusSvg.vue'
import  TrashSvg from '../../components/svgs/TrashSvg.vue'

/*保存済みのデータの一覧*/
const transactions = ref<Transaction[]>([])

type Transaction = {
    id: number
    type: string
    date: string
    title: string
    amount: number
    category: string
    created_at: string
    updated_at: string
}

const scheduledpayments = ref<ScheduledPayment[]>([])
type ScheduledPayment = {
    id: number
    date: string
    title: string
    amount: number
}


/*入力フォーム用の変数*/
const type = ref('expense')
const date = ref('')
const title = ref('')
const amount = ref('')
const category = ref('')
const scheduleDate = ref('')
const scheduleTitle = ref('')
const scheduleAmount = ref('')


const changeType = (newType: string) => {
    /*changeTypeという名前の関数を作る。newTypeという引数を受け取る。その方はstringである。*/
    type.value = newType
    /*今のtypeを渡されたnewTypeに変更する*/
    category.value = ''
    /*収入支出を切り替えた瞬間にカテゴリーをからにする*/
}

const saveform = async () => {
    /*saveformという変数を作る。*/

    console.log('保存ボタンが押されました')

    console.log(
        type.value,
        date.value,
        title.value,
        amount.value,
        category.value
    )

    const response = await fetch ('/api/transactions',{
        /*fetchにより/api/memos に通信を送る。/api/memosは通信先のurl。api.phpに/memosという受付先で*/
        method: 'POST',
        /*POST通信として送ります*/
        headers: {
            /*headersは送るデータについての追加情報*/
            'Content-Type':'application/json'
        },
        body: JSON.stringify({
            /*JavaScriptのオブジェクトをJSON文字列へ変換する*/
            type: type.value,
            date: date.value,
            title: title.value,
            amount: amount.value,
            category: category.value,

            /*👆(Laravelに送るためのデータ名):(vueで現在textareaに入っている値)*/
        }),

    })
    if (response.ok) {
        console.log('保存成功')
        await getTransactions()
    }
    //POSTは成功した？という確認。成功していたらsavedイベントを親に送る
}

const getTransactions = async () =>{
    //これらはメモを取得する処理
    const response = await fetch('/api/transactions',{
        //fetchによりapi/memos通信を送っている。そして返ってきたものをresponseに送っている
        method: 'GET',
        //データを送信するためのGET通信です
    })
    transactions.value = await response.json()
    //ここでvalueが付くのはmemos自体を入れ替えるのではなくvueが監視している箱はそのままにして、中身のvalueを変えるから
}

onMounted(()=>{
    //index.vueが画面に表示されたらgetMemos()を実行してという意味になる。ポイントは画面に表示されたら自動実行されたい処理であるということ
    getTransactions()
})

const schedule = async () => {
    /*saveformという変数を作る。*/

    console.log('保存ボタン２が押されました')

    console.log(
        scheduleDate.value,
        scheduleTitle.value,
        scheduleAmount.value,
    )

    const response = await fetch ('/api/transactions/schedule',{
        /*fetchにより/api/transactions に通信を送る。/api/memosは通信先のurl。api.phpに/memosという受付先で*/
        method: 'POST',
        /*POST通信として送ります*/
        headers: {
            /*headersは送るデータについての追加情報*/
            'Content-Type':'application/json'
        },
        body: JSON.stringify({
            /*JavaScriptのオブジェクトをJSON文字列へ変換する*/
            date: scheduleDate.value,
            title: scheduleTitle.value,
            amount: scheduleAmount.value,

            /*👆(Laravelに送るためのデータ名):(vueで現在textareaに入っている値)*/
        }),

    })
    if (response.ok) {
        console.log('保存2成功')
        await getTransactionsschedule()
    }
    //POSTは成功した？という確認。成功していたらsavedイベントを親に送る
}


const getTransactionsschedule = async () =>{
    //これらはメモを取得する処理
    const response = await fetch('/api/transactions/schedule',{
        //fetchによりapi/memos通信を送っている。そして返ってきたものをresponseに送っている
        method: 'GET',
        //データを送信するためのGET通信です
    })
    scheduledpayments.value = await response.json()
    //ここでvalueが付くのはmemos自体を入れ替えるのではなくvueが監視している箱はそのままにして、中身のvalueを変えるから
}

onMounted(()=>{
    //index.vueが画面に表示されたらgetMemos()を実行してという意味になる。ポイントは画面に表示されたら自動実行されたい処理であるということ
    getTransactionsschedule()
})

const deleteTransaction = async (id: number) => {
    const response = await fetch(`/api/transactions/${id}`,{
        //fetchによりapi/memos通信を送っている。そして返ってきたものをresponseに送っている
        method: 'DELETE',
        //データを送信するためのGET通信です
    })
    if (response.ok){
        await getTransactions()
    }

}

const expenseTotal = computed(()=>{
    return transactions.value
        //保存済みのtransactionsを使う//
        .filter(transaction => transaction.type === 'expense')
        .reduce((sum, transaction) =>{
            //一件ずつtransactionから取り出して合計する//
            return sum + transaction.amount
            //今までの合計に今回のamountを足す//
        }, 0)
        //合計の初期値は０//
    }
)

const incomeTotal = computed(()=>{
        return transactions.value
            //このreturnではcomputedの計算結果として何を消すのかというreturn//
            //保存済みのtransactionsを使う//
            .filter(transaction => transaction.type === 'income')
            .reduce((sum, transaction) =>{
                //一件ずつtransactionから取り出して合計する//
                return sum + transaction.amount
                //今までの合計に今回のamountを足す//
                //このreturnは今回計算した新しい合計値を次の計算へ渡す。//
            }, 0)
        //合計の初期値は０//
    }
)

const scheduledPaymentTotal = computed(()=>{
        return scheduledpayments.value
            //このreturnではcomputedの計算結果として何を返すのかというreturn//
            //保存済みのtransactionsを使う//
            .reduce((sum, scheduledpayments) =>{
                //一件ずつtransactionから取り出して合計する//
                return sum + scheduledpayments.amount
                //今までの合計に今回のamountを足す//
                //このreturnは今回計算した新しい合計値を次の計算へ渡す。//
            }, 0)
        //合計の初期値は０//
    }
)

const scheduledAvailableFundsTotal = computed(()=>{

        return incomeTotal.value - expenseTotal.value - scheduledPaymentTotal.value
    }
)


</script>

<template>
    <div class="p-8 bg-primary-50 min-h-screen">
        <p>テスト表示</p>
        <form>

            <button type="button"
                    @click=" changeType('expense')"
                    :class="{ active: type === 'expense'}"
            >
                支出
                <!--クリックしされた右側の処理を実行する。このボタンを押されたらタイプをexpenseタイプにする-->
            </button>
            <button type="button"
                    @click=" changeType('income')"
                    :class="{ active: type === 'income'}"
            >
                収入
            </button>

            <p>現在のタイプ：{{ type }}</p>

            <input
            v-model="title"
            type="text"
            placeholder="例：学食">

            <input
            v-model="date"
            type="date"
            placeholder="例：8月23日">

            <input
            v-model="amount"
            type="number"
            placeholder="例：650">

            <select v-model="category">
            <option value="">選択してください</option>

                <template v-if="type === 'expense'">
                    <option value="食費">食費</option>
                    <option value="交通費">交通費</option>
                    <option value="娯楽">娯楽</option>
                    <option value="交際費">交際費</option>
                    <option value="大学・学習">大学・学習</option>
                    <option value="買い物">買い物</option>
                    <option value="美容">美容</option>
                    <option value="その他">その他</option>
                </template>

                <template v-if="type === 'income'">
                    <option value="アルバイト代">アルバイト代</option>
                    <option value="仕送り">仕送り</option>
                    <option value="臨時収入">臨時収入</option>
                    <option value="その他">その他</option>
                </template>

            </select>

        </form>

        <button
            class="form-save"
            @click="saveform">
            <!--ボタンがクリックされるとsaveMemo()が実行される-->

            <PlusSvg class="save-plus"/>
            <span>記録を保存</span>
        </button>

        <form>


            <p>予定支払い</p>

            <input
                v-model="scheduleTitle"
                type="text"
                placeholder="例：クレジットカード支払い">

            <input
                v-model="scheduleDate"
                type="date"
                placeholder="例：8月23日">

            <input
                v-model="scheduleAmount"
                type="number"
                placeholder="例：8000">


        </form>

        <button
            class="schedule-save"
            @click="schedule">
            <!--ボタンがクリックされるとsaveMemo()が実行される-->

            <PlusSvg class="save-plus"/>
            <span>記録を保存</span>
        </button>

        <p>収入合計:{{ incomeTotal }}円</p>
        <p>現在までの支出:{{ expenseTotal }}円</p>
        <p>今後の支払い{{ scheduledPaymentTotal }}円</p>
        <p>あと使えるお金{{ scheduledAvailableFundsTotal }}</p>

        <div class="transaction-item"
             v-for="transaction in transactions"
             :key="transaction.id"
        >
            <p class="transaction-type">{{ transaction.type }}</p>
            <p class="transaction-date">{{ transaction.date }}</p>
            <p class="transaction-title">{{ transaction.title }}</p>
            <p class="transaction-amount">{{ transaction.amount }}</p>
            <p class="transaction-category">{{ transaction.category }}</p>

            <button
                class="delete-button"
                @click="deleteTransaction(transaction.id)">
                <!--指定されたidのものにおいてdeleteTransactionが適用される-->

                <TrashSvg class="delete-trash"/>
                削除
            </button>

        </div>

        <div class="scheduledpayment-item"
             v-for="scheduledpayment in scheduledpayments"
             :key="scheduledpayment.id"
        >

            <p class="scheduledpayments-date">{{ scheduledpayment.date }}</p>
            <p class="scheduledpayments-title">{{ scheduledpayment.title }}</p>
            <p class="scheduledpayments-amount">{{ scheduledpayment.amount }}</p>



        </div>


    </div>
</template>

<style scoped>
.transaction-item {
    width: 600px;
    height: 80px;
    margin: 15px auto 0;
    padding: 24px;
    background-color: white;
    border-radius: 12px;
    position: relative;
}
.delete-button{

}

</style>
