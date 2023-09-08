<template>

    <WebLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Application Froms
            </h2>
        </template>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg ">
                <a-table :dataSource="forms" :columns="columns">
                    <template #bodyCell="{column, text, record, index}">
                        <template v-if="column.dataIndex=='operation'">
                            <a @click="toApply(record)">Apply</a>
                        </template>
                        <template v-else>
                            {{record[column.dataIndex]}}
                        </template>
                    </template>
                </a-table>
            </div>
        </div>


        <a-steps :current="currentStep">
            <a-step>
            <!-- <span slot="title">Finished</span> -->
            <template #title>Finished</template>
            <template #description>
                <span>This is a description.</span>
            </template>
            </a-step>
            <a-step title="In Progress" sub-title="Left 00:00:08" description="This is a description." />
            <a-step title="Waiting" description="This is a description." />
        </a-steps>
        <div v-if="currentStep==0" class="h-48 bg-sky-500">
            <p>Page 0</p>
        </div>
        <div v-if="currentStep==1"  class="h-48 bg-orange-500 transition duration-700 ease-in opacity-100" :class="currentStep==1?'opacity-50':'opacity-0'">
            <p>Page 1</p>
        </div>
        <div v-if="currentStep==2" class="h-48 bg-yellow-500 ">
            <p>Page 2</p>
        </div>
        <a-button @click="currentStep--">previours</a-button>
        <a-button @click="currentStep++">next</a-button>
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
                    title: 'Name',
                    dataIndex: 'name',
                },{
                    title: 'Title',
                    dataIndex: 'title',
                },{
                    title: 'Login',
                    dataIndex: 'require_login',
                },{
                    title: 'For member',
                    dataIndex: 'for_member',
                },{
                    title: 'Published',
                    dataIndex: 'published',
                },{
                    title: 'Action',
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