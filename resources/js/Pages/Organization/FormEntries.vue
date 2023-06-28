<template>
    <OrganizationLayout title="Dashboard" :department="department">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Management Dashboard department
            </h2>
        </template>
        <a-table :dataSource="entries" :columns="columns">
            <template #bodyCell="{column, text, record, index}">
                <template v-if="column.dataIndex=='operation'">
                    <a-button @click="viewRecord(record)">View</a-button>
                </template>
                <template v-else-if="column.dataIndex=='created_at'">
                    {{ record[column.dataIndex] }}
                </template>
                <template v-else>
                    {{record[column.dataIndex]}}
                </template>
            </template>
        </a-table>

        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" title="View Only" width="60%" >
            <ol>
                <li v-for="(field,idx) in form.fields">
                    {{ field.field_name?field.field_name:'Field_'+(idx+1)  }}: {{ getFieldValue(field) }}
                </li>
            </ol>
        </a-modal>    
    <!-- Modal End-->



    </OrganizationLayout>
</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';

export default {
    components: {
        OrganizationLayout,
    },
    props: ['form','entries','columns'],
    data() {
        return {
            modal:{
                isOpen:false,
                data:{},
                title:"Modal",
                mode:""
            },

            // columns:[
            //     {
            //         title: 'Number',
            //         dataIndex: 'uid',
            //     },{
            //         title: 'Username',
            //         dataIndex: 'username',
            //     },{
            //         title: 'Education',
            //         dataIndex: 'education',
            //     },{
            //         title: 'For Member',
            //         dataIndex: 'field',
            //     },{
            //         title: 'Published',
            //         dataIndex: 'published',
            //     },{
            //         title: 'Action',
            //         dataIndex: 'operation',
            //         key: 'operation',
            //     },
            // ],

        }
    },
    methods: {
        viewRecord(record){
            console.log(record);
            this.modal.data=record;
            this.modal.isOpen=true;
        },
        getFieldValue(field){
            const fv=this.modal.data.records.find(r=>r.form_field_id==field.id);
            if(fv){
                // if(field.type=='checkbox'){
                //     var entry=JSON.parse(this.modal.data.fields.find(f=>f.form_field_id==field.id).field_value)

                //     var list=[];
                    
                //     var options=JSON.parse(field.options);
                //     console.log(options);
                //     entry.forEach(f=>{
                //         list.push(options.find(o=>o.value==f).label)
                //         //list.push()
                //     })
                //     console.log(list);
                    
                //     return JSON.parse(fv.field_value,true);
                // }else{
                //     return fv.field_value;
                // }
                return fv.field_value
                
            }
            return '';
        }

    },
}
</script>