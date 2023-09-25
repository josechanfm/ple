<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles
            </h2>
        </template>
        <div class="flex-auto pb-3 text-right">
            <a-button type="primary" class="!rounded" @click="createRecord()">Create Article</a-button>
        </div>
        <div class="container mx-auto pt-5">
            <div class="bg-white relative shadow rounded-lg overflow-x-auto">
                <a-table :dataSource="articles" :columns="columns">
                    <template #headerCell="{ column }">
                        {{ column.i18n ? $t(column.i18n) : column.title }}
                    </template>
                    <template #bodyCell="{ column, text, record, index }">
                        <template v-if="column.dataIndex == 'operation'">
                            <a-button @click="editRecord(record)">Edit</a-button>
                            <a-popconfirm
                                title="Are you sure to delete the record?"
                                ok-text="Yes"
                                cancel-text="No"
                                @confirm="deleteConfirmed(record)"
                                >
                                <a-button>Delete</a-button>
                            </a-popconfirm>
                        </template>
                        <template v-else-if="column.dataIndex == 'published'">
                            {{ record.published ? 'Yes' : 'No' }}
                        </template>
                        <template v-else>
                            {{ record[column.dataIndex] }}
                        </template>
                    </template>
                </a-table>
            </div>
        </div>
        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="100%">
            <a-form ref="modalRef" :model="modal.data" name="Teacher" layout="vertical" autocomplete="off" :rules="rules"
                :validate-messages="validateMessages">
                <a-form-item :label="$t('article_category')" name="category_code">
                    <a-select v-model:value="modal.data.category_code" :options="articleCategories" />
                </a-form-item>
                <a-form-item :label="$t('title_en')" name="title_en">
                    <a-input v-model:value="modal.data.title_en" />
                </a-form-item>
                <a-form-item :label="$t('title_fn')" name="title_fn">
                    <a-input v-model:value="modal.data.title_fn" />
                </a-form-item>
                <a-form-item :label="$t('content')" name="content_en">
                    <a-textarea  v-model="modal.data.content_en"/>
                    <ckeditor :editor="editor" v-model="modal.data.content_en" :config="editorConfig"/>
                </a-form-item>
                <a-form-item :label="$t('valid_at')" name="valid_at">
                    <a-date-picker v-model:value="modal.data.valid_at" :format="dateFormat" :valueFormat="dateFormat" />
                </a-form-item>
                <a-form-item :label="$t('expired_at')" name="expired_at">
                    <a-date-picker v-model:value="modal.data.expire_at" :valueFormat="dateFormat" />
                </a-form-item>
                <a-form-item :label="$t('url')" name="url">
                    <a-input v-model:value="modal.data.url" />
                </a-form-item>
                <a-row>
                    <a-col>
                        <a-form-item :label="$t('published')" name="published">
                            <a-switch v-model:checked="modal.data.published" :checkedValue="1" :unCheckedValue="0" 
                            @change="modal.data.public = 0" />
                        </a-form-item>
                    </a-col>
                    <a-col class="pl-10" v-if="modal.data.published">
                        <a-form-item :label="$t('public')" name="public">
                            <a-switch v-model:checked="modal.data.public" :checkedValue="1" :unCheckedValue="0" />
                        </a-form-item>
                    </a-col>
                </a-row>

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
import ClasicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    components: {
        OrganizationLayout,
        ClasicEditor
    },
    props: ['classifies', 'articleCategories', 'articles'],
    data() {
        return {
            dateFormat: "YYYY-MM-DD",
            modal: {
                isOpen: false,
                data: {content_en:""},
                title: "Modal",
                mode: ""

            },
            teacherStateLabels: {},
            editor: ClasicEditor,
            editorConfig: {
                // The configuration of the editor.
            },
            columns: [
                {
                    title: 'Title',
                    dataIndex: 'title_en',
                }, {
                    title: 'Validated at',
                    dataIndex: 'validated_at',
                }, {
                    title: 'Expired at',
                    dataIndex: 'expired_at',
                }, {
                    title: 'Published',
                    dataIndex: 'published',
                }, {
                    title: 'Operation',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules: {
                category_code: { required: true },
                classify_id: { required: true },
                title_en: { required: true },
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
            this.modal.title = "Create";
            this.modal.isOpen = true;
        },
        editRecord(record) {
            this.modal.data = { ...record };
            this.modal.mode = "EDIT";
            this.modal.title = "Edit";
            this.modal.isOpen = true;
        },
        storeRecord() {
            this.$refs.modalRef.validateFields().then(() => {
                this.$inertia.post(route('manage.articles.store'), this.modal.data, {
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
                this.$inertia.put(route('manage.articles.update', this.modal.data.id), this.modal.data, {
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
        deleteConfirmed(record){
            this.$inertia.delete(route('manage.articles.destroy', record.id), {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    console.log(error);
                }
            });
        }, 
        //deleteRecord(recordId) {
            //if (!confirm('Are you sure want to remove?')) return;
            // this.$inertia.delete(route('manage.articles.destroy', recordId), {
            //     onSuccess: (page) => {
            //         console.log(page);
            //     },
            //     onError: (error) => {
            //         console.log(error);
            //     }
            // });
        //},
        createLogin(recordId) {
            console.log('create login' + recordId);
        },

    },
    watch:{
        "modal.data.content_en"(text){
            this.$emit("input",text)
        }
    }
}
</script>