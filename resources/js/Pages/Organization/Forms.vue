<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Form generator
            </h2>
        </template>
        <div class="flex-auto pb-3 text-right">
            <a-button type="primary" class="!rounded" @click="createRecord()">Create Form</a-button>
        </div>
        <div class="container mx-auto pt-5">
            <div class="bg-white relative shadow rounded-lg overflow-x-auto">
                <a-table :dataSource="forms" :columns="columns">
                    <template #headerCell="{ column }">
                        {{ column.i18n ? $t(column.i18n) : column.title }}
                    </template>
                    <template #bodyCell="{ column, text, record, index }">
                        <template v-if="column.dataIndex == 'operation'">
                            <inertia-link :href="route('manage.form.entries.index', { form: record.id })"
                                class="ant-btn">Responses</inertia-link>
                            <a :href="route('manage.entry.export', { form: record.id })" class="ant-btn">Export</a>
                            <inertia-link :href="route('manage.form.fields.index', { form: record.id })" class="ant-btn">Data
                                Fields</inertia-link>
                            <a-button @click="editRecord(record)">Edit</a-button>
                            <a-button @click="deleteRecord(record)">Delete</a-button>
                        </template>
                        <template v-else>
                            {{ record[column.dataIndex] }}
                        </template>
                    </template>
                </a-table>
            </div>
        </div>
        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
            <a-form ref="modalRef" :model="modal.data" name="From" :label-col="{ span: 6 }" :wrapper-col="{ span: 18 }"
                autocomplete="off" :rules="rules" :validate-messages="validateMessages">
                <a-form-item :label="$t('form_name')" name="name">
                    <a-input v-model:value="modal.data.name" />
                </a-form-item>
                <a-form-item :label="$t('title')" name="title">
                    <a-input v-model:value="modal.data.title" />
                </a-form-item>
                <a-form-item :label="$t('description')" name="description">
                    <quill-editor v-model:value="modal.data.description" style="min-height:200px;" />
                </a-form-item>
                <a-form-item :label="$t('require_login')" name="require_login">
                    <a-switch v-model:checked="modal.data.require_login" :unCheckedValue="0" :checkedValue="1"
                        @change="modal.data.for_member = false" />
                    <span class="pl-3">{{ $t('require_login_note') }}</span>
                </a-form-item>
                <a-form-item :label="$t('for_member')" name="for_member" v-if="modal.data.require_login">
                    <a-switch v-model:checked="modal.data.for_member" :unCheckedValue="0" :checkedValue="1" />
                    <span class="pl-3">{{ $t('for_member_note') }}</span>
                </a-form-item>
                <a-form-item :label="$t('published')" name="published">
                    <a-switch v-model:checked="modal.data.published" :unCheckedValue="0" :checkedValue="1" 
                        @change="modal.data.with_attendance = false" />
                    <span class="pl-3">{{ $t('published_note') }}</span>
                </a-form-item>
                <a-form-item :label="$t('with_attendance')" name="with_attendance"  v-if="modal.data.published">
                    <a-switch v-model:checked="modal.data.with_attendance" :unCheckedValue="0" :checkedValue="1" />
                    <span class="pl-3">{{ $t('with_attendance_note') }}</span>
                </a-form-item>
                <a-form-item :label="$t('banner_image')" name="cert_logo">
                    <div v-if="modal.data.media.length">
                        <inertia-link :href="route('manage.form.deleteMedia', modal.data.media[0].id)"
                            class="float-right text-red-500">
                            <svg focusable="false" class="" data-icon="delete" width="1em" height="1em" fill="currentColor"
                                aria-hidden="true" viewBox="64 64 896 896">
                                <path
                                    d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z">
                                </path>
                            </svg>
                        </inertia-link>
                        <img :src="'/media/form/' + modal.data.media[0].id + '/' + modal.data.media[0].file_name" width="100" />
                    </div>
                    <div v-else>
                        <a-upload 
                            v-model:file-list="modal.data.image" 
                            :multiple="false"  
                            :max-count=1 
                            list-type="picture-card"
                            :beforeUpload="()=>{return false}"
                            :show-upload-list="false"
                            @change="uploadChange"
                            >
                            <img v-if="imageUrl" :src="imageUrl" alt="avatar" />
                                <div v-else>
                                    <loading-outlined v-if="loading"></loading-outlined>
                                    <plus-outlined v-else></plus-outlined>
                                    <div class="ant-upload-text">Upload</div>
                                </div>
                        </a-upload>
                    </div>
                </a-form-item>
            </a-form>
            <template #footer>
                <a-button v-if="modal.mode == 'EDIT'" key="Update" type="primary" @click="updateRecord()">更新</a-button>
                <a-button v-if="modal.mode == 'CREATE'" key="Store" type="primary" @click="storeRecord()">新增</a-button>
            </template>
        </a-modal>
        <!-- Modal End-->
    </OrganizationLayout>
