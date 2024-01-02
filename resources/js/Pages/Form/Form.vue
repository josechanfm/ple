<template>

    <WebLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{$t('event_registration')}}
            </h2>
        </template>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg ">
                <a-table :dataSource="forms" :columns="columns">
                    <template #bodyCell="{column, text, record, index}">
                        <template v-if="column.dataIndex=='operation'">
                            <a @click="toApply(record)">填寫</a>
                        </template>
                        <template v-else-if="column.dataIndex=='abbr'">
                            {{record.organization.abbr}}
                        </template>
                        <template v-else-if="column.type=='yesno'">
                            <span v-if="record[column.dataIndex]==1">
                                Yes
                            </span>
                            <span v-else>
                                No
                            </span>
                        </template>
                        <template v-else>
                            {{record[column.dataIndex]}}
                        </template>
                    </template>
                </a-table>
            </div>
        </div>

    </WebLayout>

</template>

<script>
import WebLayout from '@/Layouts/WebLayout.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        WebLayout,
    },
    props: ['forms'],
    data() {
        return {
            currentStep:1,
            items:[
                {
                    title: 'Login',
                    status: 'finish',
                },
                {
                    title: 'Verification',
                    status: 'finish',
                },
                {
                    title: 'Pay',
                    status: 'process',
                },
                {
                    title: 'Done',
                    status: 'wait',
                },
            ],
            columns:[
                {
                    title: '屬會',
                    dataIndex: 'abbr',
                },{
                    title: '名稱',
                    dataIndex: 'title',
                },{
                    title: '需要登入',
                    dataIndex: 'require_login',
                    type:'yesno'
                },{
                    title: '只供會員',
                    dataIndex: 'for_member',
                    type:'yesno'
                },{
                    title: '操作',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules:{
                field:{required:true},
                label:{required:true},
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
        toApply(record){
            if(record.require_login==0 || this.$page.props.user){
                Inertia.get(route('forms.show',record.id));
            }else{
                alert("login requierd");
            }
        }
    },
}
</script>


<style>
.fade-in-out {
  opacity: 0;
  animation: fade-in 1s ease-in forwards, fade-out 4s 1s ease-out forwards;
}
</style>