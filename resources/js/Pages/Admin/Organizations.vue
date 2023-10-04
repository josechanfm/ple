<template>
    <AdminLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Organizations
            </h2>
        </template>
        <button @click="createRecord()"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create Organization</button>
            <div class="container mx-auto pt-5">
                <div class="bg-white relative shadow rounded-lg overflow-x-auto">
                    <a-table :dataSource="organizations" :columns="columns">
                        <template #bodyCell="{column, text, record, index}">
                            <template v-if="column.dataIndex=='operation'">
                                <inertia-link :href="route('admin.organization.members',record.id)" class="ant-btn">Members</inertia-link>
                                <a-button @click="editRecord(record)">Edit</a-button>
                                <a-button @click="deleteRecord(record.id)">Delete</a-button>
                                <a-popconfirm
                                    title="Are you sure to delete the record?"
                                    ok-text="Yes"
                                    cancel-text="No"
                                    @confirm="deleteRecord(record)"
                                    >
                                    <a-button>Delete</a-button>
                                </a-popconfirm>
                            </template>
                            <template v-else-if="column.dataIndex=='region'">
                                {{ zones.find(z=>z.value==record[column.dataIndex]).label }}
                            </template>
                            <template v-else-if="column.dataIndex=='manager'">
                                <ol class="list-decimal">
                                    <li v-for="user in record['users']">
                                        {{ user.name }}
                                    </li>
                                </ol>
                            </template>
                            <template v-else>
                                {{record[column.dataIndex]}}
                            </template>
                        </template>
                    </a-table>
                </div>
            </div>
        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%" >
        <a-form
            ref="modalRef"
            :model="modal.data"
            name="Organization"
            :label-col="{ span: 8 }"
            :wrapper-col="{ span: 16 }"
            autocomplete="off"
            :rules="rules"
            :validate-messages="validateMessages"
        >
            <a-input type="hidden" v-model:value="modal.data.id"/>
            <a-form-item label="Region" name="region" :rules="[{required:true}]">
                <a-select v-model:value="modal.data.region" :options="zones"/>
            </a-form-item>
            <a-form-item label="Abbreviation" name="abbr" :rules="[{required:true}]">
                <a-input v-model:value="modal.data.abbr" />
            </a-form-item>
            <a-form-item label="Territory" name="territory" :rules="[{required:true}]">
                <a-input v-model:value="modal.data.territory" />
            </a-form-item>
            <a-form-item label="Country" name="country">
                <a-input v-model:value="modal.data.country" />
            </a-form-item>
            <a-form-item label="Full name" name="full_name" :rules="[{required:true}]">
                <a-input v-model:value="modal.data.full_name" />
            </a-form-item>
            <a-form-item label="Email" name="email">
                <a-input v-model:value="modal.data.email" />
            </a-form-item>
            <a-form-item label="Phone" name="phone">
                <a-input v-model:value="modal.data.phone" />
            </a-form-item>
            <a-form-item label="Address" name="address">
                <a-input v-model:value="modal.data.address" />
            </a-form-item>
            <a-form-item label="Website" name="href">
                <a-input v-model:value="modal.data.href" />
            </a-form-item>
            <a-form-item label="Registration Code" name="registration_code">
                <a-input v-model:value="modal.data.registration_code" />
            </a-form-item>
            <a-form-item label="Title" name="title">
                <a-input v-model:value="modal.data.title" />
            </a-form-item>
            <a-form-item label="Avatar" name="avatar">
                <a-input v-model:value="modal.data.avatar" />
            </a-form-item>
            <a-form-item label="Content" name="content">
                <a-input v-model:value="modal.data.content" />
            </a-form-item>
            <a-form-item label="President" name="president">
                <a-input v-model:value="modal.data.president" />
            </a-form-item>
            <a-form-item label="Status" name="status" :rules="[{required:true}]">
                <a-switch v-model:checked="modal.data.status"  :checkedValue="1" :unCheckedValue="0"/>
            </a-form-item>
            <a-form-item label="Manager" name="manager">
                <a-select v-model:value="modal.data.user_ids" 
                    mode="multiple"
                    :options="users"
                    :fieldNames="{value:'id',label:'name'}"
                />
            </a-form-item>
        </a-form>
        <template #footer>
            <a-button v-if="modal.mode=='EDIT'" key="Update" type="primary"  @click="updateRecord()">Update</a-button>
            <a-button v-if="modal.mode=='CREATE'"  key="Store" type="primary" @click="storeRecord()">Add</a-button>
        </template>
    </a-modal>    
    <!-- Modal End-->
    </AdminLayout>

</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        AdminLayout,
    },
    props: ['organizations','users'],
    data() {
        return {
            modal:{
                isOpen:false,
                data:{},
                title:"Modal",
                mode:""
            },
            zones:[
                {value:'C',label:"Central Zone"},
                {value:'SE',label:"South East Zone"},
                {value:'E',label:"East Zone"},
                {value:'W',label:"West Zone"},
                {value:'S',label:"South Zone"},
            ],
            organizationStates:[
                {value:'ACTIVE',label:"Active"},
                {value:'SUSPENDED',label:"Suspended"}
            ],
            columns:[
                {
                    title: 'Region',
                    dataIndex: 'region',
                },{
                    title: 'Territory',
                    dataIndex: 'territory',
                },{
                    title: 'Abbreviation',
                    dataIndex: 'abbr',
                },{
                    title: 'Full name',
                    dataIndex: 'full_name',
                },{
                    title: 'Email',
                    dataIndex: 'email',
                },{
                    title: 'Manager',
                    dataIndex: 'manager',
                },{
                    title: 'Operation',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules:{
                name_zh:{required:true},
                mobile:{required:true},
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
            this.modal.title="Create Record";
            this.modal.isOpen=true;
        },
        editRecord(record){
            this.modal.data={...record};
            this.modal.data.user_ids=record.users.map(item=>(item.id));
            this.modal.mode="EDIT";
            this.modal.title="Edit Record";
            this.modal.isOpen=true;
        },
        storeRecord(){
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.post(route('admin.organizations.store'), this.modal.data,{
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
                this.$inertia.patch(route('admin.organizations.update',this.modal.data.id), this.modal.data,{
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
        deleteRecord(record){
            this.$inertia.delete(route('admin.organizations.destroy',record.id),{
                onSuccess: (page)=>{
                    console.log(page);
                },
                onError: (error)=>{
                    console.log(error);
                }
            });
        },

    },
}
</script>
