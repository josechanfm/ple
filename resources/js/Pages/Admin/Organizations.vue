<template>
  <AdminLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("organizations") }}
      </h2>
    </template>
    <button
      @click="createRecord()"
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3"
    >
      {{ $t("create_organization") }}
    </button>
    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <a-table :dataSource="organizations" :columns="columns">
          <template #headerCell="{ column }">
            {{ column.i18n ? $t(column.i18n) : column.title }}
          </template>
          <template #bodyCell="{ column, text, record, index }">
            <template v-if="column.dataIndex == 'operation'">
              <inertia-link
                :href="route('admin.organization.members', record.id)"
                class="ant-btn"
                >{{ $t("members") }}</inertia-link
              >
              <a-button @click="editRecord(record)">{{ $t("edit") }}</a-button>
              <a-popconfirm
                :title="$t('confirm_delete_record')"
                :ok-text="$t('yes')"
                :cancel-text="$t('no')"
                @confirm="deleteRecord(record)"
              >
                <a-button>{{ $t("delete") }}</a-button>
              </a-popconfirm>
            </template>
            <template v-else-if="column.dataIndex == 'region'">
              {{ zones.find((z) => z.value == record[column.dataIndex]).label }}
            </template>
            <template v-else-if="column.dataIndex == 'manager'">
              <ol class="list-decimal">
                <li v-for="user in record['users']">
                  {{ user.name }}
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
    <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
      <a-form
        ref="modalRef"
        :model="modal.data"
        name="Organization"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
      >
        <a-input type="hidden" v-model:value="modal.data.id" />
        <a-form-item :label="$t('region')" name="region" :rules="[{ required: true }]">
          <a-select v-model:value="modal.data.region" :options="zones" />
        </a-form-item>
        <a-form-item
          :label="$t('abbreviation')"
          name="abbr"
          :rules="[{ required: true }]"
        >
          <a-input v-model:value="modal.data.abbr" />
        </a-form-item>
        <a-form-item
          :label="$t('territory')"
          name="territory"
          :rules="[{ required: true }]"
        >
          <a-input v-model:value="modal.data.territory" />
        </a-form-item>
        <a-form-item :label="$t('country')" name="country">
          <a-input v-model:value="modal.data.country" />
        </a-form-item>
        <a-form-item
          :label="$t('full_name')"
          name="full_name"
          :rules="[{ required: true }]"
        >
          <a-input v-model:value="modal.data.full_name" />
        </a-form-item>
        <a-form-item :label="$t('email')" name="email">
          <a-input v-model:value="modal.data.email" />
        </a-form-item>
        <a-form-item :label="$t('phone')" name="phone">
          <a-input v-model:value="modal.data.phone" />
        </a-form-item>
        <a-form-item :label="$t('address')" name="address">
          <a-input v-model:value="modal.data.address" />
        </a-form-item>
        <a-form-item :label="$t('website')" name="href">
          <a-input v-model:value="modal.data.href" />
        </a-form-item>
        <a-form-item :label="$t('registration_code')" name="registration_code">
          <a-input v-model:value="modal.data.registration_code" />
        </a-form-item>
        <a-form-item :label="$t('title')" name="title">
          <a-input v-model:value="modal.data.title" />
        </a-form-item>
        <a-form-item :label="$t('avatar')" name="avatar">
          <a-input v-model:value="modal.data.avatar" />
        </a-form-item>
        <a-form-item :label="$t('content')" name="content">
          <a-input v-model:value="modal.data.content" />
        </a-form-item>
        <a-form-item :label="$t('president')" name="president">
          <a-input v-model:value="modal.data.president" />
        </a-form-item>
        <a-form-item :label="$t('status')" name="status" :rules="[{ required: true }]">
          <a-switch
            v-model:checked="modal.data.status"
            :checkedValue="1"
            :unCheckedValue="0"
          />
        </a-form-item>
        <a-form-item :label="$t('manager')" name="manager">
          <a-select
            v-model:value="modal.data.user_ids"
            mode="multiple"
            :options="users"
            :fieldNames="{ value: 'id', label: 'name' }"
          />
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
  props: ["organizations", "users"],
  data() {
    return {
      modal: {
        isOpen: false,
        data: {},
        title: "Modal",
        mode: "",
      },
      zones: [
        { value: "C", label: "Central Zone" },
        { value: "SE", label: "South East Zone" },
        { value: "E", label: "East Zone" },
        { value: "W", label: "West Zone" },
        { value: "S", label: "South Zone" },
      ],
      organizationStates: [
        { value: "ACTIVE", label: "Active" },
        { value: "SUSPENDED", label: "Suspended" },
      ],
      columns: [
        {
          title: "Region",
          i18n: "region",
          dataIndex: "region",
        },
        {
          title: "Territory",
          i18n: "territory",
          dataIndex: "territory",
        },
        {
          title: "Abbreviation",
          i18n: "abbreviation",
          dataIndex: "abbr",
        },
        {
          title: "Full name",
          i18n: "full_name",
          dataIndex: "full_name",
        },
        {
          title: "Email",
          i18n: "email",
          dataIndex: "email",
        },
        {
          title: "Manager",
          i18n: "manager",
          dataIndex: "manager",
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
      this.modal.title = "Create Record";
      this.modal.isOpen = true;
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.data.user_ids = record.users.map((item) => item.id);
      this.modal.mode = "EDIT";
      this.modal.title = "Edit Record";
      this.modal.isOpen = true;
    },
    storeRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.post(route("admin.organizations.store"), this.modal.data, {
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
          this.$inertia.patch(
            route("admin.organizations.update", this.modal.data.id),
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
    deleteRecord(record) {
      this.$inertia.delete(route("admin.organizations.destroy", record.id), {
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
