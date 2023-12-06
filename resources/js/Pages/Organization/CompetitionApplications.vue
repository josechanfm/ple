<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("applications") }}
      </h2>
    </template>

    <a-button @click="printReceipt">打印收據</a-button>
    <a-table 
      :dataSource="competition.applications" 
      :columns="columns"
      :rowSelection="{
        selectedRowKeys:selectedRowKeyIds,
        onChange:onCheckChange,
        onSelectAll:onCheckSelectAll,
        onSelect:onCheckSelect}"
      rowKey="id"
    >
      <template #headerCell="{ column }">
        {{ column.i18n ? $t(column.i18n) : column.title }}
      </template>
      <template #bodyCell="{ column, text, record, index }">
        <template v-if="column.dataIndex == 'operation'">
          <a-button @click="editRecord(record)">{{ $t("edit") }}</a-button>
          <a-button @click="deleteRecord(record)">{{ $t("delete") }}</a-button>
        </template>
        <template v-else-if="column.dataIndex == 'full_name'">
          {{ record.given_name }} {{ record.middle_name }} {{ record.family_name }}
        </template>
        <template v-else-if="column.dataIndex == 'age'">
          {{calculateAge(record.dob)}}      
        </template>
        <template v-else-if="column.dataIndex == 'avatar'">
          <img :src="record.avatar_url" width="60"/>
        </template>
        <template v-else>
          {{ record[column.dataIndex] }}
        </template>
      </template>
    </a-table>
    <!-- Modal Start-->
    <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
      <a-form
        ref="modalRef"
        :model="modal.data"
        name="Teacher"
        :label-col="{ span: 4 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
      >
        <!-- <a-form-item label="Certificate name" name="name">
                <a-input v-model:value="modal.data.name" />
            </a-form-item> -->
        <a-form-item :label="$t('name_zh')" name="name_zh">
          <a-input v-model:value="modal.data.name_zh" />
        </a-form-item>
        <a-form-item :label="$t('name_fn')" name="name_fn">
          <a-input v-model:value="modal.data.name_fn" />
        </a-form-item>
        <a-form-item :label="$t('id_num')" name="id_num">
          <a-input v-model:value="modal.data.id_num" />
        </a-form-item>
        <a-form-item :label="$t('display_name')" name="display_name">
          <a-input v-model:value="modal.data.display_name" />
        </a-form-item>
        <a-form-item :label="$t('email')" name="email">
          <a-input v-model:value="modal.data.email" />
        </a-form-item>
        <a-form-item :label="$t('mobile_number')" name="mobile">
          <a-input v-model:value="modal.data.mobile" />
        </a-form-item>
        <a-row :span="24">
          <a-col :span="18">
            <a-form-item :label="$t('gender')" :label-col="{ span: 5 }" name="gender">
              <a-radio-group
                v-model:value="modal.data.gender"
                button-style="solid"
                @change="onChangeGender"
              >
                <a-radio-button value="M">{{$t('male')}}</a-radio-button>
                <a-radio-button value="F">{{$t('female')}}</a-radio-button>
              </a-radio-group>
            </a-form-item>
            <a-form-item :label="$t('dob')" :label-col="{ span: 5 }" name="dob">
              <a-date-picker
                v-model:value="modal.data.dob"
                :format="dateFormat"
                :valueFormat="dateFormat"
              />
            </a-form-item>
            <a-form-item :label="$t('role')" :label-col="{ span: 5 }" name="role">
              <a-select v-model:value="modal.data.role" :options="competition.roles" />
            </a-form-item>
            <template v-if="modal.data.role == 'athlete'">
              <a-form-item
                :label="$t('category')"
                :label-col="{ span: 5 }"
                name="category"
              >
                <a-select
                  v-model:value="modal.data.category"
                  :options="competition.categories_weights"
                  :fieldNames="{ value: 'code', label: 'name' }"
                  @change="onChangeCategory"
                />
              </a-form-item>
              <a-form-item :label="$t('weight')" :label-col="{ span: 5 }" name="weight">
                <a-select
                  v-model:value="modal.data.weight"
                  :options="modal.data.weight_list"
                  :fieldNames="{ value: 'code', label: 'name' }"
                />
              </a-form-item>
            </template>
          </a-col>
          <a-col>
              <img :src="modal.data.avatar_url" width="200"/>
          </a-col>
        </a-row>
        

      </a-form>
      <template #footer>
        <a-button
          v-if="modal.mode == 'EDIT'"
          key="Update"
          type="primary"
          @click="updateRecord()"
          >{{$t('update')}}</a-button
        >
        <a-button
          v-if="modal.mode == 'CREATE'"
          key="Store"
          type="primary"
          @click="storeRecord()"
          >{{$t('add')}}</a-button
        >
      </template>
    </a-modal>
    <!-- Modal End-->
  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { defineComponent, reactive } from "vue";
import dayjs from "dayjs";
import { Modal } from 'ant-design-vue';
import { ref, createVNode } from 'vue';
import { ExclamationCircleOutlined } from '@ant-design/icons-vue';

