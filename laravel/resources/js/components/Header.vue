<script setup>
import DocumentSvg  from './svgs/DocumentSvg.vue'
</script>

<template>
 <header class="header">

     <div class="main-title">
      <DocumentSvg />
      <h1>家計簿</h1>
     </div>

     <h2>忘れないうちに記録しよう</h2>

 </header>
</template>

<style>
.header{
    display: flex;
    flex-direction: column;
    align-items: center;
}

.main-title{
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 8px;
}

.main-title h1{
    font-size: 32px;
    font-weight: bold;

}

.header h2{
    font-size: 16px;
    margin-bottom: 8px;

}
</style>
