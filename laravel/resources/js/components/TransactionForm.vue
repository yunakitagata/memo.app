<script setup lang="ts">
import {computed} from 'vue'
import PlusSvg from './svgs/PlusSvg.vue'

const props = defineProps<{
    type: string
    date: string
    title: string
    amount: string
    category: string
}>()

const emit = defineEmits<{
    (e: 'update:type', value: string): void
    (e: 'update:date', value: string): void
    (e: 'update:title', value: string): void
    (e: 'update:amount', value: string): void
    (e: 'update:category', value: string): void
    (e: 'change-type', value: string): void
    (e: 'save'): void
}>()

const type = computed({
    get: () => props.type,
    set: (value: string) => emit('update:type', value),
})

const date = computed({
    get: () => props.date,
    set: (value: string) => emit('update:date', value),
})

const title = computed({
    get: () => props.title,
    set: (value: string) => emit('update:title', value),
})

const amount = computed({
    get: () => props.amount,
    set: (value: string) => emit('update:amount', value),
})

const category = computed({
    get: () => props.category,
    set: (value: string) => emit('update:category', value),
})

const changeType = (newType: string) => {
    emit('change-type', newType)
}

const saveform = () => {
    emit('save')
}
</script>

<template>
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
</template>

