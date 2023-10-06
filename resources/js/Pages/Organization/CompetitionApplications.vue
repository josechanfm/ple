<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("applications") }}
      </h2>
    </template>
    <a-table :dataSource="competition.applications" :columns="columns">
      <template #headerCell="{ column }">
        {{ column.i18n ? $t(column.i18n) : column.title }}
      </template>
      <template #bodyCell="{ column, text, record, index }">
        <template v-if="column.dataIndex == 'operation'">
          <a-button @click="editRecord(record)">{{ $t("edit") }}</a-button>
        </template>
        <template v-else-if="column.dataIndex == 'full_name'">
          {{ record.given_name }} {{ record.middle_name }} {{ record.family_name }}
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
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
      >
        <!-- <a-form-item label="Certificate name" name="name">
                <a-input v-model:value="modal.data.name" />
            </a-form-item> -->
        <a-form-item :label="$t('given_name')" name="given_name">
          <a-input v-model:value="modal.data.given_name" />
        </a-form-item>
        <a-form-item :label="$t('middle_name')" name="middle_name">
          <a-input v-model:value="modal.data.middle_name" />
        </a-form-item>
        <a-form-item :label="$t('family_name')" name="family_name">
          <a-input v-model:value="modal.data.family_name" />
        </a-form-item>
        <a-form-item
          :label="$t('display_name')"
          name="display_name"
          :rules="[{ required: true }]"
        >
          <a-input v-model:value="modal.data.display_name" />
        </a-form-item>
        <a-form-item :label="$t('gender')" name="gender" :rules="[{ required: true }]">
          <a-radio-group
            v-model:value="modal.data.gender"
            button-style="solid"
            @change="onChangeGender"
          >
            <a-radio-button value="M">{{$t('male')}}</a-radio-button>
            <a-radio-button value="F">{{$t('female')}}</a-radio-button>
          </a-radio-group>
        </a-form-item>
        <a-form-item :label="$t('dob')" name="dob" :rules="[{ required: true }]">
          <a-date-picker
            v-model:value="modal.data.dob"
            :format="dateFormat"
            :valueFormat="dateFormat"
          />
        </a-form-item>
        <a-form-item :label="$t('role')" name="role" :rules="[{ required: true }]">
          <a-select v-model:value="modal.data.role" :options="competition.roles" />
        </a-form-item>
        <template v-if="modal.data.role == 'athlete'">
          <a-form-item
            :label="$t('category')"
            name="category"
            :rules="[{ required: true }]"
          >
            <a-select
              v-model:value="modal.data.category"
              :options="competition.categories_weights"
              :fieldNames="{ value: 'code', label: 'name' }"
              @change="onChangeCategory"
            />
          </a-form-item>
          <a-form-item :label="$t('weight')" name="weight" :rules="[{ required: true }]">
            <a-select
              v-model:value="modal.data.weight"
              :options="modal.data.weight_list"
              :fieldNames="{ value: 'code', label: 'name' }"
            />
          </a-form-item>
        </template>
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

export default {
  components: {
    OrganizationLayout,
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
          title: "Full Name",
          i18n:"full_name",
          dataIndex: "full_name",
        },
        {
          title: "Gender",
          i18n:"gender",
          dataIndex: "gender",
        },
        {
          title: "Date of Birth",
          i18n:"dob",
          dataIndex: "dob",
        },
        {
          title: "Role",
          i18n:"role",
          dataIndex: "role",
        },
        {
          title: "Category",
          i18n:"category",
          dataIndex: "category",
        },
        {
          title: "Weight",
          i18n:"weight",
          dataIndex: "weight",
        },
        {
          title: "Operation",
          i18n:"operation",
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
    onChangeGender(gender) {
      this.modal.data.category = null;
      this.modal.data.weight = null;
    },
    onChangeCategory(category) {
      this.modal.data.weight = null;
      this.genWeightList();
      console.log(this.modal.data.weight_list);
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.mode = "EDIT";
      this.modal.title = "Modify";
      this.modal.isOpen = true;
      if (this.modal.data.gender !== "" && this.modal.data.category !== "") {
        this.genWeightList();
      }
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
      console.log(this.modal.data);
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
  },
};
</script>
