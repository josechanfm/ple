<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("courses") }}
      </h2>
    </template>
    <div class="flex-auto pb-3 text-right">
      <a-button @click="createRecord" type="primary">Create Course</a-button>
    </div>
    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <a-table :dataSource="courses" :columns="columns">
          <template #headerCell="{ column }">
            {{ column.i18n ? $t(column.i18n) : column.title }}
          </template>
          <template #bodyCell="{ column, text, record, index }">
            <template v-if="column.dataIndex == 'operation'">
              <inertia-link
                :href="route('manage.courses.edit', record.id)"
                class="ant-btn">{{ $t("edit") }}</inertia-link
              >
              <inertia-link
                :href="route('manage.course.contents.index', record.id)"
                class="ant-btn">{{ $t("course_contents") }}</inertia-link
              >
            </template>
            <template v-else-if="column.dataIndex == 'teachers'">
              <span v-for="teacher in record.teachers">{{ teacher.name }}, </span>
            </template>
            <template v-else>
              {{ record[column.dataIndex] }}
            </template>
          </template>
        </a-table>
      </div>
    </div>

    <!-- Modal Start-->
    <a-modal
      v-model:visible="modal.isOpen"
      :title="$t(modal.title)"
      width="60%"
      :afterClose="modalClose"
      @ok="onRecordSave"
      ok-text="Save"
    >
      <a-form
        ref="modalFormRef"
        :model="modal.data"
        name="Certificate"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
        enctype="multipart/form-data"
      >
        <a-form-item label="Title" name="title">
          <a-input v-model:value="modal.data.title" />
        </a-form-item>
        <a-form-item label="Learn" name="learn">
          <a-textarea v-model:value="modal.data.learn" />
        </a-form-item>
        <a-form-item label="Brief" name="brief">
          <a-textarea v-model:value="modal.data.brief" />
        </a-form-item>
        <a-form-item label="Description" name="description">
          <a-textarea v-model:value="modal.data.description" />
        </a-form-item>
        <a-form-item label="Image" name="image">
          <a-input v-model:value="modal.data.image" />
        </a-form-item>
        <a-form-item label="Start on" name="start_on">
          <a-date-picker v-model:value="modal.data.start_on" :valueFormat="dateFormat" />
        </a-form-item>
        <a-form-item label="Finish on" name="finish_on">
          <a-date-picker v-model:value="modal.data.finish_on" :valueFormat="dateFormat"/>
        </a-form-item>
        <a-form-item label="Published" name="published">
          <a-switch v-model:checked="modal.data.published" />
        </a-form-item>
      </a-form>
    </a-modal>
  </OrganizationLayout>
</template>
  
<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import {
  UploadOutlined,
  LoadingOutlined,
  PlusOutlined,
  InfoCircleFilled,
} from "@ant-design/icons-vue";
import CropperModal from "@/Components/Member/CropperModal.vue";
  
export default {
  components: {
    OrganizationLayout,
    UploadOutlined,
    LoadingOutlined,
    PlusOutlined,
    InfoCircleFilled,
    CropperModal,
  },
  props: ["courses"],
  data() {
    return {
      dateFormat:'YYYY-MM-DD',
      modal: {
        isOpen: false,
        data: {},
        title: "Modal",
        mode: "",
      },
      columns: [
        {
          title: "Title",
          i18n: "course_title",
          dataIndex: "title",
        },{
          title: "Teachers",
          i18n: "course_teachers",
          dataIndex: "teachers",
        },{
          title: "Operation",
          i18n: "operation",
          dataIndex: "operation",
        }
      ],
      rules: {
        title: { required: true },
        start_on: { required:true },
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
    createRecord(){
      this.modal.data = {};
      this.modal.mode = "CREATE";
      this.modal.isOpen = true;
    },
    modalClose(){
      console.log('Close modal');
    },
    onRecordSave(e){
      console.log(e);
      console.log(this.modal.data)
      this.$refs.modalFormRef.validateFields().then(()=>{
        this.$inertia.post(route('manage.courses.store'), this.modal.data, {
          onSuccess: (page) => {
            console.log(page);
            this.modal.isOpen = false;
          },
          onError: (err) => {
            console.log(err);
          }
        });
      })
    }
  }
};
</script>
  