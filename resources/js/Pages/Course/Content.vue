<script>
import CourseLayout from '@/Layouts/CourseLayout.vue';

export default {
    components: {
        CourseLayout,
    },
    props: ['course', 'content']
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
                <a-typography-title :level="1">{{ content.title }}</a-typography-title>
                <div v-html="content.content" v-if="content.type === 'PAGE'"></div>
                <div v-if="content.type === 'TEXT'">{{ content.content }}</div>
              <pre>
                {{ JSON.stringify(content, null, 2) }}
              </pre>
            </div>
<!--            <div class="h-96 col-span-2">-->
<!--                <inertia-link :href="route('course.discussion',course.id)" class="ant-btn">Discussion</inertia-link>-->
<!--                <div class="bg-white rounded-md">-->
<!--                    <h1 class="text-center text-xl my-4 bg-white py-2 rounded-md border-b-2 cursor-pointer text-gray-600">-->
<!--                        Course Code-->
<!--                    </h1>-->
<!--                    <div class="bg-white rounded-md list-none text-center">-->
<!--                        <div class="text-left">-->
<!--&lt;!&ndash;                            <template v-for="content in course.contents">&ndash;&gt;-->
<!--&lt;!&ndash;                                <div class="p-2 border-b-2" @click="selectContent(content)">{{ content.title }}</div>&ndash;&gt;-->
<!--&lt;!&ndash;                            </template>&ndash;&gt;-->
<!--                          <a-tree :tree-data="groupedContent">-->

<!--                          </a-tree>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

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
