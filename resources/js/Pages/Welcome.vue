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
  courses: Array
});
</script>

<template>
  <WebLayout title="Dashboard">
    <div class="lg:h-96 bg-gradient-to-tr bg-[#0081C8] rounded-md flex items-center">
      <div class="ml-5 lg:ml-20 lg:w-3/5 py-5">
        <h2 class="text-white text-4xl">這是什麼?</h2>
        <p class="lg:text-lg text-indigo-100 mt-4 capitalize font-thick tracking-wider leading-7">
          我们提供一个与研究人员、教育工作者和学习者共同构建的综合性平台。我们的目标是通过多方面的合作，建立起澳门首个集研究、教学和学习于一体的个人学习环境平台。
        </p>
        <!-- <a href="#"
          class="uppercase inline-block mt-8 text-sm bg-white py-2 px-4 rounded font-semibold hover:bg-indigo-100"> Learn More
        </a> -->
      </div>
    </div>

    <div class="px-4 py-2 mt-2 bg-white rounded-md">
      <h2 class="font-bold text-2xl text-gray-800">最新消息{{ $t('group') }}</h2>
      <ArticleList :articles="articles" />
    </div>

    <div class="px-4 py-2 mt-2 bg-white rounded-md">
      <h2 class="font-bold text-2xl text-gray-800">課程列表</h2>
      <a-row :gutter="16">
        <a-col v-for="course in courses" :span="8">
          <inertia-link :href="route('course',course.id)" class="group">
          <a-card class="border !rounded-md overflow-clip hover:-translate-y-2 shadow hover:shadow-lg transition-all">
            <template #cover>
              <img alt="example" src="https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png" />
            </template>
            <a-card-meta>
              <template #title>
                <a class="group-hover:underline">{{ course.title }}</a>
              </template>
              <template #description>{{ course.brief }}</template>
            </a-card-meta>
          </a-card>
          </inertia-link>
        </a-col>
      </a-row>
    </div>

  </WebLayout>
</template>
