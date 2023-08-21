<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events
            </h2>
        </template>

        <a-transfer
            v-model:target-keys="targetKeys"
            :data-source="members"
            show-search
            :list-style="{
            width: '250px',
            height: '300px',
            }"
            :operations="['', '']"
            :render="item => `${item.id}-${item.given_name}`"
            @change="handleChange"
        >

            <template #notFoundContent>
            <span>没数据</span>
            </template>
        </a-transfer>

        <a-button>Scan</a-button>        
        <inertia-link :href="route('member.event.attendancesModify',event.id)" class="ant-btn">Modify</inertia-link>
        <a-button @click="onCheck">Check</a-button>

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
            targetKeys:[],
            columns:[
                {
                    title: 'Event title',
                    dataIndex: 'title_en',
                },{
                    title: 'Start date',
                    dataIndex: 'start_date',
                },{
                    title: 'End date',
                    dataIndex: 'end_date',
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
        }
    },
}
</script>