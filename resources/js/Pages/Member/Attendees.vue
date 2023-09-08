<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{event.title_en}}
            </h2>
        </template>
        <div class="container mx-auto pt-5">
            <div class="flex-auto h-10">
                <a-radio-group v-model:value="status" button-style="solid">
                    <template v-for="status in attendance_status">
                        <a-radio-button :value="status.value">{{ status.label }}</a-radio-button>
                    </template>
                </a-radio-group>
                <a href="#" onclick="history.back();return false;" class="ant-btn float-right">Go Back</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="pb-2">

                    <a-button @click="onClickConfirm" class="float-right mr-5">Confirm</a-button>
                </div>
<!-- 
                <a-collapse v-model:activeKey="activeKey">
                    <a-collapse-panel key="1" header="Organization Members">
                        <ol>
                            <li v-for="member in members">
                                <a-checkbox v-model:checked="member.attended"/>
                                {{ member.member_number }} - {{ member.display_name }}
                            </li>
                        </ol>
                    </a-collapse-panel>
                </a-collapse> -->
                <div>
                    <a-typography-title :level="5">Attended mebmers:</a-typography-title>
                    <template v-for="attendee in attendees">
                        <a-checkbox v-model:checked="attendee.attended" @change="onChangeAttendee(attendee)" />
                        {{ attendee.attendee_id }}-{{ attendee.display_name }} {{ attendee.status }}<br>
                    </template>
                </div>
            </div>
        </div>

    </MemberLayout>
</template>

<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { ConsoleSqlOutlined } from '@ant-design/icons-vue';
import axios from 'axios';
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        MemberLayout,
    },
    props: ['event','attendees','attendance_status'],
    data() {
        return {
            //attendedMembers: {},
            activeKey: [],
            status:'ATTEND',
            columns: [
                {
                    title: 'Event title',
                    dataIndex: 'title_en',
                }, {
                    title: 'Start date',
                    dataIndex: 'start_date',
                }, {
                    title: 'End date',
                    dataIndex: 'end_date',
                }, {
                    title: 'Operation',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules: {
                name_zh: { required: true },
                mobile: { required: true },
                state: { required: true },
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
    mounted() {
        this.init()
    },
    methods: {
        init(){
            Object.values(this.attendees).forEach((attendee)=>{
                attendee['attended']=attendee.status?true:false;
            })
        },
        onChangeAttendee(attendee){
            attendee.status=attendee.attended?this.status:null
            console.log(attendee);
        },
        onClickConfirm(){
            var data=[]

            Object.values(this.attendees).forEach((attendee)=>{
                if(attendee.attended){
                    data.push({'id':attendee.id,'event_id':attendee.event_id,'display_name':attendee.display_name,'status':attendee.status})
                }
            })
            this.$inertia.put(route('member.event.attendees.update',this.event.id),data,{
                onSuccess: (page) => {
                    console.log(page);
                    this.init();
                },
                onError: (error) => {
                    alert(error.message);
                }
            })

            // axios.post(route('member.attendees.storeBatch',{type:this.type,id:this.instance.id}),{attendees:data}).then(resp=>{
            //     console.log(resp);
            // })
        }
    },
}
</script>