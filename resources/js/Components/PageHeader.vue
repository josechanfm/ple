<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
});
const logout = () => {
    Inertia.post(route("logout"));
};

const showingNavigationDropdown = ref(false);

</script>

<template>
    <header>
        <!-- navbar and menu -->
        <nav class="shadow" style="background-image: url('/images/layout_background.jpg')">
            <div class="flex justify-between items-center py-6 px-10 container mx-auto">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="http://localhost:8000/member/dashboard"><img src="/images/site_logo.png"
                                class="block h-14 w-auto" /></a>
                    </div>
                    <h1 class="pt-4 text-2xl font-bold">
                        <a href="/" class="text-white">Personal Learing Envirionment</a>
                    </h1>
                </div>

                <div>
                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 bg-white hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                            @click="showingNavigationDropdown = !showingNavigationDropdown">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center">
                        <ul class="sm:flex space-x-4 hidden items-center text-white">
                            <li>
                                <a href="https://www.mpu.edu.mo" target="_blank"
                                    class="text-bold text-white hover:text-yellow-300 text-md">MPU</a>
                            </li>
                            <template v-if="$page.props.user.id">
                                <li>
                                    <a :href="route('member.dashboard')" target="_blank"
                                        class="text-bold text-white hover:text-yellow-300 text-md">{{ $t("memberDashboard")
                                        }}</a>
                                </li>
                                <li>
                                    <a @click="logout">{{ $t("log_out") }}</a>
                                </li>
                            </template>
                            <template v-else>
                                <li>
                                    <inertia-link :href="route('login')"
                                        class="text-bold text-white hover:text-yellow-300 text-md">{{ $t("login")
                                        }}</inertia-link>
                                </li>
                                <li>
                                    <inertia-link :href="route('register')"
                                        class="text-bold text-white hover:text-yellow-300 text-md">{{ $t("register")
                                        }}</inertia-link>
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
            </div>
            <!-- Responsive Navigation Menu -->
            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="sm:hidden bg-white">
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('member.dashboard')" :active="route().current('dashboard')">
                        {{ $t("dashboard") }}
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                            {{ $t("profile") }}
                        </ResponsiveNavLink>
                        <!-- Authentication -->
                        <template v-if="$page.props.user.id">
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button"> {{ $t("log_out") }} </ResponsiveNavLink>
                            </form>
                        </template>
                        <template v-else>
                            <a :href="route('login')">
                                <ResponsiveNavLink as="button"> {{ $t("login") }}</ResponsiveNavLink>
                            </a>
                            <a :href="route('register')">
                                <ResponsiveNavLink as="button"> {{ $t("register") }} </ResponsiveNavLink>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

