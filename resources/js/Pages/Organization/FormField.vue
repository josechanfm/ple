<template>
    <OrganizationLayout title="Dashboard" :department="department">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                From Fields
            </h2>
        </template>
        <button @click="createRecord()"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create field</button>
            <a-table :dataSource="fields" :columns="columns">
                <template #bodyCell="{column, text, record, index}">
                    <template v-if="column.dataIndex=='operation'">
                        <a-button @click="editRecord(record)">Edit</a-button>
                        <a-button @click="deleteRecord(record)">Delete</a-button>
                    </template>
                    <template v-else>
                        {{record[column.dataIndex]}}
                    </template>
                </template>
            </a-table>

        <!-- Modal Start-->
        <a-modal v-model:visible="modal.isOpen" :title="modal.mode=='CREATE'?'新增':'修改'" width="60%" >
        <a-form
            ref="modalRef"
            :model="modal.data"
            name="formField"
            :label-col="{ span: 4 }"
            :wrapper-col="{ span: 20 }"
            autocomplete="off"
            :rules="rules"
            :validate-messages="validateMessages"
        >
            <!-- <a-form-item label="Field name" name="field_name">
                <a-input v-model:value="modal.data.field_name" />
            </a-form-item> -->
            <a-form-item label="Field Label" name="field_label">
                <a-input v-model:value="modal.data.field_label" @blur="onFieldLabelChanged"/>
            </a-form-item>
            <a-form-item label="Field Type" name="type">
                <a-select v-model:value="modal.data.type" placeholder="欄位類型" :options="fieldTypes" @change="onChangeType"/>
            </a-form-item>
            <a-form-item label="Rows" name="rows" v-if="['textarea','longtext','richtext'].includes(modal.data.type)">
                <a-input-number v-model:value="modal.data.options"/>
            </a-form-item>

            <template v-if="['radio','checkbox','dropdown'].includes(modal.data.type)">
                <a-form-item label="Options" name="options">
                    <a-radio-group>
                        <template v-for="option in modal.data.options">
                            <a-radio :style="verticalStyle" :value="option.value" >
                                <a-input v-model:value="option.label"/>
                            </a-radio>
                        </template>
                        <a-radio @click="addOptionItem"> Add option</a-radio>
                    </a-radio-group>
                </a-form-item>
                <a-form-item label="Template" name="optionTemplate">
                    <a-select :options="optionTemplates" @change="onChangeOptionTemplate"/>
                </a-form-item>
                <a-form-item label="Template" name="optionTemplate" v-if="['radio','checkbox'].includes(modal.data.type)">
                    <a-radio-group v-model:value="modal.data.direction">
                        <a-radio value="H">Horizontal</a-radio>
                        <a-radio value="V">Vertical</a-radio>
                    </a-radio-group>
                </a-form-item>
            </template>
            <a-form-item label="Compulsory" name="required">
                <a-switch v-model:checked="modal.data.required" :unCheckedValue="0" :checkedValue="1"/>
            </a-form-item>
            <!-- <a-form-item label="規則" name="rule">
                <a-input v-model:value="modal.data.rule" />
            </a-form-item> -->
            <a-form-item label="Column data" name="in_column" v-if="modal.data.required">
                <a-switch v-model:checked="modal.data.in_column" :unCheckedValue="0" :checkedValue="1"/>
            </a-form-item>
            <a-form-item label="Remark" name="remark">
                <a-textarea v-model:value="modal.data.remark" />
            </a-form-item>
        </a-form>
        <template #footer>
            <a-button v-if="modal.mode=='EDIT'" key="Update" type="primary"  @click="updateRecord()">更新</a-button>
            <a-button v-if="modal.mode=='CREATE'"  key="Store" type="primary" @click="storeRecord()">新增</a-button>
        </template>
    </a-modal>    
    <!-- Modal End-->
    </OrganizationLayout>

</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import { defineComponent, reactive } from 'vue';

