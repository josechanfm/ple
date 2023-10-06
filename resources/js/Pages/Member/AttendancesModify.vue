<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events
            </h2>
        </template>
        <a-select v-model:value="selected" :options="members" :fieldNames="{value:'id',label:'given_name'}" style="width:100px"/>
        <a-button>Scan</a-button>

        <a-table :dataSource="event.attendances" :columns="columns">
                <template #headerCell="{column}">
                    {{ column.i18n?$t(column.i18n):column.title}}
                </template>
                <template #bodyCell="{column, text, record, index}">
                    <template v-if="column.dataIndex=='operation'">
                        <inertia-link :href="route('member.event.attendances.destroy',{event:record.event_id,attendance:record.id})" class="ant-btn">{{$t('delete')}}</inertia-link>
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
        Object.entries(this.event.attendances).forEach(([key,attendance])=>{
            this.targetKeys.push(attendance.member.id.toString())
        })
        Object.entries(this.members).forEach(([key,member])=>{
            this.members[key]['key']=member.id.toString()
        })
    },
    methods: {
        handleChange(keys,direction,moveKeys){
            console.log(keys,direction,moveKeys);
        },
        onCheck(){
            console.log(this.targetKeys);
        },
        onChangeStatus(record){
            this.$inertia.put(route('member.event.attendances.update', { event:record.event_id,attendance:record.id }), record, {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    alert(error.message);
                }

            });

            console.log(record)
        }
    },
}
</script>