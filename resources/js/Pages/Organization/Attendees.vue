<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events
            </h2>
        </template>
            <div class="flex-auto pb-3 text-right">
                <a-button  @click="addAttendees">Add attendees</a-button>
            </div>
            <a-table :dataSource="attendees" :columns="columns">
                <template #headerCell="{column}">
                    {{ column.i18n?$t(column.i18n):column.title}}
                </template>
                <template #bodyCell="{column, text, record, index}">
                    <template v-if="column.dataIndex=='operation'">
                        <inertia-link class="ant-btn">View</inertia-link>
                        <inertia-link class="ant-btn">Edit</inertia-link>
                    </template>
                    <template v-else-if="column.dataIndex=='member'">
                        <template v-if="record.member">
                            Member:{{ record.member.member_number }}
                        </template>
                        <template v-else-if="record.participant">
                            {{ record.participant }}
                        </template>
                    </template>
                    <template v-else>
                        {{record[column.dataIndex]}}
                    </template>
                </template>
            </a-table>

                    <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
            <a-transfer
                v-model:target-keys="targetKeys"
                v-model:selected-keys="selectedKeys"
                :data-source="members.map(m=>({key:m.id.toString(),title:m.display_name}))"
                show-search
                :list-style="{width:'250px',height:'300px'}"
                :operations="['','']"
                :titles="['Members','Attendees']"
                :render="item => `${item.key}-${item.title}`"
                @change="handleChange"
            />
            <a-button @click="onClickShowSelected">Add Members as attendees</a-button>
            <ol>
                <li v-for="name in inputNameList">{{ name }}</li>
            </ol>
            <a-input v-model:value="inputName"/>
            <a-button @click="addInputName">Add</a-button>
            <a-button @click="storeInputNameList">Add</a-button>
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
    props: ['event','attendees','members'],
    data() {
        return {
            targetKeys:[],
            selectedKeys:[],
            inputName:null,
            inputNameList:[],
            modal: {
                isOpen: false,
                title: "Modal",
            },
            columns:[
                {
                    title: 'Display Name',
                    dataIndex: 'display_name',
                },{
                    title: 'Attendance Status',
                    dataIndex: 'status',
                },{
                    title: 'Member',
                    dataIndex: 'member',
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
        addAttendees(){
            this.modal.title="Add Attendees"
            this.modal.isOpen=true
        },
        onClickShowSelected(){
            var data={}
            this.members.forEach(m=>{
                console.log(m);
                if(this.targetKeys.includes(m.id.toString())){
                    data[m.id]={"display_name":m.display_name}
                }
            })
            this.$inertia.post(route('manage.event.attendees.store',this.event.id), {model:'member',data:data}, {
                onSuccess: (page) => {
                    this.modal.data = {};
                    this.modal.isOpen = false;
                },
                onError: (err) => {
                    console.log(err);
                }
            });

        },
        addInputName(){
            this.inputNameList.push({display_name:this.inputName})
            this.inputName=null
        },
        storeInputNameList(){
            console.log(this.inputNameList);
            this.$inertia.post(route('manage.event.attendees.store',this.event.id), {model:'other',data:this.inputNameList}, {
                onSuccess: (page) => {
                    this.modal.data = {};
                    this.modal.isOpen = false;
                },
                onError: (err) => {
                    console.log(err);
                }
            });
           
        },
        handleChange(keys,direction,moveKeys){
            console.log(keys,direction,moveKeys);
        },

    },
}
</script>