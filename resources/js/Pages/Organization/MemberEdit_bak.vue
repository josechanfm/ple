<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("edit_member_profile") }}
      </h2>
    </template>
    <a-form
      :model="member"
      v-bind="layout"
      name="nest-messages"
      :validate-messages="validateMessages"
    >
      <a-form-item name="first_name" :label="$t('first_name')">
        <a-input v-model:value="member.first_name" />
      </a-form-item>
      <a-form-item name="last_name" :label="$t('last_name')">
        <a-input v-model:value="member.last_name" />
      </a-form-item>
      <a-form-item name="display_name" :label="$t('display_name')">
        <a-input v-model:value="member.display_name" />
      </a-form-item>
      <a-form-item name="email" :label="$t('email')">
        <a-input v-model:value="member.email" />
      </a-form-item>
      <a-form-item name="gender" :label="$t('gender')">
        <a-input v-model:value="member.gender" />
      </a-form-item>
      <a-form-item name="dob" :label="$t('dob')">
        <a-input v-model:value="member.dob" />
      </a-form-item>
      <a-form-item name="phone" :label="$t('phone')">
        <a-input v-model:value="member.phone" />
      </a-form-item>
      <a-form-item name="address" :label="$t('address')">
        <a-input v-model:value="member.address" />
      </a-form-item>
      <a-form-item name="country" :label="$t('country')">
        <a-input v-model:value="member.country" />
      </a-form-item>
      <a-form-item name="nationality" :label="$t('nationality')">
        <a-input v-model:value="member.nationality" />
      </a-form-item>
      <div class="flex flex-row item-center justify-center">
        <a-button type="primary" html-type="submit">{{ $t("submit") }}</a-button>
      </div>
    </a-form>
  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { defineComponent, reactive } from "vue";

export default {
  components: {
    OrganizationLayout,
  },
  props: ["member"],
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
          title: "姓名(中文)",
          dataIndex: "first_name",
        },
        {
          title: "姓名(外文)",
          dataIndex: "last_name",
        },
        {
          title: "別名",
          dataIndex: "gender",
        },
        {
          title: "手機",
          dataIndex: "dob",
        },
        {
          title: "狀態",
          dataIndex: "state",
        },
        {
          title: "操作",
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
      layout: {
        labelCol: {
          span: 8,
        },
        wrapperCol: {
          span: 16,
        },
      },
    };
  },
  created() {},
  methods: {
    createRecord() {
      this.modal.data = {};
      this.modal.mode = "CREATE";
      this.modal.title = "新增問卷";
      this.modal.isOpen = true;
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.mode = "EDIT";
      this.modal.title = "修改";
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
    createLogin(recordId) {
      console.log("create login" + recordId);
    },
  },
};
</script>
