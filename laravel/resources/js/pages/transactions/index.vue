<script setup lang="ts">
import {onMounted, ref, computed} from 'vue'
import TransactionForm from '../../components/TransactionForm.vue'
import ScheduledPaymentForm from '../../components/ScheduledPaymentForm.vue'
import TransactionSummary from '../../components/TransactionSummary.vue'
import TransactionList from '../../components/TransactionList.vue'
import ScheduledPaymentList from '../../components/ScheduledPaymentList.vue'

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

const deleteScheduledPayment = async (id: number) => {
    const response = await fetch(`/api/transactions/schedule/${id}`,{
        //fetchによりapi/memos通信を送っている。そして返ってきたものをresponseに送っている
        method: 'DELETE',
        //データを送信するためのGET通信です
    })
    if (response.ok){
        await getTransactionsschedule()
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

        <TransactionForm
            v-model:type="type"
            v-model:date="date"
            v-model:title="title"
            v-model:amount="amount"
            v-model:category="category"
            @change-type="changeType"
            @save="saveform"
        />

        <ScheduledPaymentForm
            v-model:schedule-date="scheduleDate"
            v-model:schedule-title="scheduleTitle"
            v-model:schedule-amount="scheduleAmount"
            @save="schedule"
        />

        <TransactionSummary
            :income-total="incomeTotal"
            :expense-total="expenseTotal"
            :scheduled-payment-total="scheduledPaymentTotal"
            :scheduled-available-funds-total="scheduledAvailableFundsTotal"
        />

        <TransactionList
            :transactions="transactions"
            @delete="deleteTransaction"
        />

        <ScheduledPaymentList
            :scheduledpayments="scheduledpayments"
            @delete="deleteScheduledPayment"
        />
    </div>
</template>
