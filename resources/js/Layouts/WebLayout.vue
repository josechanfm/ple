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

  <PageHeader>
    <template #header>
      <div>
        <slot name="header" />
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
                <a href="https://www.dsedj.gov.mo" class="list-none hover:text-indigo-600" target="_blank">教育及青年發展局</a>
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
