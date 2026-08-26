<script setup lang="ts">
import TextareaFrom from "@/components/TextareaFrom.vue";
import PlusSvg  from '@/components/svgs/PlusSvg.vue'
</script>

<template>
  <div class="p-8 bg-primary-50 min-h-screen">
      <!-- "p-8"は　paddingを大きめに作り要素の内側に余白を作る。
      "bg-primary-50"は背景色を指定している
      "min-h-screen"は愛亭でも画面1枚分の高さにする。中身が少なくてもて方向に画面いっぱい真drに広がる-->
    <TextareaFrom />
    <PlusSvg />
  </div>
</template>
