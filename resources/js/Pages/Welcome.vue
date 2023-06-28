<script setup>
import WebLayout from '@/Layouts/WebLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<template>
  <WebLayout title="Dashboard">
    <div class="h-96 bg-gradient-to-tr from-indigo-800 to-indigo-500 rounded-md flex items-center">
      <div class="ml-20 w-3/5">
        <h2 class="text-white text-4xl">What this is:</h2>
        <p class="text-indigo-100 mt-4 capitalize font-thin tracking-wider leading-7">
          This is a developing version of of memberhsip management system.  Would like to invite you to become our development teammember to test the function and feature.
        </p>
        <!-- <a href="#"
          class="uppercase inline-block mt-8 text-sm bg-white py-2 px-4 rounded font-semibold hover:bg-indigo-100"> Learn More
        </a> -->
      </div>

    </div>
    <div class="px-4 py-2 mt-2 bg-white rounded-md">
            <h2 class="font-bold text-2xl text-gray-800">Warm welcome!</h2>
                <div class="sm:text-sm text-xs text-gray-700 px-2 mr-1 my-3">
                  <p>We are currelty developing a new memberhsip management system and we would like to invite you to participate in testing its reatures as they cebcome available.  Our development process is base3d ont he Agile methodology, which means that we will be reasing individual features and updates for you to test and provide feadback on.</p>
                  <p>Your feedback and gugestions will be invaluable in helping us refine the system's functionality and ensure it meets your needs.  Please note that while we will make every effort to migrate your input ata to the final prodcution version of the sytem, we cannot guarantee that it will be fully migrated.  This menas that you might need to re-input some of your data once the system is complete and put inot production.</p>
                  <p>We understant that this may be inconvenient, but we want to ensure that the final version of the system is a robust and secure as posible.  As always, we will do out best to ensure the security of your data during the teting phase.</p>
                  <p>To participate in testing, sipmle log in to your account and explore the features that are available. I fyou encouter any issues of have suggestiongs for inprovement, please do not hasitate to contact us and let us know.</p>
                  <p>Thank you for your contibuted support, and we look forward to working with you to make our membership managemet system that best it can be.</p>
                </div>
            <div class="user flex items-center -ml-3 mt-8 mb-4">
                <div class="user-logo">
                    <img class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full mx-4  shadow" src="https://images.unsplash.com/photo-1607789382281-1152591ec0da?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80" alt="avatar">
                </div>
                    <a href="https://twitter.com/GressierCosme1" target="_blank" class="text-gray-500">@Jose</a>
            </div>
        </div>

  </WebLayout>
</template>