export default {
    components: {
        OrganizationLayout,
    },
    props: ['department','form','fields'],
    data() {
        return {
            modal:{
                isOpen:false,
                data:{},
                title:"Modal",
                mode:""
            },
            fieldTypes:[
                {value:"input",label:"Short text"},
                {value:"textarea",label:"Long text"},
                {value:"largetext",label:"Huge text"},
                {value:"richtext",label:"Text with format"},
                {value:"radio",label:"Single selection"},
                {value:"checkbox",label:"Multiple selection"},
                {value:"dropdown",label:"Pull down menu"},
                {value:"true_false",label:"True/False"},
                {value:"date",label:"Date"},
                {value:"datetime",label:"Date Time"},
                {value:"email",label:"Email"},
                {value:"number",label:"Number"},
            ],
            columns:[
                {
                    title: 'Field Label',
                    dataIndex: 'field_label',
                },{
                    title: 'Field Type',
                    dataIndex: 'type',
                },{
                    title: 'Compulsory',
                    dataIndex: 'required',
                },{
                    title: 'Column Data',
                    dataIndex: 'in_column',
                },{
                    title: 'Operation',
                    dataIndex: 'operation',
                    key: 'operation',
                },
            ],
            rules:{
                field_label:{required:true},
                type:{required:true},
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
            verticalStyle:{
                display: 'flex',
                height: '30px',
                lineHeight: '30px',
                width: '100%'
            },
            optionTemplates:[
                {value:'agree',label:'同意程度',template:[
                    {value:5,label:'非常同意'},
                    {value:4,label:'同意'},
                    {value:3,label:'普通'},
                    {value:2,label:'不同意'},
                    {value:1,label:'非常不同意'},
                    {value:0,label:'不適用'}
                ]},
                {value:'gender',label:'性別',template:[{value:'M',label:'男'},{value:'F',label:'女'}]},
                {value:'clear',label:'重設',template:[{value:'option_1',label:'option_1'}]},
            ]
        }
    },
    created(){
    },
    methods: {
        createRecord(){
            this.modal.data={};
            this.modal.data.form_id=this.form.id;
            this.modal.data.direction='V';
            this.modal.mode="CREATE";
            this.modal.isOpen=true;
        },
        editRecord(record){
            this.modal.data={...record};
            try{
                this.modal.data.options=JSON.parse(this.modal.data.options);
            }catch (e){
                this.modal.data.options=[{value:'option_1',label:'option_1'}];
            }
            this.modal.mode="EDIT";
            this.modal.isOpen=true;
        },
        storeRecord(){
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.post(route('manage.form.fields.store',{
                    form:this.form.id
                }), this.modal.data, {
                    onSuccess:(page)=>{
                        this.modal.data={};
                        this.modal.isOpen=false;
                    },
                    onError:(err)=>{
                        console.log(err);
                    }
                });
            }).catch(err => {
                console.log(err);
            });
        },
        updateRecord(){
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(()=>{
                this.$inertia.patch(route('manage.form.fields.update', {
                    form:this.form.id,
                    field:this.modal.data
                }), this.modal.data, {
                    onSuccess:(page)=>{
                        this.modal.data={};
                        this.modal.isOpen=false;
                        console.log(page);
                    },
                    onError:(error)=>{
                        console.log(error);
                    }
                });
            }).catch(err => {
                console.log("error", err);
            });
        },
        deleteRecord(record){
            if (!confirm('Are you sure want to remove?')) return;
            this.$inertia.delete(route('form.fields.destroy', {
                form:this.form.id, field:record.id
            }),{
                onSuccess: (page)=>{
                    console.log('the field has been deleted!');
                },
                onError: (error)=>{
                    alert(error.message);
                }

            });
        },
        addOptionItem(){
            console.log(this.modal.data.options.length+1);
            const newOption='option_'+(this.modal.data.options.length+1);
            this.modal.data.options.push({value:newOption,label:newOption})
        },
        onChangeOptionTemplate(value){
            this.modal.data.options=this.optionTemplates.find(t=>t.value==value).template
        },
        onChangeType(value){
            if(['textarea','longtext','richtext'].includes(this.modal.data.type)){
                if(!Number.isInteger(this.modal.data.type)){
                    this.modal.data.options=5;
                }
            }else if(['radio','checkbox'].includes(this.modal.data.type)){
                if(typeof this.modal.data.options !== 'object'){
                    this.modal.data.options=[{value:'option_1',label:'option_1'}];
                }
            }
        },
        onFieldLabelChanged(value){
            if(!this.modal.data.field_name){
                this.modal.data.field_name=this.modal.data.field_label;
            }
        }
    },
    watch:{
        // "modal.data.type": function($value){
        //     if($value=='agree'){
        //         // if(this.modal.data.options=='null'){
        //             this.modal.data.options=[
        //                 {value:5,label:'非常同意'},
        //                 {value:4,label:'同意'},
        //                 {value:3,label:'普通'},
        //                 {value:2,label:'不同意'},
        //                 {value:1,label:'非常不同意'},
        //                 {value:0,label:'不適用'}
        //             ]
        //         //}
        //     }
        // }
    }
}
</script>
