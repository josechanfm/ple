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
      <div class="bg-gray-100">
        <div class="col-span-4">
          <!-- Page Content -->
          <main>
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
