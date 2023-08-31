<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events
            </h2>
        </template>
        <p></p>
        <div v-for="(instance, type) in instances" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a-typography-title :level="4">{{ type.toUpperCase() }}</a-typography-title>
            <a-table :dataSource="instance" :columns="columns">
                <template #headerCell="{ column }">
                    {{ column.i18n ? $t(column.i18n) : column.title }}
                </template>
                <template #bodyCell="{ column, text, record, index }">
                    <template v-if="column.dataIndex == 'operation'">
                        <inertia-link :href="route('member.attendees.scan', { type: 'event', id: record.id })" class="ant-btn">
                            Scan
                        </inertia-link>
                        <inertia-link :href="route('member.attendees.index', { type: 'event', id: record.id })" class="ant-btn">
                            Tick
                        </inertia-link>
                    </template>
                </template>
            </a-table>

        </div>
        <ol>
            <li v-for="attendance in instances['events']">
                <inertia-link :href="route('member.attendees.index', { type: 'event', id: attendance.id })">
                    {{ attendance.id }}-{{ attendance.title }}
                </inertia-link>
            </li>
        </ol>
        <ol>
            <li v-for="attendance in instances['forms']">
                <inertia-link :href="route('member.attendees.index', { type: 'form', id: attendance.id })">
                    {{ attendance.id }}-{{ attendance.title }}
                </inertia-link>
            </li>
        </ol>
        <ol>
            <li v-for="attendance in instances['attendances']">
                <inertia-link :href="route('member.attendees.index', { type: 'attendance', id: attendance.id })">
                    {{ attendance.id }}-{{ attendance.title }}
                </inertia-link>
            </li>
        </ol>

    </MemberLayout>
</template>

<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        MemberLayout,
    },
    props: ['instances', 'members'],
    data() {
        return {
            searchResult: [],
            selected: null,
            targetKeys: [],
            columns: [
                {
                    title: 'Category',
                    dataIndex: 'category',
                }, {
                    title: 'Title',
                    dataIndex: 'title',
                }, {
                    title: 'Credit',
                    dataIndex: 'credit',
                }, {
                    title: 'Start date',
                    dataIndex: 'data_start',
                }, {
                    title: 'End date',
                    dataIndex: 'date_end',
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
        //this.members.unshift({id:0,given_name:'Show all'})
        this.searchResult = this.members
    },
    methods: {
        destroy(record) {
            if (confirm('Are you sure to delete the attendance record?'))
                this.$inertia.delete(route('member.event.attendances.destroy', { event: this.event.id, attendance: record.id }), {
                    onSuccess: (page) => {
                        console.log(page);
                    },
                    onError: (error) => {
                        alert(error.message);
                    }

                });

        },
        handleChange(keys, direction, moveKeys) {
            console.log(keys, direction, moveKeys);
        },
        onCheck() {
            console.log(this.targetKeys);
        },
        onChangeStatus(record) {
            this.$inertia.put(route('member.event.attendances.update', { event: this.event.id, attendance: record.id }), record, {
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
            this.selected = val
        },
        handleSearch(val) {
            //this.members.
            console.log(val)
            if (val == '') {
                this.searchResult = this.members;
            } else {
                this.searchResult = this.members.filter(m => m.given_name.includes(val));
            }


        },
        addAttendance() {
            const data = { member_id: this.selected, status: 'ATT' }
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