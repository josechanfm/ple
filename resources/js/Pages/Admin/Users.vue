<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t("users") }}</h2>
    </template>
    <button
      @click="createRecord()"
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3"
    >
      {{ $t("create_user") }}
    </button>
    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <a-table :dataSource="users" :columns="columns">
          <template #headerCell="{ column }">
            {{ column.i18n ? $t(column.i18n) : column.title }}
          </template>
          <template #bodyCell="{ column, text, record, index }">
            <template v-if="column.dataIndex == 'operation'">
              <a-button @click="editRecord(record)">{{ $t("edit") }}</a-button>
              <a-popconfirm
                :title="$t('confirm_delete_record')"
                ok-text="Yes"
                cancel-text="No"
                @confirm="deleteRecord(record)"
              >
                <a-button>{{ $t("delete") }}</a-button>
              </a-popconfirm>
            </template>
            <template v-else-if="column.dataIndex == 'organizations'">
              <ol class="list-decimal">
                <li v-for="organization in record['organizations']">
                  {{ organization.abbr }}
                </li>
              </ol>
            </template>
            <template v-else>
              {{ record[column.dataIndex] }}
            </template>
          </template>
        </a-table>
      </div>
    </div>
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
        <a-form-item :label="$t('username')" name="name">
          <a-input v-model:value="modal.data.name" />
        </a-form-item>
        <a-form-item :label="$t('email')" name="email">
          <a-input v-model:value="modal.data.email" />
        </a-form-item>
        <a-form-item
          :label="$t('password')"
          name="password"
          v-if="modal.mode == 'CREATE'"
        >
          <a-input v-model:value="modal.data.password" />
        </a-form-item>
        <a-form-item :label="$t('organization_manager')" name="organization_ids">
          <a-select
            v-model:value="modal.data.organization_ids"
            mode="multiple"
            show-search
            :filter-option="filterOption"
            :options="organizations"
            :fieldNames="{ value: 'id', label: 'full_name' }"
          />
        </a-form-item>
        <a-form-item :label="$t('roles')" name="roles">
          <a-checkbox-group v-model:value="modal.data.role_ids">
            <template v-for="role in roles">
              <a-checkbox :value="role.id" :style="verticalStyle">{{
                role.name
              }}</a-checkbox>
            </template>
          </a-checkbox-group>
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
  props: ["organizations", "users", "roles"],
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
          title: "Username",
          i18n: "username",
          dataIndex: "name",
        },
        {
          title: "Email",
          i18n: "email",
          dataIndex: "email",
        },
        {
          title: "Organizations",
          i18n: "organizations",
          dataIndex: "organizations",
        },
        {
          title: "State",
          i18n: "state",
          dataIndex: "state",
        },
        {
          title: "Operation",
          i18n: "operation",
          dataIndex: "operation",
          key: "operation",
        },
      ],
      rules: {
        name: { required: true },
        email: { required: true, type: "email" },
        password: { required: true },
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
      verticalStyle: {
        display: "flex",
        height: "30px",
        lineHeight: "30px",
        width: "100%",
        marginLeft: "20px",
      },
    };
  },
  created() {},
  methods: {
    filterOption(input, option) {
      return option.full_name.toLowerCase().indexOf(input.toLowerCase()) >= 0;
    },
    createRecord() {
      this.modal.data = {};
      this.modal.mode = "CREATE";
      this.modal.title = "create";
      this.modal.isOpen = true;
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.data.organization_ids = record.organizations.map((item) => item.id);
      this.modal.data.role_ids = record.roles.map((item) => item.id);
      this.modal.mode = "EDIT";
      this.modal.title = "edit";
      this.modal.isOpen = true;
    },
    storeRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.post(route("admin.users.store"), this.modal.data, {
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
      this.$inertia.patch(
        route("admin.users.update", this.modal.data.id),
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
    },
    deleteRecord(record) {
      this.$inertia.delete(route("admin.users.destroy"), record.id, {
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
