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
});
const logout = () => {
  console.log("logout");
  Inertia.post(route("logout"));
};

const showingNavigationDropdown = ref(false);
</script>

<template>
  <!-- component -->
  <!-- Header -->
<<<<<<< Updated upstream

  <PageHeader>
    <template #header>
      <div>
        <slot name="header" />
=======
  <header>
    <!-- navbar and menu -->
    <nav class="shadow" style="background-image: url('/images/layout_background.jpg')">
      <div class="flex justify-between items-center py-6 px-10 container mx-auto">
        <div class="flex">
          <div class="shrink-0 flex items-center">
            <a href="http://localhost:8000/member/dashboard"
              ><img src="/images/site_logo.png" class="block h-14 w-auto"
            /></a>
          </div>
          <h1 class="pt-4 text-2xl font-bold">
            <a href="/" class="text-white">澳門理工大學</a>
          </h1>
        </div>

        <div>
          <!-- Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
              @click="showingNavigationDropdown = !showingNavigationDropdown"
            >
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path
                  :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <div class="flex items-center">
            <ul class="sm:flex space-x-4 hidden items-center text-white">
              <li>
                <a
                  href="https://www.mpu.edu.mo"
                  target="_blank"
                  class="text-bold text-white hover:text-yellow-300 text-md"
                  >MPU</a
                >
              </li>
              <li>
                <a
                  href="https://www.dsedj.gov.mo"
                  target="_blank"
                  class="text-bold text-white hover:text-yellow-300 text-md"
                  >DSEDJ</a
                >
              </li>
              <template v-if="$page.props.user.id">
                <li>
                  <a
                    :href="route('member.dashboard')"
                    target="_blank"
                    class="text-bold text-white hover:text-yellow-300 text-md"
                    >{{ $t("memberDashboard") }}</a
                  >
                </li>
                <li>
                  <a @click="logout">{{ $t("log_out") }}</a>
                </li>
              </template>
              <template v-else>
                <li>
                  <inertia-link
                    :href="route('login')"
                    class="text-bold text-white hover:text-yellow-300 text-md"
                    >{{ $t("login") }}</inertia-link
                  >
                </li>
                <li>
                  <inertia-link
                    :href="route('register')"
                    class="text-bold text-white hover:text-yellow-300 text-md"
                    >{{ $t("register") }}</inertia-link
                  >
                </li>
              </template>
            </ul>
            <!-- <div class="md:flex items-center hidden space-x-4 ml-8 lg:ml-12">
                            <h1 class="text-text-gray-600  py-2 hover:cursor-pointer hover:text-indigo-600"><inertia-link
                                    :href="route('login')">登入</inertia-link></h1>
                            <h1
                                class="text-text-gray-600  py-2 hover:cursor-pointer px-4 rounded text-white bg-gradient-to-tr from-indigo-600 to-green-600 hover:shadow-lg">
                                <inertia-link :href="route('login')">後台</inertia-link>
                            </h1>
                        </div> -->
          </div>
        </div>
>>>>>>> Stashed changes
      </div>
    </template>
  </PageHeader>

  <main>
    <!-- section hero -->
    <section>
      <div
        class="bg-gray-100 sm:grid grid-cols-5 grid-rows-1 px-4 py-4 min-h-full lg:min-h-screen space-y-6 sm:space-y-0 sm:gap-4">
        <div class="col-span-4">
          <!-- Page Content -->
          <main>
            <slot />
          </main>
        </div>
        <div class="h-96 col-span-1">
          <div class="bg-white py-3 px-4 rounded-lg flex justify-around items-center">
            <input type="text" :placeholder="$t('search')"
              class="bg-gray-100 rounded-md outline-none pl-2 ring-indigo-700 w-full mr-2 p-2" />
            <span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor ">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg></span>
          </div>
          <div class="bg-white rounded-md">
            <h1 class="text-center text-xl my-4 bg-white py-2 rounded-md border-b-2 cursor-pointer text-gray-600">
              {{ $t('service') }}
            </h1>
            <div class="bg-white rounded-md list-none text-center">
              <li class="py-3 border-b-2">
                <inertia-link :href="route('forms.index')">表格填寫</inertia-link>
              </li>
              <li class="py-3 border-b-2">
<<<<<<< Updated upstream
                <a href="https://www.dsedj.gov.mo" class="list-none hover:text-indigo-600" target="_blank">教育及青年發展局</a>
=======
                <a
                  href="https://www.mpu.edu.mo"
                  target="_blank"
                  class="list-none hover:text-indigo-600"
                  >澳門理工大學</a
                >
              </li>
              <li class="py-3 border-b-2">
                <a
                  href="https://www.dsedj.gov.mo/pt"
                  class="list-none hover:text-indigo-600"
                  target="_blank"
                  >澳門教育及青年發展區</a
                >
>>>>>>> Stashed changes
              </li>
            </div>
          </div>
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
