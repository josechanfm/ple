<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{instance.title}}
            </h2>
        </template>
        {{ attendedMembers }}
        <div class="container mx-auto pt-5">
            <div class="flex-auto h-10">
                <a-radio-group v-model:value="status" button-style="solid">
                        <a-radio-button value="ATTEND">Attend</a-radio-button>
                        <a-radio-button value="LATE">Late</a-radio-button>
                        <a-radio-button value="EXCUSED">Excused</a-radio-button>
                        <a-radio-button value="VACATION">Vacation</a-radio-button>
                    </a-radio-group>
                    <a href="#" onclick="history.back();return false;" class="ant-btn float-right">Go Back</a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="pb-2">
                    <inertia-link :href="route('member.attendees.scan',{type:this.type,id:instance.id})"  class="ant-btn ml-5">Scan</inertia-link>
                    <a-button @click="onClickConfirm" class="float-right mr-5">Confirm</a-button>
                </div>

                <a-collapse v-model:activeKey="activeKey">
                    <a-collapse-panel key="1" header="Organization Members">
                        <ol>
                            <li v-for="member in members">
                                <a-checkbox v-model:checked="member.attended" @click="onCheckMember(member)" />
                                {{ member.member_number }} - {{ member.display_name }}
                            </li>
                        </ol>
                    </a-collapse-panel>
                </a-collapse>
                <div>
                    <a-typography-title :level="5">Attended mebmers:</a-typography-title>
                    <template v-for="attendee in attendedMembers">
                        <a-checkbox v-model:checked="attendee.attended" @click="onChangeAttendee(attendee)" />
                        {{ attendee.attendee_id }}-{{ attendee.display_name }} {{ attendee.pivot.status }}<br>
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
    props: ['members','participants','attendedMembers','attendedParticipants', 'attendees','instance','type'],
    data() {
        return {
            //attendedMembers: {},
            activeKey: [],
            status:'ATTEND',
            columns: [
                {
                    title: 'Comptition title',
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
        //this.init();
    },
    methods: {
        init(){
            Object.values(this.attendees).forEach(attendee => {
                attendee.attend=true
                attendee.status=attendee.pivot.status
                var member = Object.values(this.members).find((m) => m.id == attendee.id)
            })
        },
        onCheckMember(member) {
            // this.attendees[member.id]=member
            var selected = Object.values(this.attendedMembers).find((a) => a.id == member.id)

            if (selected != undefined) {
                console.log(selected);
                //selected.pivot={'status':this.status};
                selected['attended'] = !member.attended
            } else {
                console.log(this.attendedMembers[member.id]);
                //this.attendedMembers[member.id]['pivot']['status']=this.status;
                this.attendedMembers[member.id]=member;
                //this.attendedMembers.push(member)
            }
            //this.attendedMembers[member.id]['attend']=!member.attend;
        },
        onChangeAttendee(attendee) {
            var selected=Object.values(this.members).find((m) => m.id == attendee.id)
            attendee.pivot.status=attendee.attended?null:this.status
            if(selected!==undefined){
                selected.status = null
                selected.attended = !attendee.attended
            }
        },
        onClickConfirm(){
            var data={}
            var selected=Object.values(this.attendees).filter((a) => a.attend)
            Object.values(this.attendees).forEach((attendee)=>{
                if(attendee.attend==true){
                    data[attendee.id]={'status':attendee.status}
                }
            })
            this.$inertia.post(route('member.attendees.storeBatch',{type:this.type,id:this.instance.id}),{attendees:data},{
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