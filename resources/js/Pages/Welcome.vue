<script setup>
import WebLayout from '@/Layouts/WebLayout.vue';
import ArticleList from "@/Components/ArticleList.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';
import { UserOutlined } from '@ant-design/icons-vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  isMember: Boolean,
  isOrganizer: Boolean,
  articles: Array,
});
</script>

<template>
  <WebLayout title="Dashboard">
    <div class="lg:h-96 bg-gradient-to-tr bg-[#0081C8] rounded-md flex items-center">
      <div class="ml-5 lg:ml-20 lg:w-3/5 py-5">
        <h2 class="text-white text-4xl">這是什麼?</h2>
        <p class="lg:text-lg text-indigo-100 mt-4 capitalize font-thick tracking-wider leading-7">
          澳門柔道協會會員系統是為全澳柔道愛好者提供的綜合服務平台。作為會員，您可以建立您的個人會員卡和個人資料，這使您可以連接與其他柔道運動員一起展示您在這項運動中的成就。
        </p>
        <!-- <a href="#"
          class="uppercase inline-block mt-8 text-sm bg-white py-2 px-4 rounded font-semibold hover:bg-indigo-100"> Learn More
        </a> -->
      </div>
    </div>

    <div class="px-4 py-2 mt-2 bg-white rounded-md">
      <h2 class="font-bold text-2xl text-gray-800">最新消息{{ $t('group') }}</h2>
      <ArticleList :articles="articles"/>
    </div>

  </WebLayout>
</template>
