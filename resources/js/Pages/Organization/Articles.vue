<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles
            </h2>
        </template>
            <div class="flex-auto pb-3 text-right">
                <a-button type="primary" class="!rounded" @click="createRecord()"
                >Create Article</a-button>
            </div>
            <a-table :dataSource="articles" :columns="columns">
                <template #headerCell="{column}">
                    {{ column.i18n?$t(column.i18n):column.title}}
                </template>
                <template #bodyCell="{column, text, record, index}">
                    <template v-if="column.dataIndex=='operation'">
                        <a-button @click="editRecord(record)">Edit</a-button>
                        <a-button @click="deleteRecord(record.id)">Delete</a-button>
                    </template>
                    <template v-if="column.dataIndex=='classify_id'">
                        {{classifies.find(c=>c.id=text).title}}
                    </template>
                    <template v-else>
                        {{record[column.dataIndex]}}
                    </template>
                </template>
            </a-table>

        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
        <a-form
            ref="modalRef"
            :model="modal.data"
            name="Teacher"
            layout="vertical"
            autocomplete="off"
            :rules="rules"
            :validate-messages="validateMessages"
        >
            <a-form-item :label="$t('classification')" name="classify_id">
                <a-select v-model:value="modal.data.classify_id" :options="classifies" :fieldNames="{value:'id',label:'title'}"/>
            </a-form-item>
            <a-form-item :label="$t('title_en')" name="title_en">
                <a-input v-model:value="modal.data.title_en" />
            </a-form-item>
            <a-form-item :label="$t('title_fn')" name="title_fn">
                <a-input v-model:value="modal.data.title_fn" />
            </a-form-item>
            <a-form-item :label="$t('content')" name="content">
                <quill-editor v-model:value="modal.data.content" style="min-height:200px;" />
            </a-form-item>
        </a-form>
        <template #footer>
            <a-button v-if="modal.mode=='EDIT'" key="Update" type="primary" @click="updateRecord()">Update</a-button>
            <a-button v-if="modal.mode=='CREATE'"  key="Store" type="primary" @click="storeRecord()">Add</a-button>
        </template>
    </a-modal>    
    <!-- Modal End-->
    </OrganizationLayout>

</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import { quillEditor } from 'vue3-quill';
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        OrganizationLayout,
        quillEditor
    },
    props: ['classifies','articles'],
    data() {
        return {
            dateFormat:"YYYY-MM-DD",
            modal:{
                isOpen:false,
                data:{},
                title:"Modal",
                mode:""
            },
            teacherStateLabels:{},
            columns:[
                {
                    title: 'Classification',
                    dataIndex: 'classify_id',
                },{
                    title: 'Title',
                    dataIndex: 'title_en',
                },{
                    title: 'Validated at',
                    dataIndex: 'validated_at',
                },{
                    title: 'Expired at',
                    dataIndex: 'expired_at',
                },{
                    title: 'Published',
                    dataIndex: 'published',
                },{
                    title: 'Operation',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules:{
                classify_id:{required:true},
                title_en:{required:true},
            },
            validateMessages:{
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
    created(){
    },
    methods: {
        createRecord(){
            this.modal.data={};
            this.modal.mode="CREATE";
            this.modal.title="新增問卷";
            this.modal.isOpen=true;
        },
        editRecord(record){
            this.modal.data={...record};
            this.modal.mode="EDIT";
            this.modal.title="修改";
            this.modal.isOpen=true;
        },
        storeRecord(){
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.post(route('manage.articles.store'), this.modal.data,{
                    onSuccess:(page)=>{
                        this.modal.data={};
                        this.modal.isOpen=false;
                    },
                    onError:(err)=>{
                        console.log(err);
                    }
                });
            }).catch(err => {
                console.log(err);
            });
        },
        updateRecord(){
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.put(route('manage.articles.update', this.modal.data.id), this.modal.data,{
                    onSuccess:(page)=>{
                        this.modal.data={};
                        this.modal.isOpen=false;
                        console.log(page);
                    },
                    onError:(error)=>{
                        console.log(error);
                    }
                });
            }).catch(err => {
                console.log("error", err);
            });
           
        },
        deleteRecord(recordId){
            if (!confirm('Are you sure want to remove?')) return;
            this.$inertia.delete(route('manage.articles.destroy',recordId),{
                onSuccess: (page)=>{
                    console.log(page);
                },
                onError: (error)=>{
                    console.log(error);
                }
            });
        },
        createLogin(recordId){
            console.log('create login'+recordId);
        },

    },
}
</script>