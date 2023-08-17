<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Members
            </h2>
        </template>
    
        <div class="flex-auto pb-3 text-right">
            <a-button type="primary" class="!rounded" @click="createRecord()"
            >Create Member</a-button>
        </div>
        <a-table :dataSource="members" :columns="columns">
            <template #headerCell="{column}">
                {{ column.i18n?$t(column.i18n):column.title}}
            </template>
            <template #bodyCell="{column, text, record, index}">
                <template v-if="column.dataIndex=='operation'">
                    <inertia-link :href="route('manage.members.show',record.id)" class="ant-btn">View</inertia-link>
                    <a-button @click="editRecord(record)">Edit(Popup)</a-button>
                    <a-button @click="deleteRecord(record.id)">Delete</a-button>
                    <a-button @click="createLogin(record.id)">Create login</a-button>
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
            <a-input type="hidden" v-model:value="modal.data.id"/>
            <a-form-item :label="$t('given_name')" name="given_name">
                <a-input v-model:value="modal.data.given_name" />
            </a-form-item>
            <a-form-item :label="$t('middle_name')" name="middle_name">
                <a-input v-model:value="modal.data.middle_name" />
            </a-form-item>
            <a-form-item :label="$t('family_name')" name="family_name">
                <a-input v-model:value="modal.data.family_name" />
            </a-form-item>
            <a-form-item :label="$t('display_name')" name="display_name">
                <a-input v-model:value="modal.data.display_name" />
            </a-form-item>
            <a-form-item :label="$t('gender')" name="gender">
                <a-radio-group v-model:value="modal.data.gender" button-style="solid">
                    <a-radio-button value="M">Male</a-radio-button>
                    <a-radio-button value="F">Female</a-radio-button>
                </a-radio-group>
            </a-form-item>
            <a-form-item :label="$t('dob')" name="dob">
                <a-date-picker v-model:value="modal.data.dob" :format="dateFormat" :valueFormat="dateFormat"/>
            </a-form-item>
            <a-form-item :label="$t('email')" name="email">
                <a-input v-model:value="modal.data.email" />
            </a-form-item>
            <a-form-item :label="$t('mobile')" name="mobile">
                <a-input v-model:value="modal.data.mobile" />
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
    props: ['members'],
    data() {
        return {
            dateFormat:'YYYY-MM-DD',
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
                    title: 'Family name',
                    dataIndex: 'family_name',
                    i18n:'family_name'
                },{
                    title: 'Gender',
                    dataIndex: 'gender',
                    i18n:'gender'
                },{
                    title: 'Date of birth',
                    dataIndex: 'dob',
                    i18n:'dob'
                },{
                    title: 'State',
                    dataIndex: 'state',
                    i18n:'state'
                },{
                    title: 'Operation',
                    dataIndex: 'operation',
                    key: 'operation',
                    i18n:'operation'
                },
            ],
            rules:{
                given_name:{required:true},
                family_name:{required:true},
                gender:{required:true},
                dob:{required:true},
                email:{required:true, type: 'email'},
                state:{required:true},
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
            this.modal.title="Create new member";
            this.modal.isOpen=true;
        },
        editRecord(record){
            this.modal.data={...record};
            this.modal.mode="EDIT";
            this.modal.title="Edit member record";
            this.modal.isOpen=true;
        },
        storeRecord(){
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.post(route('manage.members.store'), this.modal.data,{
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
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.patch(route('manage.members.update', this.modal.data.id), this.modal.data,{
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
            console.log(recordId);
            if (!confirm('Are you sure want to remove?')) return;
            this.$inertia.delete(route('manage.members.destroy',{member:recordId}));
        },
        createLogin(recordId){
            console.log(recordId);
            this.$inertia.post(route('manage.member.createLogin',recordId),{
                onSuccess:(page)=>{
                    this.modal.data={};
                    this.modal.isOpen=false;
                    console.log(page);
                },
                onError:(error)=>{
                    console.log(error);
                }
            })
        }
    },
}
</script>