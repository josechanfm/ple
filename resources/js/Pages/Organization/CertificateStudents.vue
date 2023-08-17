<template>
    <OrganizationLayout title="Dashboard" :organization="organization">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Certificates
            </h2>
        </template>
            <div class="flex-auto pb-3 text-right">
                <a-button type="primary" class="!rounded" @click="createRecord()"
                >Create Certificate</a-button>
            </div>

            <a-table :dataSource="certificate.members" :columns="columns">
                <template #headerCell="{column}">
                    {{ column.i18n?$t(column.i18n):column.title}}
                </template>
                <template #bodyCell="{column, text, record, index}">
                    <template v-if="column.dataIndex=='operation'">
                        <a-button @click="editRecord(record)">Edit</a-button>
                    </template>
                    <template v-if="column.dataIndex=='display_name'">
                        {{record.pivot.display_name}}
                    </template>
                    <template v-else-if="column.dataIndex=='state'">
                        {{teacherStateLabels[text]}}
                    </template>
                    <template v-else>
                        {{record[column.dataIndex]}}
                    </template>
                </template>
            </a-table>

        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%" >
            {{modal.data}}
        <a-form
            ref="modalRef"
            :model="modal.data"
            name="Teacher"
            :label-col="{ span: 8 }"
            :wrapper-col="{ span: 16 }"
            autocomplete="off"
            :rules="rules"
            :validate-messages="validateMessages"
        >
            <!-- <a-form-item label="Certificate name" name="name">
                <a-input v-model:value="modal.data.name" />
            </a-form-item> -->
            <a-form-item label="Member" name="member_id">
                <a-select v-model:value="modal.data.member_id" :options="members" :fieldNames="{value:'id',label:'given_name'}" />
            </a-form-item>
            
            <a-form-item label="Display Name" name="display_name">
                <a-input v-model:value="modal.data.display_name" />
            </a-form-item>
            <a-form-item label="Number" name="number">
                <a-input v-model:value="modal.data.number" />
            </a-form-item>
            <a-form-item label="Number Display" name="number_display">
                <a-input v-model:value="modal.data.number_display" />
            </a-form-item>
            <a-form-item label="Issue Date" name="issue_date">
                <a-input v-model:value="modal.data.issue_date" />
            </a-form-item>
            <a-form-item label="Valid From" name="valid_from">
                <a-input v-model:value="modal.data.valid_from" />
            </a-form-item>
            <a-form-item label="Valid Until" name="valid_until">
                <a-input v-model:value="modal.data.valid_until" />
            </a-form-item>
            <a-form-item label="Auterized by" name="autherized_by">
                <a-input v-model:value="modal.data.autherized_by" />
            </a-form-item>
            <a-form-item label="Avata" name="avata">
                <a-input v-model:value="modal.data.avata" />
            </a-form-item>
        </a-form>
        <template #footer>
            <a-button v-if="modal.mode=='EDIT'" key="Update" type="primary"  @click="updateRecord()">Update</a-button>
            <a-button v-if="modal.mode=='CREATE'"  key="Store" type="primary" @click="storeRecord()">Add</a-button>
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
    props: ['organization','certificate','members'],
    data() {
        return {
            modal:{
                isOpen:false,
                data:{},
                title:"Modal",
                mode:""
            },
            teacherStateLabels:{},
            columns:[
                {
                    title: 'Given name',
                    dataIndex: 'given_name',
                    i18n:'given_name'
                },{
                    title: 'Family Name',
                    dataIndex: 'family_name',
                    i18n:'family_name'
                },{
                    title: 'Display Name',
                    dataIndex: 'display_name',
                    i18n:'display_name'
                },{
                    title: 'Gender',
                    dataIndex: 'gender',
                    i18n:'gender'
                },{
                    title: 'Email',
                    dataIndex: 'email',
                    i18n:'email'
                },{
                    title: 'Operation',
                    dataIndex: 'operation',
                    key: 'operation',
                    i18n:'operation'
                },
            ],
            rules:{
                display_name:{required:true},
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
            this.modal.data={
                
            };
            this.modal.mode="CREATE";
            this.modal.title="Create new Certificate";
            this.modal.isOpen=true;
        },
        editRecord(record){
            this.modal.data={...record.pivot};
            this.modal.mode="EDIT";
            this.modal.title="修改";
            this.modal.isOpen=true;
        },
        storeRecord(){
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.post(route('manage.certificates.store'), this.modal.data,{
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
            console.log(this.modal.data.pivot);
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.put(route('manage.certificate.members.update',{certificate:this.modal.data.certificate_id,member:this.modal.data.member_id}), this.modal.data,{
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
    },
}
</script>