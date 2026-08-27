<script setup lang="ts">
import TrashSvg from './svgs/TrashSvg.vue'

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

defineProps<{
    transactions: Transaction[]
}>()

const emit = defineEmits<{
    (e: 'delete', id: number): void
}>()

const deleteTransaction = (id: number) => {
    emit('delete', id)
}
</script>

<template>
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
</template>

<style scoped>
.transaction-item {
    width: 600px;
    height: 200px;
    margin: 15px auto 0;
    padding: 24px;
    background-color: white;
    border-radius: 12px;
    position: relative;
}
.delete-button{

}
</style>
