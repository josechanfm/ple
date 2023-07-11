<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Member Profile
      </h2>
    </template>
    <a-form
      :model="competition"
      v-bind="layout"
      name="nest-messages"
      :validate-messages="validateMessages"
      layout="vertical"
    >
      <a-form-item label="Full name (en)" name="title_en">
        <a-input v-model:value="competition.title_en" />
      </a-form-item>
      <a-form-item label="Full name (fn)" name="title_fn">
        <a-input v-model:value="competition.title_fn" />
      </a-form-item>
      <a-form-item label="Start date" name="start_date">
        <a-date-picker
          v-model:value="competition.start"
          :format="dateFormat"
          :valueFormat="dateFormat"
        />
      </a-form-item>
      <a-form-item label="End date" name="end_date">
        <a-date-picker
          v-model:value="competition.end"
          :format="dateFormat"
          :valueFormat="dateFormat"
        />
      </a-form-item>
      <a-form-item label="Match dates" name="match_date">
        <a-input v-model:value="competition.match_date" />
      </a-form-item>
      <a-form-item label="Category/Weight" name="category_weight">
        <a-input v-model:value="competition.category_weight" />
      </a-form-item>
      <a-checkbox-group v-model:value="competition.roles" class="w-full">
        <a-row :span="24">
            <template v-for="cw in categories_weights">
            <a-col :span="6" >
              <a-checkbox :value="cw.name">{{ cw.name }}</a-checkbox>
              <ol>
                <li v-for="male in cw.male">
                  {{ male.name }} : {{ male.limit[0] }} - {{ male.limit[1] }}
                </li>
              </ol>
            </a-col>

            </template>
        </a-row>
      </a-checkbox-group>

      <a-form-item label="Roles" name="roles">
        <a-checkbox-group v-model:value="competition.roles">
          <a-checkbox
            v-for="role in roles"
            :style="radioVirticalStyle"
            :value="role.value"
            >{{ role.label }}</a-checkbox
          >
        </a-checkbox-group>
      </a-form-item>
      <a-form-item :wrapper-col="{ ...layout.wrapperCol, offset: 8 }">
        <a-button type="primary" html-type="submit">Submit</a-button>
      </a-form-item>
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
  props: ["competition", "categories_weights", "roles"],
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
      radioVirticalStyle: {
        display: "flex",
        height: "30px",
        lineHeight: "30px",
        marginLeft: "8px",
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
          this.$inertia.patch(
            "/admin/teachers/" + this.modal.data.id,
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

