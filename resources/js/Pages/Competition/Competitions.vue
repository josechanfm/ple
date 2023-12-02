<template>

    <WebLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                賽事報名
            </h2>
        </template>
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg ">
                <a-table :dataSource="competitions" :columns="columns">
                    <template #bodyCell="{column, text, record, index}">
                        <template v-if="column.dataIndex=='operation'">
                            <a @click="toApply(record)">報名</a>
                        </template>
                        <template v-if="column.dataIndex=='for_member'">
                            <span v-if="text">
                                是
                            </span>
                            <span v-else>
                                否
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
    props: ['competitions'],
    data() {
        return {
            columns:[
                {
                    title: '賽事名稱',
                    dataIndex: 'title_zh',
                },{
                    title: '日期',
                    dataIndex: 'start_date',
                },{
                    title: '只限會員',
                    dataIndex: 'for_member',
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
                Inertia.get(route('competitions.show',record.id));
            }else{
                alert("login requierd");
            }
        }
    },
}
</script>