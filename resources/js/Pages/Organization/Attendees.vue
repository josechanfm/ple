<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events
            </h2>
        </template>
            <div class="flex-auto pb-3 text-right">
                <inertia-link class="ant-btn ant-btn-primary">Add attendees</inertia-link>
            </div>
            <a-table :dataSource="attendees" :columns="columns">
                <template #headerCell="{column}">
                    {{ column.i18n?$t(column.i18n):column.title}}
                </template>
                <template #bodyCell="{column, text, record, index}">
                    <template v-if="column.dataIndex=='operation'">
                        <inertia-link class="ant-btn">View</inertia-link>
                        <inertia-link class="ant-btn">Edit</inertia-link>
                    </template>
                    <template v-else-if="column.dataIndex=='member'">
                        <template v-if="record.member">
                            Member:{{ record.member.member_number }}
                        </template>
                        <template v-else-if="record.participant">
                            {{ record.participant }}
                        </template>
                    </template>
                    <template v-else>
                        {{record[column.dataIndex]}}
                    </template>
                </template>
            </a-table>

    </OrganizationLayout>

</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        OrganizationLayout,
    },
    props: ['event','attendees'],
    data() {
        return {
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
    },
    methods: {
    },
}
</script>