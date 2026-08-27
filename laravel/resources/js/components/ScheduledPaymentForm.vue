<script setup lang="ts">
import {computed} from 'vue'
import PlusSvg from './svgs/PlusSvg.vue'

const props = defineProps<{
    scheduleDate: string
    scheduleTitle: string
    scheduleAmount: string
}>()

const emit = defineEmits<{
    (e: 'update:scheduleDate', value: string): void
    (e: 'update:scheduleTitle', value: string): void
    (e: 'update:scheduleAmount', value: string): void
    (e: 'save'): void
}>()

const scheduleDate = computed({
    get: () => props.scheduleDate,
    set: (value: string) => emit('update:scheduleDate', value),
})

const scheduleTitle = computed({
    get: () => props.scheduleTitle,
    set: (value: string) => emit('update:scheduleTitle', value),
})

const scheduleAmount = computed({
    get: () => props.scheduleAmount,
    set: (value: string) => emit('update:scheduleAmount', value),
})

const schedule = () => {
    emit('save')
}
</script>

<template>
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
</template>

