<template>
  <div>
    <a-menu
      v-model:openKeys="openKeys"
      v-model:selectedKeys="selectedKeys"
      mode="inline"
      theme="light"
      :inline-collapsed="collapsed"
    >
      <a-menu-item key="1">
        <template #icon>
          <PieChartOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.dashboard')">
            {{ $t("affiliate") }}
          </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="2">
        <template #icon>
          <DesktopOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.members.index')">
            {{ $t("member") }}
          </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="3">
        <template #icon>
          <InboxOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.certificates.index')">
            {{$t('certificates') }}
          </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="4">
        <template #icon>
          <InboxOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.forms.index')"> {{$t('forms')}} </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="5">
        <template #icon>
          <InboxOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.competitions.index')"> {{$t('competitions')}} </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="5">
        <template #icon>
          <InboxOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.events.index')"> {{$t('events')}} </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="6">
        <template #icon>
          <InboxOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.articles.index')"> {{$t('articles')}} </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="9">
        <template #icon>
          <DesktopOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.bulletins.index')">
            {{ $t("bulletin") }}
          </inertia-link>
        </span>
      </a-menu-item>
      <a-menu-item key="10">
        <template #icon>
          <DesktopOutlined />
        </template>
        <span>
          <inertia-link :href="route('manage.messages.index')">
            {{ $t("message") }}
          </inertia-link>
        </span>
      </a-menu-item>

      <a-sub-menu key="sub1">
        <template #icon>
          <MailOutlined />
        </template>
        <template #title>Navigation One</template>
        <a-menu-item key="101">Option 5</a-menu-item>
        <a-menu-item key="122">Option 6</a-menu-item>
        <a-menu-item key="103">Option 7</a-menu-item>
        <a-menu-item key="104">Option 8</a-menu-item>
      </a-sub-menu>
      <a-sub-menu key="sub2">
        <template #icon>
          <AppstoreOutlined />
        </template>
        <template #title>Navigation Two</template>
        <a-menu-item key="111">Option 9</a-menu-item>
        <a-menu-item key="112">Option 10</a-menu-item>
        <a-sub-menu key="sub3" title="Submenu">
          <a-menu-item key="1121">Option 11</a-menu-item>
          <a-menu-item key="1122">Option 12</a-menu-item>
        </a-sub-menu>
      </a-sub-menu>
    </a-menu>
  </div>
</template>
<script>
import { defineComponent, reactive, toRefs, watch } from "vue";
import {
  MenuFoldOutlined,
  MenuUnfoldOutlined,
  PieChartOutlined,
  MailOutlined,
  DesktopOutlined,
  InboxOutlined,
  AppstoreOutlined,
} from "@ant-design/icons-vue";

export default defineComponent({
  components: {
    MenuFoldOutlined,
    MenuUnfoldOutlined,
    PieChartOutlined,
    MailOutlined,
    DesktopOutlined,
    InboxOutlined,
    AppstoreOutlined,
  },
  props: ["organization"],
  setup() {
    const state = reactive({
      collapsed: false,
      selectedKeys: ["1"],
      openKeys: ["sub1"],
      preOpenKeys: ["sub1"],
    });
    watch(
      () => state.openKeys,
      (_val, oldVal) => {
        state.preOpenKeys = oldVal;
      }
    );
    const toggleCollapsed = () => {
      state.collapsed = !state.collapsed;
      state.openKeys = state.collapsed ? [] : state.preOpenKeys;
      console.log(state.collapsed.value);
    };
    return {
      ...toRefs(state),
      toggleCollapsed,
    };
  },
});
</script>
