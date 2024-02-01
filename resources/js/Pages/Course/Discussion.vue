<template>
    <CourseLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Discussion
            </h2>
        </template>

        <div class="bg-gray-100 sm:grid grid-cols-6 grid-rows-1 px-4 py-4 min-h-full lg:min-h-screen space-y-6 sm:space-y-0 sm:gap-4">
            <div class="col-span-4">
            <a-typography-title :level="5">{{ course.title }}</a-typography-title>
            <p>{{ forum.description }}</p>
            <a-timeline>
                <a-timeline-item v-for="item in forum.main_discussions" >
                    <a-typography-text strong>{{ item.title }}</a-typography-text>
                    <div>{{ item.content }}</div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="border-t-2 border-b-2">Like</div>
                        <div class="border-t-2 border-b-2">Comment</div>
                        <div class="border-t-2 border-b-2">Share</div>
                    </div>
                    <div class="flex">
                        <a-avatar>U</a-avatar>
                        <div class="pl-5 w-full">
                            <a-input :name="'discussion_comment'" :data-discussion_id="item.id" @keyup.enter="sentComment"/>
                        </div>
                        <div class="w-1/6">
                            Icons | Icons | Icons
                        </div>
                    </div>
                </a-timeline-item>
            </a-timeline>
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

export default {
    components: {
        CourseLayout,
    },
    props:['course','forum'],
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
</style>
