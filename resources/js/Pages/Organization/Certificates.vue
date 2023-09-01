<template>
    <OrganizationLayout title="Dashboard" :organization="organization">
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
                            <inertia-link :href="route('manage.certificate.members.index', record.id)">Members</inertia-link>
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
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
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
                <a-form-item label="Certificate Logo" name="cert_logo">
                    <a-input v-model:value="modal.data.logo" />
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
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        OrganizationLayout,
    },
    props: ['certificates', 'certificate_categories'],
    data() {
        return {
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
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(() => {
                this.$inertia.put(route('manage.certificates.update', this.modal.data.id), this.modal.data, {
                    onSuccess: (page) => {
                        this.modal.data = {};
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
    },
}
</script>