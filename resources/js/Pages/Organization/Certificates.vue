<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Certificates
            </h2>
        </template>
        <div class="flex-auto pb-3 text-right">
            <a-button type="primary" class="!rounded" @click="createRecord()">Create Certificate</a-button>
        </div>
        <div class="container mx-auto pt-5">
            <div class="bg-white relative shadow rounded-lg overflow-x-auto">
                <a-table :dataSource="certificates" :columns="columns">
                    <template #headerCell="{ column }">
                        {{ column.i18n ? $t(column.i18n) : column.title }}
                    </template>
                    <template #bodyCell="{ column, text, record, index }">
                        <template v-if="column.dataIndex == 'operation'">
                            <a-button @click="editRecord(record)">Edit</a-button>
                            <inertia-link :href="route('manage.certificate.members.index', record.id)" class="ant-btn">Members</inertia-link>
                        </template>
                        <template v-else-if="column.dataIndex == 'state'">
                            {{ teacherStateLabels[text] }}
                        </template>
                        <template v-else>
                            {{ record[column.dataIndex] }}
                        </template>
                    </template>
                </a-table>
            </div>
        </div>
        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%" :afterClose="modalClose">
            <a-form ref="modalRef" :model="modal.data" name="Teacher" :label-col="{ span: 8 }" :wrapper-col="{ span: 16 }"
                autocomplete="off" :rules="rules" :validate-messages="validateMessages">
                <a-form-item label="Type of Certificate" name="category_code">
                    <a-select v-model:value="modal.data.category_code" :options="certificate_categories" />
                </a-form-item>
                <a-form-item label="Certificate Title" name="cert_title">
                    <a-input v-model:value="modal.data.cert_title" />
                </a-form-item>
                <a-form-item label="Certificate Body" name="cert_body">
                    <a-input v-model:value="modal.data.cert_body" />
                </a-form-item>
                <a-form-item :label="$t('cert_logo')" name="cert_logo">
                    <a-button @click="cropper.showModal = true">Upload Profile Image</a-button>
                    <CropperModal v-if="cropper.showModal" :minAspectRatioProp="{ width: 8, height: 8 }"
                        :maxAspectRatioProp="{ width: 8, height: 8 }" @croppedImageData="setCroppedImageData"
                        @showModal="cropper.showModal = false" 
                    />
                    <div class="flex flex-wrap mt-4 mb-6">
                    <div class="w-full px-3">
                        <div v-if="cropper.preview">
                            <img :src="cropper.preview" class="md:w-1/2"/>
                        </div>
                        <div v-else-if="modal.data.cert_logo">
                            <inertia-link :href="route('manage.certificate.deleteMedia', modal.data.id)"
                                class="float-right text-red-500">
                                <svg focusable="false" class="" data-icon="delete" width="1em" height="1em" fill="currentColor"
                                    aria-hidden="true" viewBox="64 64 896 896">
                                    <path
                                        d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z">
                                    </path>
                                </svg>
                            </inertia-link>
                            <img :src="'/media/certificate/'+modal.data.cert_logo" class="md:w-1/2"/>
                        </div>
                    </div>
                    </div>
                </a-form-item>
                <a-form-item label="Certificate template" name="cert_template">
                    <a-input v-model:value="modal.data.cert_template" />
                </a-form-item>
                <a-form-item label="Number format" name="number_format">
                    <a-input v-model:value="modal.data.number_format" />
                </a-form-item>
                <a-form-item label="Rank caption" name="rank_caption">
                    <a-input v-model:value="modal.data.rank_catption" />
                </a-form-item>
                <a-form-item label="Description" name="description">
                    <a-input v-model:value="modal.data.description" />
                </a-form-item>
            </a-form>
            <template #footer>
                <a-button v-if="modal.mode == 'EDIT'" key="Update" type="primary" @click="updateRecord()">Update</a-button>
                <a-button v-if="modal.mode == 'CREATE'" key="Store" type="primary" @click="storeRecord()">Add</a-button>
            </template>
        </a-modal>
        <!-- Modal End-->
    </OrganizationLayout>
</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import { UploadOutlined, LoadingOutlined, PlusOutlined, InfoCircleFilled } from '@ant-design/icons-vue';
import { defineComponent, reactive } from 'vue';
import CropperModal from "@/Components/Member/CropperModal.vue";

export default {
    components: {
        OrganizationLayout,
        UploadOutlined, LoadingOutlined,PlusOutlined, InfoCircleFilled,
        CropperModal
    },
    props: ['certificates', 'certificate_categories'],
    data() {
        return {
            loading:false,
            imageUrl:null,
            cropper:{
                showModal:false,
                preview: null,
                data:null,
            },
            modal: {
                isOpen: false,
                data: {},
                title: "Modal",
                mode: ""
            },
            teacherStateLabels: {},
            columns: [
                {
                    title: 'Cert Title',
                    dataIndex: 'cert_title',
                    i18n: 'certificate_title'
                }, {
                    title: 'Cert Body',
                    dataIndex: 'cert_body',
                    i18n: 'cert_body'
                }, {
                    title: 'Number Format',
                    dataIndex: 'number_format',
                    i18n: 'number_format'
                }, {
                    title: 'Cert. Logo',
                    dataIndex: 'cert_logo',
                    i18n: 'cert_logo'
                }, {
                    title: 'Cert. template',
                    dataIndex: 'cert_template',
                    i18n: 'cert_template'
                }, {
                    title: '操作',
                    dataIndex: 'operation',
                    key: 'operation',
                    i18n: 'operation'
                },
            ],
            rules: {
                category_code: { required: true },
                cert_title: { required: true },
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
        createRecord() {
            this.modal.data = {};
            this.modal.mode = "CREATE";
            this.modal.title = "Create new Certificate";
            this.modal.isOpen = true;
        },
        editRecord(record) {
            this.modal.data = { ...record };
            this.imageUrl = null;
            this.modal.mode = "EDIT";
            this.modal.title = "修改";
            this.modal.isOpen = true;
        },
        storeRecord() {
            this.$refs.modalRef.validateFields().then(() => {
                this.$inertia.post(route('manage.certificates.store'), this.modal.data, {
                    onSuccess: (page) => {
                        this.modal.data = {};
                        this.modal.isOpen = false;
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
                this.modal.data.cert_logo=this.cropper.data.blob
                this.modal.data._method = 'PATCH';
                this.$inertia.post(route('manage.certificates.update', this.modal.data.id), this.modal.data, {
                    onSuccess: (page) => {
                        this.modal.data = {};
                        this.modal.isOpen = false;
                    },
                    onError: (error) => {
                        console.log(error);
                    }
                });
            }).catch(err => {
                console.log("error", err);
            });
        },
        setCroppedImageData(data) {
            this.cropper.preview = data.imageUrl
            this.cropper.data=data
        },
        modalClose(){
            this.cropper.preview=null;
        }

    },
}
</script>