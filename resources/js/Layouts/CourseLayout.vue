<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import PageHeader from "@/Components/PageHeader.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  title: String,
  course: Object,
});
const logout = () => {
  console.log("logout");
  Inertia.post(route("logout"));
};

const showingNavigationDropdown = ref(false);

import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  PieChartOutlined,
  MailOutlined,
} from '@ant-design/icons-vue';

// you can rewrite it to a single file component, if not, you should config vue alias to vue/dist/vue.esm-bundler.js
const SubMenu = {
  name: 'SubMenu',
  props: {
    menuInfo: {
      type: Object,
      default: () => ({}),
    },
  },
  template: `
    <a-sub-menu :key="menuInfo.key">
      <template #title>{{ menuInfo.title }}</template>
      <template v-for="item in menuInfo.children" :key="item.key">
        <template v-if="!item.children">
          <a-menu-item :key="item.key">
            {{ item.title }}
          </a-menu-item>
        </template>
        <template v-else>
          <sub-menu :menu-info="item" :key="item.key" />
        </template>
      </template>
    </a-sub-menu>
  `
};
const list = [
  {
    key: '1',
    title: 'Overview',
    route: 'course',
  },
  {
    key: '2',
    title: 'Content',
    route: 'course.study',
  },
  {
    key: '4',
    route: 'course.discussion',
    title: 'Discussion',
  },
  // {
  //   key: '3',
  //   title: 'Evaluations',
  //   children: [
  //     {
  //       key: '2.1',
  //       title: 'Grades',
  //     },
  //     {
  //       key: '2.2',
  //       title: 'Quizzes',
  //     },
  //     {
  //       key: '2.3',
  //       title: 'Assignments',
  //     },
  //   ],
  // },
];
</script>

<template>
  <!-- component -->
  <!-- Header -->
  <PageHeader>
    <template #header>
      <div>
        <slot name="header" />
      </div>
    </template>
  </PageHeader>

  <nav class="max-w-7xl mx-auto">
    <a-menu
      v-model:openKeys="openKeys"
      v-model:selectedKeys="selectedKeys"
      mode="horizontal"
    >
      <template v-for="item in list" :key="item.key">
        <template v-if="!item.children">
            <a-menu-item :key="item.key">
              <inertia-link :href="route(item.route, $page.props.course.id ?? 0)" :key="item.key">
              {{ item.title }}
              </inertia-link>
            </a-menu-item>
        </template>
        <template v-else>
          <sub-menu :key="item.key" :menu-info="item" />
        </template>
      </template>
    </a-menu>
  </nav>

  <main>
    <!-- section hero -->
    <section>
      <div class="bg-gray-100">
        <div class="col-span-4">
          <!-- Page Content -->
          <main class="max-w-7xl mx-auto">
            <slot />
          </main>
        </div>
      </div>
    </section>
  </main>
</template>

<style>
.bg-primary {
  --bg-opacity: 1;
  background-color: #ff69b4;
  background-color: rgba(255, 105, 180, var(--bg-opacity));
}

.bg-secondary {
  --bg-opacity: 1;
  background-color: #333333;
  background-color: rgba(51, 51, 51, var(--bg-opacity));
}

.bg-brand {
  --bg-opacity: 1;
  background-color: #243c5a;
  background-color: rgba(36, 60, 90, var(--bg-opacity));
}
</style>
