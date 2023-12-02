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
    <a-button>OK</a-button>
    <div class="lg:h-96 bg-gradient-to-tr bg-[#0081C8] rounded-md flex items-center">
      <div class="ml-5 lg:ml-20 lg:w-3/5">
        <h2 class="text-white text-4xl">What this is:</h2>
        <p class="lg:text-lg text-indigo-100 mt-4 capitalize font-thick tracking-wider leading-7">
          The Macao Judo Association membership website is a comprehensive platform for judo enthusiasts across the continent.
          As a member, you can create your individual membership card and personal profile, which allows you to connect
          with other judokas and showcase your achievements in the sport.
        </p>
        <!-- <a href="#"
          class="uppercase inline-block mt-8 text-sm bg-white py-2 px-4 rounded font-semibold hover:bg-indigo-100"> Learn More
        </a> -->
      </div>
    </div>

    <div class="px-4 py-2 mt-2 bg-white rounded-md">
      <h2 class="font-bold text-2xl text-gray-800">News Update</h2>
      <ArticleList :articles="articles"/>
    </div>

  </WebLayout>
</template>
