<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("organization_members") }}
      </h2>
    </template>
    <!--
    <button
      @click="createRecord()"
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3"
    >
      Add members
    </button>
    -->
    <a-table :dataSource="members" :columns="columns">
      <template #headerCell="{ column }">
        {{ column.i18n ? $t(column.i18n) : column.title }}
      </template>
      <template #bodyCell="{ column, text, record, index }">
        <template v-if="column.dataIndex == 'operation'">
          <!--
          <a-button @click="editRecord(record)">Edit</a-button>
          <a-button @click="deleteRecord(record.id)">Delete</a-button>
          -->
        </template>
        <template v-else-if="column.dataIndex == 'login'">
          <span v-if="record.user">
            {{ record.user.email }}
          </span>
        </template>
        <template v-else>
          {{ record[column.dataIndex] }}
        </template>
      </template>
    </a-table>

    <!-- Modal Start-->
    <a-modal v-model:visible="modal.isOpen" :title="$t(modal.title)" width="60%">
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
        <a-input type="hidden" v-model:value="modal.data.id" />
        <a-form-item :label="$t('name_zh')" name="name_zh">
          <a-input v-model:value="modal.data.name_zh" />
        </a-form-item>
        <a-form-item :label="$t('name_fn')" name="name_fn">
          <a-input v-model:value="modal.data.name_fn" />
        </a-form-item>
        <a-form-item :label="$t('nickname')" name="nickname">
          <a-input v-model:value="modal.data.nickname" />
        </a-form-item>
        <a-form-item :label="$t('mobile')" name="mobile">
          <a-input v-model:value="modal.data.mobile" />
        </a-form-item>
        <a-form-item :label="$t('status')" name="status">
          <a-select v-model:value="modal.data.state" :options="employmentStates" />
        </a-form-item>
      </a-form>
      <template #footer>
        <a-button
          v-if="modal.mode == 'EDIT'"
          key="Update"
          type="primary"
          @click="updateRecord()"
          >{{ $t("update") }}</a-button
        >
        <a-button
          v-if="modal.mode == 'CREATE'"
          key="Store"
          type="primary"
          @click="storeRecord()"
          >{{ $t("add") }}</a-button
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
  props: ["members"],
  data() {
    return {
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
          i18n: "given_name",
          dataIndex: "given_name",
        },
        {
          title: "Family Name",
          i18n: "family_name",
          dataIndex: "family_name",
        },
        {
          title: "Gender",
          i18n: "gender",
          dataIndex: "gender",
        },
        {
          title: "Dob",
          i18n: "dob",
          dataIndex: "dob",
        },
        {
          title: "Login Username",
          i18n: "login_username",
          dataIndex: "login",
        },
        {
          title: "Operation",
          i18n: "operation",
          dataIndex: "operation",
          key: "operation",
        },
      ],
      rules: {
        name_zh: { required: true },
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
    };
  },
  created() {},
  methods: {
    createRecord() {
      this.modal.data = {};
      this.modal.mode = "CREATE";
      this.modal.title = "create";
      this.modal.isOpen = true;
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.mode = "EDIT";
      this.modal.title = "edit";
      this.modal.isOpen = true;
    },
    storeRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.post("/admin/teachers/", this.modal.data, {
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
          this.$inertia.patch("/admin/teachers/" + this.modal.data.id, this.modal.data, {
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
    deleteRecord(recordId) {
      console.log(recordId);
      if (!confirm("Are you sure want to remove?")) return;
      this.$inertia.delete("/admin/teachers/" + recordId, {
        onSuccess: (page) => {
          console.log(page);
        },
        onError: (error) => {
          console.log(error);
        },
      });
    },
  },
};
</script>
