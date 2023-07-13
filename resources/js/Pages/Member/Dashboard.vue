<script setup>
import MemberLayout from "@/Layouts/MemberLayout.vue";
import Welcome from "@/Components/Welcome.vue";

const data = [
  {
    title: "2023全澳柔道計分賽",
    url: "/member/applications/1",
    content: "Competition ABC is now open for registration"
  },
  {
    title: "Ant Design Title 2",
    url:'',
    content: "Competition ABC is now open for registration"
  },
  {
    title: "Ant Design Title 3",
    url:'',
    content: "Competition ABC is now open for registration"
  },
  {
    title: "Ant Design Title 4",
    url:'',
    content: "Competition ABC is now open for registration"
  },
];

defineProps({
  member: Object,
  competitions: Object,
});
</script>

<template>
  <MemberLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard..
      </h2>
    </template>
    <div class="container mx-auto">
      <div class="flex flex-col-reverse md:flex-row gap-6">
        <div class="flex-auto">
          <div class="container mx-auto pt-5">
            <div class="bg-white relative shadow rounded-lg pl-5">
              <a-list item-layout="horizontal" :data-source="data">
                <template #renderItem="{ item }">
                  <a-list-item>
                    <a-list-item-meta :description="item.content">
                      <template #title>
                        <a :href="item.url">{{ item.title }}</a>
                      </template>
                      <template #avatar>
                        <a-avatar src="https://joeschmoe.io/api/v1/random" />
                      </template>
                    </a-list-item-meta>
                  </a-list-item>
                </template>
              </a-list>
            </div>
          </div>
        </div>
        <div class="flex-none w-[400px]">
          <div class="container mx-auto pt-5">
            <div class="bg-white relative shadow rounded-lg">

              <!-- card start -->
              <div class="mx-auto relative py-4 w-96 hover:scale-105 transform transition-transform mb-4">
                <div class="absolute z-50 h-52 flex rounded-lg flex-col py-3 px-8 text-white shadow-xl text-sm font-serif w-full">
                  <div class="flex flex-col w-xl">
                    <div class="flex justify-center">
                      <div class="text-lg font-bold">{{ $page.props.current_organization.full_name }}</div>
                    </div>
                    <div class="flex">
                      <div class="flex flex-col flex-auto gap-1">
                        <div class="">姓名</div>
                        <div class="mb-2">陳大文</div>
                        <div class="">學會編號</div>
                        <div class="font-sans mb-2">00001</div>
                      </div>
                      <div class="flex-auto text-right">
                        <img class="w-14 h-14" src="/images/judo_logo.png" />
                      </div>
                    </div>
                  </div>
                  <div class="flex text-xs">
                    <div class="flex flex-col gap-1 flex-auto">
                      <div class="">有效期</div>
                      <div class="font-sans text-base">2023-03-31</div>
                    </div>
                    <div class="flex flex-col gap-1 flex-auto">
                      <div class="">失效期</div>
                      <div class="font-sans text-base">2025-03-31</div>
                    </div>
                  </div>
                </div>
                <img
                  class="relative object-cover w-96 h-52 rounded-lg z-0"
                  src="/images/card_blue.png"
                  width="10px"
                />
              </div>
              <!-- card end -->

              <div class="mt-16">
                <h1 class="font-bold text-center text-3xl text-gray-900">
                  {{ $page.props.current_organization.full_name }}
                </h1>
                <p class="text-center text-sm text-gray-400 font-medium">
                  {{ member.display_name }}
                </p>
                <p>
                  <span> </span>
                </p>
                <div class="my-5 px-6">
                  <a
                    href="#"
                    class="text-gray-200 block rounded-lg text-center font-medium leading-6 px-6 py-3 bg-gray-900 hover:bg-black hover:text-white"
                    >Connect with <span class="font-bold">@pantazisoft</span></a
                  >
                </div>
                <div class="flex justify-between items-center my-5 px-6">
                  <a
                    href=""
                    class="text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-150 ease-in font-medium text-sm text-center w-full py-3"
                    >Facebook</a
                  >
                  <a
                    href=""
                    class="text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-150 ease-in font-medium text-sm text-center w-full py-3"
                    >Twitter</a
                  >
                  <a
                    href=""
                    class="text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-150 ease-in font-medium text-sm text-center w-full py-3"
                    >Instagram</a
                  >
                  <a
                    href=""
                    class="text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded transition duration-150 ease-in font-medium text-sm text-center w-full py-3"
                    >Email</a
                  >
                </div>
                <div class="w-full">
                  <h3 class="font-medium text-gray-900 text-left px-6">近況</h3>
                  <div
                    class="mt-5 w-full flex flex-col items-center overflow-hidden text-sm"
                  >
                  <template v-for="organization in member.organizations">
                    <a href="#" class="w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150">
                      <img
                        src="https://avatars0.githubusercontent.com/u/35900628?v=4"
                        alt=""
                        class="rounded-full h-6 shadow-md inline-block mr-2"
                      />
                      {{organization.abbr}} - {{organization.full_name}}
                      <span class="text-gray-500 text-xs">24 min ago</span>
                    </a>
                    </template>

                    <template v-for="portfolio in member.portfolios">
                    <a href="#" class="w-full border-t border-gray-100 text-gray-600 py-4 pl-6 pr-3 w-full block hover:bg-gray-100 transition duration-150">
                      <img
                        src="https://avatars0.githubusercontent.com/u/35900628?v=4"
                        alt=""
                        class="rounded-full h-6 shadow-md inline-block mr-2"
                      />
                      {{portfolio.title}} - {{portfolio.description}}
                      <span class="text-gray-500 text-xs">{{ portfolio.start_date }}</span>
                    </a>
                    </template>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>
