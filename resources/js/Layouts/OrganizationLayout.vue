<template>
  <a-layout style="min-height: 100vh">
    <a-layout-sider
      v-model:collapsed="collapsed"
      :trigger="null"
      collapsible
      theme="light"
      width="250px"
      class="shadow-md"
    >
      <div class="m-4 text-center text-lg" v-if="collapsed">
        <inertia-link href="/">{{ $page.props.current_organization.abbr }}</inertia-link>
      </div>
      <div class="m-4 text-center text-lg" v-else>
        <inertia-link :href="route('manage.dashboard')">{{
          $page.props.current_organization.full_name
        }}</inertia-link>
      </div>

      <OrganizationMenu :menuKeys="menuKeys" />
    </a-layout-sider>
    <a-layout>
      <a-layout-header
        class="shadow-md border-b-2 border-red-600 flex"
        style="background: #fff; padding: 0"
      >
        <menu-unfold-outlined
          v-if="collapsed"
          class="trigger"
          @click="() => (collapsed = !collapsed)"
        />
        <menu-fold-outlined
          v-else
          class="trigger"
          @click="() => (collapsed = !collapsed)"
        />

        <div class="flex-1"></div>
        <Dropdown align="right" width="20">
          <template #trigger>
            <span class="inline-flex rounded-md">
              <button
                type="button"
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="ml-2 -mr-0.5 h-4 w-4"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"
                  />
                </svg>
              </button>
            </span>
          </template>

          <template #content>
            <div class="w-20">
              <template v-if="$page.props.jetstream.hasTeamFeatures">
                <DropdownLink :href="route('language', 'zh-TW')">
                  {{ $t("chinese") }}
                </DropdownLink>
                <DropdownLink :href="route('language', 'en')">
                  {{ $t("english") }}
                </DropdownLink>
              </template>
            </div>
          </template>
        </Dropdown>

        <a-dropdown placement="bottomRight">
          <a class="trigger" @click.prevent>
            <!-- {{ $page.props.currentUser.roles }} -->
            {{ $page.props.user.name }}
          </a>
          <template #overlay>
            <a-menu>
              <a-menu-item>
                <inertia-link
                  :href="route('profile.show')"
                  :active="route().current('dashboard')"
                  >{{ $t("account") }}</inertia-link
                >
              </a-menu-item>
              <a-menu-divider />
              <a-menu-item>
                <inertia-link :href="route('member.profile.index')">{{
                  $t("profile")
                }}</inertia-link>
              </a-menu-item>
              <a-menu-item @click="logout">
                <a>{{ $t("log_out") }}</a>
              </a-menu-item>
            </a-menu>
          </template>
        </a-dropdown>
      </a-layout-header>
      <!-- {{ $page.props }} -->
      <a-layout-content>
        <PageHeader v-if="$slots.header" :menuKeys="menuKeys">
          <template #header>
            <div>
              <slot name="header" />
            </div>
          </template>
        </PageHeader>

        <div class="mx-6">
          <main>
            <slot />
          </main>
        </div>
      </a-layout-content>
    </a-layout>
  </a-layout>
</template>

<script>
import { ref, reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-vue3";
import PageHeader from "@/Components/Organization/PageHeader.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { MenuUnfoldOutlined, MenuFoldOutlined } from "@ant-design/icons-vue";
import OrganizationMenu from "@/Components/Organization/OrganizationMenu.vue";
import { loadLanguageAsync } from "laravel-vue-i18n";
import { getActiveLanguage } from "laravel-vue-i18n";

export default {
  components: {
    PageHeader,
    Dropdown,
    DropdownLink,
    OrganizationMenu,
    loadLanguageAsync,
    MenuUnfoldOutlined,
    MenuFoldOutlined,
    getActiveLanguage,
  },
  props: ["title"],
  setup(props) {
    const menuKeys = reactive({
      menuOpenKey: "",
      menuSelectKey: "",
    });

    const showingNavigationDropdown = ref(false);
    const selectedKeys = ref(["1"]);
    const collapsed = ref(false);

    const switchToTeam = (team) => {
      Inertia.put(
        route("current-team.update"),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      );
    };
    const page = usePage();
    loadLanguageAsync(page.props.value.lang);
    const logout = () => {
      Inertia.post(route("logout"));
    };

    return {
      showingNavigationDropdown,
      selectedKeys,
      menuKeys,
      collapsed,
      switchToTeam,
      logout,
      loadLanguageAsync,
    };
  },
};
// defineProps({
//     title: String,
// });
</script>

<style>
#app .trigger {
  font-size: 18px;
  line-height: 64px;
  padding: 0 24px;
  cursor: pointer;
  transition: color 0.3s;
}

#app .trigger:hover {
  color: #1890ff;
}

#app .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.3);
  margin: 16px;
}

.site-layout .site-layout-background {
  background: #fff;
}
</style>
