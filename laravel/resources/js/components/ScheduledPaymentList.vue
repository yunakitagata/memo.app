<script setup lang="ts">
import TrashSvg from './svgs/TrashSvg.vue'

type ScheduledPayment = {
    id: number
    date: string
    title: string
    amount: number
}

defineProps<{
    scheduledpayments: ScheduledPayment[]
}>()

const emit = defineEmits<{
    (e: 'delete', id: number): void
}>()

const deleteScheduledPayment = (id: number) => {
    emit('delete', id)
}
</script>

<template>
    <div class="scheduledpayment-item"
         v-for="scheduledpayment in scheduledpayments"
         :key="scheduledpayment.id"
    >
        <p>今後の支払い</p>
        <p class="scheduledpayments-date">{{ scheduledpayment.date }}</p>
        <p class="scheduledpayments-title">{{ scheduledpayment.title }}</p>
        <p class="scheduledpayments-amount">{{ scheduledpayment.amount }}</p>

        <button
            class="deleteschedule-button"
            @click="deleteScheduledPayment(scheduledpayment.id)">
            <!--指定されたidのものにおいてdeleteTransactionが適用される-->

            <TrashSvg class="delete-trash"/>
            削除
        </button>

    </div>
</template>

<style scoped>
.scheduledpayment-item {
    width: 600px;
    height: 200px;
    margin: 15px auto 0;
    padding: 24px;
    background-color: pink;
    border-radius: 12px;
    position: relative;
}
</style>

