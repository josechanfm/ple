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
                        <a-button @click="deleteAttendee(record)">delete</a-button>
                    </template>
                    <template v-else-if="column.dataIndex=='member'">
                        <template v-if="record.member">
                            Member:{{ record.member.member_number }}
                        </template>
                        <template v-else-if="record.participant">
                            {{ record.participant }}
                        </template>
                    </template>
                    <template v-else-if="column.dataIndex=='display_name'">
                        <div class="editable-cell">
                            <div v-if="editableData[record.id]"  class="editable-cell-input-wrapper">
                                <a-input v-model:value="editableData[record.id].display_name" @pressEnter="save(record.key)" />
                                <check-outlined class="editable-cell-icon-check" @click="saveAttendee(record)" />
                            </div>
                            <div v-else class="editable-cell-text-wrapper">
                                {{ text || ' ' }}
                                <edit-outlined class="editable-cell-icon" @click="editAttendee(record)" />
                            </div>
                        </div>
                    </template>
                    <template v-else-if="column.dataIndex=='status'">
                        <a-select v-model:value="record.status" :options="attendance_status" style="width:100px" @change="updateAttendeeAttendance(record)"></a-select>
                    </template>
                    <template v-else>
                        {{record[column.dataIndex]}}
                    </template>
                </template>
            </a-table>

                    <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
            <a-collapse  v-model:activeKey="activeKey" accordion>
                <a-collapse-panel key="1" header="Select Members to attendee list">
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
                </a-collapse-panel>
                <a-collapse-panel key="2" header="Input Non-member to attendee list">
                    <ol class="list-disc ml-5">
                        <li v-for="(name,id) in inputNameList">
                            {{ name.display_name }}
                            <span class="float-right text-red-300" @click="deleteFromInputNameList(id)"><DeleteOutlined /></span>
                        </li>
                    </ol>
                    <a-form-item :label="$t('attendee_name')" name="attendeeName">
                        <a-input v-model:value="inputName"/>
                    </a-form-item>
                    <a-button @click="addInputName">Add</a-button>
                    <a-button @click="storeInputNameList" class="float-right">Save</a-button>
                </a-collapse-panel>
                <a-collapse-panel key="3" header="Batch input non-member to attendee list">
                    <ol class="list-disc ml-5">
                        <li v-for="name in inputNameList">
                            {{ name.display_name }}
                            <span class="float-right text-red-300" @click="deleteFromInputNameList(id)"><DeleteOutlined /></span>
                        </li>
                    </ol>
                    <label>{{ $t('attendee_name') }}</label>
                    <a-textarea v-model:value="batchInputNames" :rows="10"></a-textarea>
                    <a-button @click="addBatchInputNames">Add</a-button>
                    <a-button @click="storeInputNameList" class="float-right">Save</a-button>
                </a-collapse-panel>
            </a-collapse>
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
import { DeleteOutlined,CheckOutlined,EditOutlined } from '@ant-design/icons-vue';

export default {
    components: {
        OrganizationLayout,
        DeleteOutlined,
        CheckOutlined,
        EditOutlined
    },
    props: ['event','attendees','members','attendance_status'],
    data() {
        return {
            editableData:{},
            activeKey:['1'],
            targetKeys:[],
            selectedKeys:[],
            inputName:null,
            inputNameList:[],
            batchInputNames:null,
            batchInputNameList:[],
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
        Object.values(this.attendees).forEach((attendee)=>{
            if(attendee.attendee_type=='App\\Models\\Member'){
                this.targetKeys.push(attendee.attendee_id.toString())
            }
        })
    },
    methods: {
        addAttendees(){
            this.modal.title="Add Attendees"
            this.modal.isOpen=true
        },
        onClickShowSelected(){
            var data={}
            this.members.forEach(m=>{
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
            this.$inertia.post(route('manage.event.attendees.store',this.event.id), {model:'other',data:this.inputNameList}, {
                onSuccess: (page) => {
                    this.modal.data = {}
                    this.modal.isOpen = false
                    this.inputNameList=[]
                },
                onError: (err) => {
                    console.log(err);
                }
            });
        },
        addBatchInputNames(){
          var items = this.batchInputNames.split(/[',|;|\r|\n']/).filter(i => i !== '')
          items.forEach(i=>{
            this.inputNameList.push({'display_name':i})
          })
          this.batchInputNames=null
        },
        deleteFromInputNameList(id){
            this.inputNameList.splice(id,1)
        },  
        deleteAttendee(attendee){
            this.$inertia.delete(route('manage.event.attendees.destroy',{event:this.event.id,attendee:attendee.id}),{
                onSuccess: (page) => {
                    console.log('attendee removed!');
                },
                onError: (err) => {
                    console.log(err);
                }
            });
        },
        editAttendee(attendee){
            this.editableData[attendee.id]=attendee
        },
        saveAttendee(attendee){
            this.$inertia.patch(route('manage.event.attendees.update',{event:this.event.id,attendee:attendee.id}),attendee,{
                onSuccess: (page) => {
                    console.log('attendee name updated!');
                },
                onError: (err) => {
                    console.log(err);
                }
            });
            delete this.editableData[attendee.id]
        },
        updateAttendeeAttendance(attendee){
            console.log(attendee)
            this.saveAttendee(attendee)
        },
        handleChange(keys,direction,moveKeys){
            console.log(keys,direction,moveKeys);
        },

    },
}
</script>

<style scoped>
.editable-cell {
  position: relative;
  .editable-cell-input-wrapper,
  .editable-cell-text-wrapper {
    padding-right: 24px;
  }

  .editable-cell-text-wrapper {
    padding: 5px 24px 5px 5px;
  }

  .editable-cell-icon,
  .editable-cell-icon-check {
    position: absolute;
    right: 0;
    width: 20px;
    cursor: pointer;
  }

  .editable-cell-icon {
    margin-top: 4px;
    display: none;
  }

  .editable-cell-icon-check {
    line-height: 28px;
  }

  .editable-cell-icon:hover,
  .editable-cell-icon-check:hover {
    color: #108ee9;
  }

  .editable-add-btn {
    margin-bottom: 8px;
  }
}
.editable-cell:hover .editable-cell-icon {
  display: inline-block;
}
</style>