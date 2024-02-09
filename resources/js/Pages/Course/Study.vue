<script>
import CourseLayout from '@/Layouts/CourseLayout.vue';
import { LinkOutlined } from "@ant-design/icons-vue";

export default {
    components: {
        CourseLayout,
        LinkOutlined
    },
    props: ['course', 'groupedContent'],
    data() {
        return {
            contentPage:{
                content_type:'page',
                content:'abcd'
            },
        }
    },
    mounted(){
        this.contentPage=this.course.contents.find(c=>c.frontpage==1)
    },
    methods: {
      selectContent(content){
            switch(content.content_type){
                case "URL":
                    window.open(content.content,'_blank');
                case "PAGE":
                    this.contentPage=content
                    console.log(this.contentPage);
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
              <a-typography-title :level="1">Table of Content</a-typography-title>
              <a-collapse accordion v-for="module in groupedContent" :key="module.value" class="!mb-6">
                <a-collapse-panel key="1" forceRender>
                  <template #header>
                    <div class="font-medium">{{ module.title }}</div>
                  </template>
                  <a-list :data-source="module.children">
                    <template #renderItem="{ item }">
                        <a-list-item>
                          <inertia-link :href="route('course.content', [course.id, item.id])">
                            <LinkOutlined v-if="item.type == 'URL'"/>
                            {{ item.title }}
                          </inertia-link>
                        </a-list-item>
                    </template>
                  </a-list>
                </a-collapse-panel>
              </a-collapse>
            </div>
            <div class="h-96 col-span-2">
                <inertia-link :href="route('course.discussion',course.id)" class="ant-btn">Discussion</inertia-link>
                <div class="bg-white rounded-md">
                    <h1 class="text-center text-xl my-4 bg-white py-2 rounded-md border-b-2 cursor-pointer text-gray-600">
                        Course Code
                    </h1>
                    <div class="bg-white rounded-md list-none text-center">
                        <div class="text-left">
<!--                            <template v-for="content in course.contents">-->
<!--                                <div class="p-2 border-b-2" @click="selectContent(content)">{{ content.title }}</div>-->
<!--                            </template>-->
                          <a-tree :tree-data="groupedContent">

                          </a-tree>
                        </div>
                    </div>
                </div>
            </div>

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
}

.anticon svg {
  display: block;
}
</style>
