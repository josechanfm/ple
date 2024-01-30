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
                        <a-select v-model:value="content.module" :options="course.modules" />
                    </a-form-item>
                    <a-form-item :label="$t('content_type')" name="type">
                        <a-select v-model:value="content.type" :options="content_types" @change="handleChange"/>
                    </a-form-item>
                    <a-form-item :label="$t('content_title')" name="title">
                        <a-input v-model:value="content.title" />
                    </a-form-item>
                    <!-- <a-form-item :label="$t('content_description')" name="description">
                        <a-textarea v-model:value="content.content" />
                    </a-form-item> -->
                    <a-form-item :label="$t('image')" name="image">
                        <a-input v-model:value="content.image" />
                    </a-form-item>
                    <a-form-item v-if="this.selected.value=='PAGE'" :label="$t('content')" name="content">
                        <a-textarea v-model:value="content.content" />
                    </a-form-item>
                    <a-form-item v-else-if="this.selected.value=='FILE'" :label="$t('content')" name="content">
                        <a-upload-dragger
                            v-model:value="content.content"
                            :multiple="true"
                            action="route('manage.files.store')"
                            @change="handleChange"
                            @drop="handleDrop"
                        >
                            <p class="ant-upload-drag-icon">
                                <InboxOutlined />
                            </p>
                            <p class="ant-upload-text">Click or drag file to this area to upload</p>
                            <p class="ant-upload-hint">Support for a single or bulk upload.</p>
                        </a-upload-dragger>
                    </a-form-item>
                    <a-form-item v-else-if="this.selected.value=='URL'" :label="$t('content')" name="content">
                        <a-input v-model:value="content.content" />
                    </a-form-item>
                    <a-form-item v-else-if="this.selected.value=='VIDEO'" :label="$t('content')" name="content">
                        <a-upload-dragger v-model:value="content.content" multiple>
                            <p class="ant-upload-drag-icon">
                                <InboxOutlined />
                            </p>
                            <p class="ant-upload-text">Click or drag file to this area to upload</p>
                            <p class="ant-upload-hint">Support for a single or bulk upload.</p>
                        </a-upload-dragger>
                    </a-form-item>
                    <a-form-item v-else-if="this.selected.value=='AUDIO'" :label="$t('content')" name="content">
                        <a-upload-dragger v-model:value="content.content" multiple>
                            <p class="ant-upload-drag-icon">
                                <InboxOutlined />
                            </p>
                            <p class="ant-upload-text">Click or drag file to this area to upload</p>
                            <p class="ant-upload-hint">Support for a single or bulk upload.</p>
                        </a-upload-dragger>
                    </a-form-item>
                    <a-form-item v-else-if="this.selected.value=='TEXT'" :label="$t('content')" name="content">
                        <a-textarea v-model:value="content.content" />
                    </a-form-item>
                    <a-form-item v-else-if="this.selected.value=='QUIZ'" :label="$t('content')" name="content">
                        <a-button type="" @onClick="console.log('Create Quiz')">Click to set the quiz</a-button>
                    </a-form-item>
                    <a-form-item v-else-if="this.selected.value=='ASSIGNMENT'" :label="$t('content')" name="content">
                        <a-button type="" @onClick="console.log('Create Assignment')">Click to set the assignment</a-button>
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
                        <a-button type="primary" html-type="submit">{{ $t('submit') }}</a-button>
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
import { defineComponent, reactive, ref } from "vue";
import { message } from 'ant-design-vue';
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
    props: ["course", "content", "content_types"],
    data() {
        return {
            rules: {
                type: { required: true },
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
            selected: {
                value: ""
            },
            fileList: ref([])
        };
    },
    created() { this.selected.value=this.content.type },
    methods: {
        handleChange(value) {
            console.log(value);
            this.selected.value = value;
        },
        onFinish() {
            this.$refs.modalRef.validateFields().then(() => {
                console.log(this.content);
                if (this.content.id === undefined) {
                    this.$inertia.post(route('manage.course.contents.store', this.content.course_id), this.content, {
                        onSuccess: (page) => {
                            console.log(page);
                        },
                        onError: (err) => {
                            console.log(err);
                        }
                    });
                } else {
                    this.$inertia.patch(route('manage.course.contents.update', { course: this.content.course_id, content: this.content.id }), this.content, {
                        onSuccess: (page) => {
                            console.log(page);
                        },
                        onError: (err) => {
                            console.log(err);
                        }
                    });
                }
            })
        },
        handleChange(info) {
            const status = info.file.status;
            if (status !== 'uploading') {
                console.log(info.file, info.fileList);
            }
            if (status === 'done') {
                message.success(`${info.file.name} file uploaded successfully.`);
            } else if (status === 'error') {
                message.error(`${info.file.name} file upload failed.`);
            }
        },
        handleDrop(e) {
            console.log(e);
        }
    }
};
</script>