export default {
  components: {
    OrganizationLayout,Modal,createVNode,ExclamationCircleOutlined
  },
  props: ["competition"],
  data() {
    return {
      dateFormat: "YYYY-MM-DD",
      modal: {
        isOpen: false,
        data: {},
        title: "Modal",
        mode: "",
      },
      teacherStateLabels: {},
      columns: [
        {
          title: "Name (zh)",
          i18n:"name_zh",
          dataIndex: "name_zh",
          key:'name_zh',
        },{
          title: "Name (fn)",
          i18n:"name_fn",
          dataIndex: "name_fn",
          key: "name_fn",
        },{
          title: "Gender",
          i18n:"gender",
          dataIndex: "gender",
          key: "gender",
        },{
          title: "Age",
          i18n:"age",
          dataIndex: "age",
          key: "age",
        },{
          title: "Date of Birth",
          i18n:"dob",
          dataIndex: "dob",
          key: "dob",
        },{
          title: "Role",
          i18n:"role",
          dataIndex: "role",
          key: "role",
        },{
          title: "Category",
          i18n:"category",
          dataIndex: "category",
          key: "category",
        },{
          title: "Weight",
          i18n:"weight",
          dataIndex: "weight",
          key: "weight",
        },{
          title: "Avatar",
          i18n:"avatar",
          dataIndex: "avatar",
          key: "avatar",
        },{
          title: "Operation",
          i18n:"operation",
          dataIndex: "operation",
          key: "operation",
        },
      ],
      rules: {
        name_fn: { required: true },
        display_name: { required: true },
        id_num: { required: true },
        dob: { required: true },
        role: { required: true },
        email: { required: true, type: "email" },
        mobile: { required: true },
        state: { required: true },
      },
      validateMessages: {
        required: "${label} is required!",
        types: {
          email: "${label} is not a valid email!",
          number: "${label} is not a valid number!",
        },
        number: {
          range: "${label} must be between ${min} and ${max}",
        },
      },
      labelCol: {
        style: {
          width: "150px",
        },
      },
      selectedRowKeyIds:[],
    };
  },
  created() {
  },
  methods: {
    onChangeGender(gender) {
      this.modal.data.category = null;
      this.modal.data.weight = null;
    },
    onChangeCategory(category) {
      this.modal.data.weight = null;
      this.genWeightList();
    },
    editRecord(record) {
      this.modal.data = { ...record };
      //this.modal.data.dob=dayjs(this.modal.data.dob)
      this.modal.mode = "EDIT";
      this.modal.title = "Modify";
      this.modal.isOpen = true;
      if (this.modal.data.gender !== "" && this.modal.data.category !== "") {
        this.genWeightList();
      }
    },
    deleteRecord(record){
      Modal.confirm({
                title: '是否確定',
                icon: createVNode(ExclamationCircleOutlined),
                content: '刪除報名記錄?'+record.name_zh +' / ' + record.name_fn,
                okText: '確定',
                cancelText: '取消',
                onOk: () => {
                  this.$inertia.delete(route('manage.competition.applications.destroy',
                    {
                      competition: this.competition.id,
                      application: record.id,
                    }),{
                    onSuccess: (page) => {
                      console.log(page);
                    },
                    onError: (error) => {
                      console.log(error);
                    },
                  })
                }
            })


    }, 
    genWeightList() {
      if (this.modal.data.gender == "M") {
        this.modal.data.weight_list = this.competition.categories_weights.find(
          (c) => c.code == this.modal.data.category
        )["male"];
      } else {
        this.modal.data.weight_list = this.competition.categories_weights.find(
          (c) => c.code == this.modal.data.category
        )["female"];
      }
    },
    updateRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.put(
            route("manage.competition.applications.update", {
              competition: this.competition.id,
              application: this.modal.data.id,
            }),
            this.modal.data,
            {
              onSuccess: (page) => {
                this.modal.data = {};
                this.modal.isOpen = false;
                console.log(page);
              },
              onError: (error) => {
                console.log(error);
              },
            }
          );
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    calculateAge(birthDate) {
        if (!birthDate) return;
        const currentDate = new Date();
        if (new Date(birthDate) > currentDate) {
            var birthDate = null
            var years = null;
            var months = null;
            var days = null;
            return 'false';
        }

        const diffTime = currentDate - new Date(birthDate);
        const totalDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        years = Math.floor(totalDays / 365.25);
        months = Math.floor((totalDays % 365.25) / 30.4375);
        days = Math.floor((totalDays % 365.25) % 30.4375);
        return years
    },
    disabledDate(current){
      return current>dayjs(new Date()).subtract(3,'year');
    },
    onCheckChange(selectedRowKeys, selectedRows){
    },
    onCheckSelect(record, selected, selectedRows){
      if(selected){
        this.selectedRowKeyIds.push(record.id)
      }else{
        console.log()
        this.selectedRowKeyIds=this.selectedRowKeyIds.filter(x=>x!=record.id)
        
      }
      //console.log(record, selected, selectedRows);
    },
    onCheckSelectAll(selected, selectedRows, changeRows) {
      selectedRows.forEach((r)=>{
        this.selectedRowKeyIds.push(r.id)
      })
      //console.log(selected, selectedRows, changeRows);
    },      
    printReceipt(){
      console.log(this.selectedRowKeyIds);
    }
    

  },
};
</script>
