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
    <div class="h-96 bg-gradient-to-tr bg-[#0081C8] rounded-md flex items-center">
      <div class="ml-20 w-3/5">
        <h2 class="text-white text-4xl">What this is:</h2>
        <p class="lg:text-lg text-indigo-100 mt-4 capitalize font-thick tracking-wider leading-7">
          The Judo Union of Asia membership website is a comprehensive platform for judo enthusiasts across the continent. As a member, you can create your individual membership card and personal profile, which allows you to connect with other judokas and showcase your achievements in the sport.
        </p>
        <!-- <a href="#"
          class="uppercase inline-block mt-8 text-sm bg-white py-2 px-4 rounded font-semibold hover:bg-indigo-100"> Learn More
        </a> -->
      </div>
    </div>
    <div class="px-4 py-2 mt-2 bg-white rounded-md">
            <h2 class="font-bold text-2xl text-gray-800">Warm welcome!</h2>
                <div class="lg:text-lg sm:text-sm text-xs text-gray-700 px-2 mr-1 my-3">
                  <p>The website also provides access to a range of features, including event listings, news updates, competition management, and athlete management tools. This means that you can stay up-to-date with the latest happenings in the world of judo, and even participate in competitions or manage your own events.</p>
                  <p>By linking all judokas together through this platform, the Judo Union of Asia membership website aims to create a vibrant and active community of judo enthusiasts who can contribute to and enjoy the sport together. Whether you are a seasoned professional or a beginner, the website provides a wealth of resources and opportunities to hone your skills and connect with other judokas across the continent.</p>
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
