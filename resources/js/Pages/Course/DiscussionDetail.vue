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
                <a-list-item-meta style="padding-bottom: 24px">
                  <template #title>
                    {{ discussion.user.name }}
                  </template>
                  <template #avatar>
                    <a-avatar :src="discussion.user.profile_photo_url" size="large"/>
                  </template>
                  <template #description>
                    <div class="text-xs">
                      <CalendarOutlined /> {{ discussion.created_at ? dayjs(discussion.created_at).format('YYYY-MM-DD HH:mm:ss') : "Unknown Date" }}
                    </div>
                  </template>
                </a-list-item-meta>

                <a-typography-title :level="5">{{ discussion.title }}</a-typography-title>
                <p>{{ discussion.content }}</p>
              </a-card>

                <a-list :data-source="discussion.posts">
                  <template #renderItem="{ item }">
                    <a-card class="!mb-6 reply">
                    <a-list-item>
                      <template #actions>
                        <a-popconfirm
                          v-if="isOwner(item)"
                          title="Are you sure to delete this post?"
                          ok-text="Yes"
                          cancel-text="No"
                          @confirm="deletePost(item.id)"
                        >
                          <a-button danger type="text">
                            <template #icon>
                              <DeleteOutlined />
                            </template>
                          </a-button>
                        </a-popconfirm>
                      </template>
                      <a-list-item-meta>
                        <template #title>
                          {{ item.user.name }}
                        </template>
                        <template #avatar>
                          <a-avatar :src="item.user.profile_photo_url" size="large"/>
                        </template>
                        <template #description>
                          <div class="text-xs">
                            <CalendarOutlined /> {{ item.created_at ? dayjs(item.created_at).format('YYYY-MM-DD HH:mm:ss') : "Unknown Date" }}
                          </div>
                        </template>
                      </a-list-item-meta>
                    </a-list-item>

                      <div class="mt-4">
                        <h2 class="font-bold text-lg">{{ item.title }}</h2>
                        <div>{{ item.content }}</div>
                      </div>
                    </a-card>
                  </template>
                </a-list>

              <a-card>
                <a-form>
                  <a-form-item>
                    <a-input v-model:value="form.title" placeholder="Enter a subject" />
                  </a-form-item>

                  <a-form-item>
                    <a-textarea v-model:value="form.content" placeholder="Enter your reply" />
                  </a-form-item>

                  <a-form-item>
                    <a-button @click="post">Post</a-button>
                  </a-form-item>
                </a-form>
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
import { CalendarOutlined, DeleteOutlined } from "@ant-design/icons-vue";
import dayjs from "dayjs";

export default {
    components: {
        CourseLayout,
        CalendarOutlined,
        DeleteOutlined
    },
    props:['course','discussion'],
    data() {
        return{
          form: {
            title: "",
            content: ""
          }
        }
    },
    methods:{
        dayjs: dayjs,
        isOwner (post) {
          return post.user_id === this.$page.props.user.id
        },
        sentComment(event){
            console.log(event.currentTarget)
            console.log(event.currentTarget.dataset.discussion_id + ":"+event.currentTarget.value)
            event.currentTarget.value=null
        },
        post () {
          this.$inertia.post(route('course.discussion.create', [this.course.id, this.discussion.id]),
            { ...this.form, discussion_id: this.discussion.id })
        },
        deletePost (id) {
          this.$inertia.delete(route('course.discussion.destroy', [this.course.id, id]))
        }
    }
}
</script>

<style>
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

.reply .ant-card-body {
  @apply !pt-0;
}
</style>
