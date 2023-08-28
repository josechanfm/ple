<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Attendees
            </h2>
        </template>

        <div class="container mx-auto pt-5">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <a-collapse v-model:activeKey="activeKey">
                    <a-collapse-panel key="1" header="Organization Members">
                        <ol>
                            <li v-for="member in members">
                                <a-checkbox v-model:checked="member.attend" @click="onCheckMember(member)" />
                                {{ member.member_number }} - {{ member.display_name }} {{ member.attend }}
                            </li>
                        </ol>
                    </a-collapse-panel>
                </a-collapse>
                <div>
                    <a-typography-title :level="5">Attended mebmers:</a-typography-title>
                    <template v-for="member in attendees">
                        <a-checkbox v-model:checked="member.attend" @click="onCheckAttendee(member)" />
                        {{ member.member_number }}-{{ member.display_name }} {{ member.attend }}<br>
                    </template>
                </div>
                
                <div class="flex-auto pb-3">
                    <inertia-link :href="route('member.attendees.scan',{type:instance.type,id:instance.id})"  class="ant-btn">Scan</inertia-link>
                    <a-button @click="onClickConfirm" class="float-right">Confirm</a-button>
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
    props: ['members', 'attendees','instance'],
    data() {
        return {
            attendedMembers: {},
            activeKey: [],
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
        Object.values(this.attendees).forEach(attendee => {
            attendee.attend=true
            var member = Object.values(this.members).find((m) => m.id == attendee.id)
        })
    },
    methods: {
        onCheckMember(member) {
            // this.attendees[member.id]=member
            var selected = Object.values(this.attendees).find((a) => a.id == member.id)
            if (selected != undefined) {
                selected.attend = !member.attend
            } else {
                this.attendees.push(member)
            }
            //this.attendedMembers[member.id]['attend']=!member.attend;
        },
        onCheckAttendee(member) {
            var selected=Object.values(this.members).find((m) => m.id == member.id)
            if(selected!==undefined){
                selected['attend'] = !member.attend

            }
        },
        onClickConfirm(){
            var data={}
            var selected=Object.values(this.attendees).filter((a) => a.attend)
            Object.values(this.attendees).forEach((attendee)=>{
                if(attendee.attend==true){
                    data[attendee.id]={'status':true}
                }
            })
            console.log(data)
            var type='event'
            var id=1

                axios.post(route('member.attendees.storeBatch',{type:type,id:id}),{attendees:data}).then(resp=>{
                    console.log(resp);
                })
        }
    },
}
</script>