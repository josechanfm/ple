<script>
import CourseLayout from '@/Layouts/CourseLayout.vue';

export default {
    components: {
        CourseLayout,
    },
    props: ['course'],
    data() {
        return {
            courseSetup:{
                "Duration":"12 weeks long",
                "Time Commitment":"6-9 hours per week",
                "Pace":"Self-paced",
                "Subject":"Programming",
                "Course Language":"English",
                "Video Transcription":"English",
                "Difficulty":"Intermediate",
                "Credit":"Aduit for free",
                "Platform":"PLE",
                "Topics":"Video Games",
            }
        }
    }
}
</script>

<template>
    <CourseLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="bg-gray-100 sm:grid grid-cols-6 grid-rows-1 px-4 py-4 min-h-full lg:min-h-screen space-y-6 sm:space-y-0 sm:gap-4">
            <div class="col-span-4">
                <a-typography-title :level="1">Course</a-typography-title>
                <a-typography-title :level="5">{{ course.title }}</a-typography-title>
                <div>{{ course.brief }}</div>
                <a-typography-title :level="2">What you will learn</a-typography-title>
                <div v-html="course.learn"></div>
                <inertia-link :href="route('course.study', course.id)" class="ant ant-btn">Start course</inertia-link>
                <a-typography-title :level="2">Course Description</a-typography-title>
                <div v-html="course.description"></div>
            </div>
            <div class="h-96 col-span-2">
                <div class="bg-white rounded-md">
                    <h1 class="text-center text-xl my-4 bg-white py-2 rounded-md border-b-2 cursor-pointer text-gray-600">
                        Course Code
                    </h1>
                    <div class="bg-white rounded-md list-none text-center">
                        <div class="grid grid-cols-1 lg:grid-cols-2 text-left">
                            <template v-for="(value, key) in courseSetup">
                                <div class="p-2 lg:border-b-2">{{ key }}</div>
                                <div class="p-2 border-b-2">{{ value }}</div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </CourseLayout>
</template>

<style >
.ql-align-right {
    text-align: right;
}

.ql-align-center {
    text-align: center;
}

.ql-align-left {
    text-align: left;
}</style>