<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
const logout = () => {
    console.log('logout');
    Inertia.post(route('logout'));
    
};

</script>

<template>
    <!-- component -->
    <!-- Header -->
    <header>
        <!-- navbar and menu -->
        <nav class="shadow">

            <div class="flex justify-between items-center py-6 px-10 container mx-auto">

                <div class="flex">
                    <div class="shrink-0 flex items-center"><a href="http://localhost:8000/member/dashboard"><img src="/images/site_logo.png" class="block h-14 w-auto"></a></div>
                    <h1 class="pt-4 text-2xl font-bold bg-gradient-to-tr from-indigo-600 to-green-600 bg-clip-text text-transparent hover:cursor-pointer">
                        <a href="/">
                            Judo Union of Asia
                        </a>
                    </h1>
                </div>

                <div>
                    <div class="hover:cursor-pointer sm:hidden">
                        <span class="h-1 rounded-full block w-8 mb-1 bg-gradient-to-tr from-indigo-600 to-green-600">
                        </span>
                        <span class="h-1 rounded-full block w-8 mb-1 bg-gradient-to-tr from-indigo-600 to-green-600">
                        </span>
                        <span class="h-1 rounded-full block w-8 mb-1 bg-gradient-to-tr from-indigo-600 to-green-600">
                        </span>
                    </div>
                    <div class="flex items-center">
                        <ul class="sm:flex space-x-4 hidden items-center">
                            <li><a href="https://onlinejua.org" target="_blank" class="text-gray-700 hover:text-indigo-600 text-md ">JUA</a></li>
                            <li><a href="https://ijf.org" target="_blank" class="text-gray-700 hover:text-indigo-600 text-md ">IJF</a></li>
                            <template v-if="$page.props.user.id">
                                <li><a href="member" target="_blank" class="text-gray-700 hover:text-indigo-600 text-md ">Dashboard</a></li>
                                <li><a @click="logout">Log Out</a></li>

                            </template>
                            <template v-else>
                                <li><inertia-link :href="route('login')">Login</inertia-link></li>
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
            </div>
        </nav>
    </header>
            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-gray-100 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
   
    <main>
        <!-- section hero -->
        <section>
            <div class="bg-gray-100 sm:grid grid-cols-5 grid-rows-2 px-4 py-6 min-h-full lg:min-h-screen space-y-6 sm:space-y-0 sm:gap-4">
                <div class="col-span-4">
                    <!-- Page Content -->
                    <main>
                        <slot />
                    </main>
                </div>
                <div class="h-96 col-span-1 ">
                    <div class="bg-white py-3 px-4 rounded-lg flex justify-around items-center ">
                        <input type="text" placeholder="seach"
                            class=" bg-gray-100 rounded-md  outline-none pl-2 ring-indigo-700 w-full mr-2 p-2">
                        <span><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor ">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg></span>
                    </div>
                    <div class="bg-white  rounded-md">

                        <h1
                            class="text-center text-xl my-4  bg-white py-2 rounded-md border-b-2 cursor-pointer  text-gray-600">
                            Service</h1>
                        <div class="bg-white rounded-md list-none  text-center ">
                            <!-- <li class="py-3 border-b-2"><inertia-link :href="route('enquiry.index')">Enquiry</inertia-link></li>
                            <li class="py-3 border-b-2"><inertia-link :href="route('forms.index')">Forms</inertia-link></li> -->
                            <li class="py-3 border-b-2"><a href="http://www.judo.org.mo" target="_blank" class="list-none  hover:text-indigo-600">澳門柔道協會</a>
                            </li>
                            <li class="py-3 border-b-2"><a href="https://www.sport.gov.mo/pt" class="list-none  hover:text-indigo-600" target="_blank">澳門體育局</a></li>
                            <li class="py-3 "><a href="#" class="list-none border-b-2 hover:text-indigo-600">Feature</a>
                            </li>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </main>
</template>
