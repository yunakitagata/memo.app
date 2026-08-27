<script setup lang="ts">
defineProps<{
    incomeTotal: number
    expenseTotal: number
    scheduledPaymentTotal: number
    scheduledAvailableFundsTotal: number
}>()
</script>

<template>
    <p>収入合計:{{ incomeTotal }}円</p>
    <p>現在までの支出:{{ expenseTotal }}円</p>
    <p>今後の支払い:{{ scheduledPaymentTotal }}円</p>
    <p>あと使えるお金:{{ scheduledAvailableFundsTotal }}</p>
</template>

