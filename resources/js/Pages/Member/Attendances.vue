<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events
            </h2>
        </template>
        <a-select
            v-model:value="selected"
            show-search
            placeholder="input search text"
            style="width: 200px"
            :default-active-first-option="false"
            :show-arrow="false"
            :filter-option="false"
            :not-found-content="null"
            :options="searchResult"
            :fieldNames="{value:'id',label:'given_name'}"
            @search="handleSearch"
            @change="handleChange"
        ></a-select>
        <a-button @click="addAttendance">Add</a-button>
        
        <inertia-link :href="route('member.event.attendance.scan',event.id)" class="ant-btn">Scan</inertia-link>

        <a-table :dataSource="event.attendances" :columns="columns">
                <template #headerCell="{column}">
                    {{ column.i18n?$t(column.i18n):column.title}}
                </template>
                <template #bodyCell="{column, text, record, index}">
                    <template v-if="column.dataIndex=='operation'">
                        <inertia-link :href="route('member.event.attendances.destroy',{event:event.id,attendance:record.id})" class="ant-btn">Delete</inertia-link>
                        <a-button @click="destroy(record)">Delete</a-button>
                    </template>
                    <template v-else-if="column.dataIndex=='member'">
                        {{ record.member.given_name }}
                    </template>
                    <template v-else-if="column.dataIndex=='status'">
                        <a-radio-group v-model:value="record.status" button-style="solid" @change="onChangeStatus(record)">
                            <a-radio-button value="ATT">Attend</a-radio-button>
                            <a-radio-button value="lATE">Be Late</a-radio-button>
                            <a-radio-button value="EARLY">Leave Early</a-radio-button>
                        </a-radio-group>
                    </template>
                    <template v-else>
                        {{record[column.dataIndex]}}
                    </template>
                </template>
            </a-table>



    </MemberLayout>

</template>

<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        MemberLayout,
    },
    props: ['event','members'],
    data() {
        return {
            searchResult:[],
            selected:null,
            targetKeys:[],
            columns:[
                {
                    title: 'Event title',
                    dataIndex: 'member',
                },{
                    title: 'Start date',
                    dataIndex: 'status',
                },{
                    title: 'End date',
                    dataIndex: 'use_id',
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
        //this.members.unshift({id:0,given_name:'Show all'})
        this.searchResult=this.members
    },
    methods: {
        destroy(record){
            if(confirm('Are you sure to delete the attendance record?'))
            this.$inertia.delete(route('member.event.attendances.destroy', { event:this.event.id,attendance:record.id }), {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    alert(error.message);
                }

            });

        },
        handleChange(keys,direction,moveKeys){
            console.log(keys,direction,moveKeys);
        },
        onCheck(){
            console.log(this.targetKeys);
        },
        onChangeStatus(record){
            this.$inertia.put(route('member.event.attendances.update', { event:this.event.id,attendance:record.id }), record, {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    alert(error.message);
                }

            });

            console.log(record)
        },
        handleChange(val) {
            console.log(val);
            this.selected=val
        },
        handleSearch(val){
            //this.members.
            console.log(val)
            if(val==''){
                this.searchResult=this.members;
            }else{
                this.searchResult=this.members.filter(m=>m.given_name.includes(val));
            }
            

        },
        addAttendance(){
            const data={member_id:this.selected,status:'ATT'}
            this.$inertia.post(route('member.event.attendances.store', this.event.id), data, {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    alert(error.message);
                }

            });

        }
    },
}
</script>