<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Members</h2>
    </template>
    <button
      @click="createRecord()"
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3"
    >
      Create Member
    </button>
     <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <a-table :dataSource="members" :columns="columns">
          <template #bodyCell="{ column, text, record, index }">
            <template v-if="column.dataIndex == 'operation'">
              <a-button @click="editRecord(record)">Edit</a-button>
              <a-popconfirm
                    title="Are you sure to delete the record?"
                    ok-text="Yes"
                    cancel-text="No"
                    @confirm="deleteRecord(record)"
                    >
                    <a-button>Delete</a-button>
                </a-popconfirm>
              <a-button @click="createLogin(record)">Create login</a-button>
            </template>
            <template v-else-if="column.dataIndex == 'login'">
              <span v-if="record['user']">
                {{ record['user'].email }}
              </span>
            </template>
            <template v-else>
              {{ record[column.dataIndex] }}
            </template>
          </template>
        </a-table>
      </div>
    </div>
    <!-- Modal Start-->
    <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
      <a-form
        ref="modalRef"
        :model="modal.data"
        name="Teacher"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
      >
        <a-form-item label="Given Name" name="given_name">
          <a-input v-model:value="modal.data.given_name" />
        </a-form-item>
        <a-form-item label="Middle Name" name="middle_name">
          <a-input v-model:value="modal.data.middle_name" />
        </a-form-item>
        <a-form-item label="Family Name" name="family_name">
          <a-input v-model:value="modal.data.family_name" />
        </a-form-item>
        <a-form-item label="Email" name="email">
          <a-input v-model:value="modal.data.email" />
        </a-form-item>
        <a-form-item label="Gender" name="gender">
          <a-switch v-model:checked="modal.data.gender" :checkedValue="1" :unCheckedValue="0"/>
        </a-form-item>
        <a-form-item label="Date of Birth" name="dob">
          <a-date-picker v-model:value="modal.data.dob" :format="dateFormat" :valueFormat="dateFormat"/>
        </a-form-item>
        <a-form-item label="Organizations" name="organization_ids">
          <a-select v-model:value="modal.data.organization_ids"
                  mode="multiple"
                  show-search
                  :filter-option="filterOption"
                  :options="organizations"
                  :fieldNames="{value:'id',label:'full_name'}"
              />
        </a-form-item>
      </a-form>
      <template #footer>
        <a-button
          v-if="modal.mode == 'EDIT'"
          key="Update"
          type="primary"
          @click="updateRecord()"
          >Update</a-button
        >
        <a-button
          v-if="modal.mode == 'CREATE'"
          key="Store"
          type="primary"
          @click="storeRecord()"
          >Add</a-button
        >
      </template>
    </a-modal>
    <!-- Modal End-->
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { defineComponent, reactive } from "vue";

export default {
  components: {
    AdminLayout,
  },
  props: ["organizations","members"],
  data() {
    return {
      dateFormat:'YYYY-MM-DD',
      modal: {
        isOpen: false,
        data: {},
        title: "Modal",
        mode: "",
      },
      teacherStateLabels: {},
      columns: [
        {
          title: "Given Name",
          dataIndex: "given_name",
        },{
          title: "Family Name",
          dataIndex: "family_name",
        },{
          title: "Display Name",
          dataIndex: "display_name",
        },{
          title: "Login email",
          dataIndex: "login",
        },{
          title: "Operations",
          dataIndex: "operation",
          key: "operation",
        },
      ],
      rules: {
        name_zh: { required: true },
        mobile: { required: true },
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
    };
  },
  created() {},
  methods: {
    filterOption(input, option) {
      return option.full_name.toLowerCase().indexOf(input.toLowerCase())>=0
    },
    createRecord() {
      this.modal.data = {}
      this.modal.data.organization_ids=[]
      this.modal.mode = "CREATE"
      this.modal.title = "新增問卷"
      this.modal.isOpen = true
    },
    editRecord(record) {
      this.modal.data = { ...record }
      this.modal.data.organization_ids=record.organizations.map(item=>(item.id))
      this.modal.mode = "EDIT"
      this.modal.title = "修改"
      this.modal.isOpen = true
    },
    storeRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.post(route('admin.members.store'), this.modal.data, {
            onSuccess: (page) => {
              this.modal.data = {};
              this.modal.isOpen = false;
            },
            onError: (err) => {
              console.log(err);
            },
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    updateRecord() {
      console.log(this.modal.data);
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.patch(route('admin.members.update', this.modal.data.id), this.modal.data, {
            onSuccess: (page) => {
              this.modal.data = {};
              this.modal.isOpen = false;
              console.log(page);
            },
            onError: (error) => {
              console.log(error);
            },
          });
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    deleteRecord(record) {
      this.$inertia.delete(route('admin.members.destroy',record.id), {
        onSuccess: (page) => {
          console.log(page);
        },
        onError: (error) => {
          console.log(error);
        },
      });
    },
    createLogin(record) {
      console.log("create login" + record.id);
    },
  },
};
</script>