</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import { UploadOutlined, LoadingOutlined, PlusOutlined, InfoCircleFilled } from '@ant-design/icons-vue';
import Icon, { RestFilled } from '@ant-design/icons-vue';
import { quillEditor, Quill } from 'vue3-quill';
import { message } from 'ant-design-vue';

export default {
    components: {
        OrganizationLayout,
        UploadOutlined,
        LoadingOutlined,
        PlusOutlined,
        RestFilled,
        quillEditor,
        message
    },
    props: ['organization', 'forms'],
    data() {
        return {
            loading:false,
            imageUrl:null,
            modal: {
                isOpen: false,
                data: {},
                title: "Modal",
                mode: ""
            },
            columns: [
                {
                    title: 'Name',
                    dataIndex: 'name',
                }, {
                    title: 'Title',
                    dataIndex: 'title',
                }, {
                    title: 'Require_login',
                    dataIndex: 'require_login',
                }, {
                    title: 'For Staff',
                    dataIndex: 'for_staff',
                }, {
                    title: 'Published',
                    dataIndex: 'published',
                }, {
                    title: 'Action',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules: {
                field: { required: true },
                label: { required: true },
            },
            validateMessages: {
                required: '${label} is required!',
                types: {
                    email: '${label} is not a valid email!',
                    number: '${label} is not a valid number!',
                },
                number: {
                    range: '${label} must be between ${min} and ${max}',
                },
            },
            labelCol: {
                style: {
                    width: '150px',
                },
            },
        }
    },
    created() {
    },
    methods: {
        createRecord(record) {
            this.modal.data = {};
            this.modal.data.organization_id = this.organization.id;
            this.modal.data.require_login = false;
            this.modal.data.for_member = false;
            this.modal.data.published = false;
            this.modal.data.media = [];
            this.modal.mode = "CREATE";
            this.modal.title = "Create New Form";
            this.modal.isOpen = true;
        },
        editRecord(record) {
            this.modal.data = { ...record };
            this.imageUrl = null;
            this.modal.mode = "EDIT";
            this.modal.title = "Edit Form";
            this.modal.isOpen = true;
        },
        storeRecord() {
            this.$refs.modalRef.validateFields().then(() => {
                this.$inertia.post(route('manage.forms.store'), this.modal.data, {
                    onSuccess: (page) => {
                        this.modal.isOpen = false;
                        this.imageUrl = null;
                    },
                    onError: (err) => {
                        console.log(err);
                    }
                });
            }).catch(err => {
                console.log(err);
            });
        },
        updateRecord() {
            this.$refs.modalRef.validateFields().then(() => {
                this.modal.data._method = 'PATCH';
                this.$inertia.post(route('manage.forms.update', this.modal.data.id), this.modal.data, {
                    onSuccess: (page) => {
                        this.modal.isOpen = false;
                        console.log(page);
                    },
                    onError: (error) => {
                        console.log(error);
                    }
                });
            }).catch(err => {
                console.log("error", err);
            });
        },
        deleteRecord(record) {
            if (!confirm('Are you sure want to remove?')) return;
            this.$inertia.delete(route('manage.forms.destroy', { form: record.id }), {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    alert(error.message);
                }

            });
        },
        uploadChange(info){
            const isJpgOrPng = info.file.type === 'image/jpeg' || info.file.type === 'image/png';
            if (!isJpgOrPng) {
                message.error('You can only upload JPG file!');
            }
            const isLt2M = info.file.size / 1024 / 1024 < 0.2;
            if (!isLt2M) {
                message.error('Image must smaller than 2MB!');
            }

            if(isJpgOrPng && isLt2M){
                this.getBase64(info.file, base64Url => {
                    this.imageUrl = base64Url;
                    this.loading = true;
                });
            }else{
                this.modal.data.image=[]
            }

        },
        getBase64(img, callback) {
            const reader = new FileReader();
            reader.addEventListener('load', () => callback(reader.result));
            reader.readAsDataURL(img);
        }
    },
}
</script>