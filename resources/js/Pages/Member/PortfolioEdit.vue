<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard..
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <a-form ref="formRef" name="Form" autocomplete="off" 
                        v-bind="layout"
                        :model="member"
                        layout="vertical" 
                        :rules="rules"
                        :validate-messages="validateMessages" 
                        @finish="onFinish">

                                        <a-form-item label="Family Name" name="family_name">
                                            <a-input v-model:value="member.family_name" />
                                        </a-form-item>

                        <a-form-item :wrapper-col="{ ...layout.wrapperCol, offset: 8 }">
                            <a-button type="primary" html-type="submit">Submit</a-button>
                        </a-form-item>

                    </a-form>

                </div>
            </div>
        </div>


    </MemberLayout>
</template>


<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { PlusOutlined, LoadingOutlined } from '@ant-design/icons-vue';
import { message } from 'ant-design-vue';

import { quillEditor } from 'vue3-quill';

export default {
    components: {
        MemberLayout,
        PlusOutlined,
        LoadingOutlined,
        quillEditor
    },
    props: ['member', 'approbates', 'portfolio'],
    data() {
        return {
            activeKey: ['1'],
            loading: false,
            imageUrl: '',
            modal: {
                isOpen: false,
                data: {},
                title: "Modal",
                mode: ""
            },
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
            layout: {
                labelCol: {
                    span: 8,
                },
                wrapperCol: {
                    span: 16,
                },
            },
            virticalStyle: {
                display: 'flex',
                height: '30px',
                lineHeight: '30px',
                marginLeft: "8px",
            },
        }
    },
    created() {
    },
    methods: {
        createRecord(record) {
            this.modal.data = {};
            // this.modal.data.organization_id=this.organization.id;
            // this.modal.data.require_login=false;
            // this.modal.data.for_member=false;
            // this.modal.data.published=false;
            // this.modal.data.media=[];
            this.modal.mode = "CREATE";
            this.modal.isOpen = true;
        },
        editRecord(record) {
            console.log(record);
            this.modal.data = { ...record };
            this.modal.mode = "EDIT";
            this.modal.isOpen = true;
        },
        storeRecord() {
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(() => {
                this.$inertia.post(route('member.portfolios.store'), this.modal.data, {
                    onSuccess: (page) => {
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
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(() => {
                this.modal.data._method = 'PATCH';
                this.$inertia.post(route('member.porfolios.update', this.modal.data.id), this.modal.data, {
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
            this.$inertia.delete(route('member.porfolios.destroy', { form: record.id }), {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    alert(error.message);
                }

            });
        },
        handleChange(info) {
            if (info.file.status === 'uploading') {
                this.loading = true;
                return;
            }
            if (info.file.status === 'done') {
                // Get this url from response in real world.
                getBase64(info.file.originFileObj, base64Url => {
                    this.imageUrl = base64Url;
                    this.loading = false;
                });
            }
            if (info.file.status === 'error') {
                this.loading = false;
                message.error('upload error');
            }
        },
        beforeUpload(file) {
            const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
            if (!isJpgOrPng) {
                message.error('You can only upload JPG file!');
            }
            const isLt2M = file.size / 1024 / 1024 < 2;
            if (!isLt2M) {
                message.error('Image must smaller than 2MB!');
            }
            return isJpgOrPng && isLt2M;
        },
        onFinish() {
            console.log(this.member);
        }
    },
}
</script>
