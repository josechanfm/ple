<template>
    <CourseLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Discussion
            </h2>
        </template>

        <div class="bg-gray-100 sm:grid grid-cols-6 grid-rows-1 px-4 py-4 min-h-full lg:min-h-screen space-y-6 sm:space-y-0 sm:gap-4">
            <div class="col-span-4">
              <a-card class="!mb-4">
                <a-typography-title :level="5">{{ discussion.title }}</a-typography-title>
                <p>{{ discussion.content }}</p>

                <p>
                  <CalendarOutlined /> {{ discussion.created_at ?? "Unknown Date" }}
                </p>
              </a-card>

              <a-card title="Replies">
                <a-list :data-source="discussion.posts">
                  <template #renderItem="{ item }">
                    <a-list-item>
                      <a-list-item-meta>
                        <template #title>
                         {{ item.title }}
                        </template>
                        <template #description>
                          <p>
                            <CalendarOutlined /> {{ discussion.created_at ?? "Unknown Date" }}
                          </p>
                          <div>{{ item.content }}</div>
                        </template>
                      </a-list-item-meta>
                    </a-list-item>
                  </template>
                </a-list>
              </a-card>

            </div>

            <div class="h-96 col-span-2">
                <inertia-link :href="route('course',course.id)" class="ant-btn">Study</inertia-link>
                <div class="bg-white rounded-md">
                    <h1 class="text-center text-xl my-4 bg-white py-2 rounded-md border-b-2 cursor-pointer text-gray-600">
                        Forums
                    </h1>
                    <div class="bg-white rounded-md list-none text-center">
                        <div class="text-left">
                            <div class="p-2 border-b-2">Say Hello</div>
                            <div class="p-2 border-b-2">Assignment submittion</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 bg-white">
                <a-typography-title :level="5">Other discusson forums</a-typography-title>
            </div>
        </div>
    </CourseLayout>
</template>

<script>
import CourseLayout from '@/Layouts/CourseLayout.vue';
import { CalendarOutlined } from "@ant-design/icons-vue";

export default {
    components: {
        CourseLayout,
        CalendarOutlined
    },
    props:['course','discussion'],
    data() {
        return{
        }
    },
    methods:{
        sentComment(event){
            console.log(event.currentTarget)
            console.log(event.currentTarget.dataset.discussion_id + ":"+event.currentTarget.value)
            event.currentTarget.value=null
        }
    }
}
</script>

<style >
.ql-align-right {
	text-align: right;
}
.ql-align-center {
	text-align: center;
}
.ql-align-left {
	text-align: left;
}

.anticon svg {
  display: block;
}
</style>
