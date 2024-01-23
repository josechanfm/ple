<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t("content") }}
            </h2>
        </template>
        <div v-if="content.id">
            On Edit
        </div>
        <div v-else>
            On Create
        </div>
        <div class="container mx-auto pt-5">
            <div class="bg-white relative shadow rounded-lg overflow-x-auto">
                <a-form 
                    ref="modalRef" 
                    :model="content" 
                    name="Lecture" 
                    :label-col="{ span: 8 }"
                    :wrapper-col="{ span: 16 }" 
                    autocomplete="off" 
                    :rules="rules" 
                    :validate-messages="validateMessages"
                    enctype="multipart/form-data" 
                    @finish="onFinish"
                >
                    <a-form-item :label="$t('module')" name="module">
                        <a-select v-model:value="content.module" :options="course.modules"/>
                    </a-form-item>
                    <a-form-item :label="$t('content_type')" name="type">
                        <a-select v-model:value="content.type" :options="content_types"/>
                    </a-form-item>
                    <a-form-item :label="$t('content_title')" name="title">
                        <a-input v-model:value="content.title" />
                    </a-form-item>
                    <a-form-item :label="$t('content_description')" name="description">
                        <a-textarea v-model:value="content.content" />
                      </a-form-item>
                      <a-form-item :label="$t('image')" name="image">
                        <a-input v-model:value="content.image" />
                      </a-form-item>
                      <a-form-item :label="$t('start_on')" name="start_on">
                        <a-date-picker v-model:value="content.start_on" />
                      </a-form-item>
                      <a-form-item :label="$t('finish_on')" name="finish_on">
                        <a-date-picker v-model:value="content.finish_on" />
                      </a-form-item>
                      <a-form-item :label="$t('finish_on')" name="finish_on">
                        <a-switch v-model:checked="content.published" />
                      </a-form-item>
                      <a-form-item :label="$t('user_id')" name="user_id">
                        <a-input v-model:value="content.user_id" />
                      </a-form-item>
                                <div class="flex flex-row item-center justify-center">
                        <a-button type="primary" html-type="submit">{{$t('submit')}}</a-button>
                    </div>

                </a-form>

            </div>
        </div>

    </OrganizationLayout>
</template>
  
<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import {
    UploadOutlined,
    LoadingOutlined,
    PlusOutlined,
    InfoCircleFilled,
} from "@ant-design/icons-vue";
import { defineComponent, reactive } from "vue";
import CropperModal from "@/Components/Member/CropperModal.vue";

export default {
    components: {
        OrganizationLayout,
        UploadOutlined,
        LoadingOutlined,
        PlusOutlined,
        InfoCircleFilled,
        CropperModal,
    },
    props: ["course", "content","content_types"],
    data() {
        return {
            rules: {
                title: { required: true },
            },
            validateMessages: {
                required: "${label} is required!",
                types: {
                    email: "${label} is not a valid email!",
                    number: "${label} is not a valid number!",
                },
                number: {
                    range: "${label} must be between ${min} and ${max}",
                },
            },
            labelCol: {
                style: {
                    width: "150px",
                },
            },
        };
    },
    created() { },
    methods: {
        onFinish() {
            if(this.content.id===undefined){
                this.$inertia.post(route('manage.course.contents.store'), this.content,{
                    onSuccess:(page)=>{
                        console.log(page);
                    },
                    onError:(err)=>{
                        console.log(err);
                    }
                });
            }else{
                this.$inertia.patch(route('manage.course.contents.update',{course: this.content.course_id,content:this.content.id}), this.content,{
                    onSuccess:(page)=>{
                        console.log(page);
                    },
                    onError:(err)=>{
                        console.log(err);
                    }
                });

            }
        },

    },
};
</script>
  