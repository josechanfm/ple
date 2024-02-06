<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("course") }}
      </h2>
    </template>

    <div>
      <div class="flex-auto pb-3 text-left">
        <a-button @click="goBack" type="dashed">Go Back</a-button>
      </div>
      <div class="flex-auto pb-3 text-right">
        <a-button @click="" type="primary">Edit</a-button>
        <inertia-link :href="route('manage.course.contents.index', course.id)" class="ant-btn">{{
          $t("View Contents") }}</inertia-link>
      </div>
    </div>

    <CourseBuilder :course="course">
      <div class="flex-auto pb-3 text-left">
        <a-button @click="createModuleRecord" type="primary">Create Module</a-button>
      </div>
      <a-collapse>
        <template v-for="module in course.modules">
          <a-collapse-panel :header=module.label>
              <a-button  @click="moduleUpdateRecord(module)">Edit</a-button>
              <a-button @click="moduleDeleteRecord(module)" type="danger">Delete</a-button>
            
            <ul class="module-list">
              <span v-for="content in course.contents">
                <li v-if="content.module == module.value" class="module-list-item">
                  {{ content.title }}
                  <a-button @click="contentEditRecord(content)">edit</a-button>
                </li>
              </span>
            </ul>
          </a-collapse-panel>
        </template>
      </a-collapse>
      <a-collapse>
        <a-collapse-panel header="Individual">
          <ul class="module-list">
            <template v-for="content in individualContents">
              <li class="module-list-item">{{ content.title }}</li>
            </template>
          </ul>
        </a-collapse-panel>
      </a-collapse>
    </CourseBuilder>

    <!-- Modal Start for Create Module -->
    <a-modal
      v-model:visible="moduleCreateModal.isOpen"
      :title="$t(moduleCreateModal.title)"
      width="60%"
      :afterClose="moduleCreateModalClose"
      @ok="onRecordSave"
      ok-text="Save"
    >
      <a-form
        ref="modalRef"
        :model="moduleCreateModal.data"
        name="Certificate"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
        enctype="multipart/form-data"
      >
        <a-form-item label="Module Name" name="label">
          <a-input v-model:value="moduleCreateModal.data.label" />
        </a-form-item>
      </a-form>
    </a-modal>
    <!-- Modal End -->

    <!-- Modal Start for Edit Module -->
    <a-modal
      v-model:visible="moduleEditModal.isOpen"
      :title="$t(moduleEditModal.title)"
      width="60%"
      :afterClose="moduleEditModalClose"
      @ok="onRecordUpdate"
      ok-text="Update"
    >
      <a-form
        ref="modalRef"
        :model="moduleEditModal.data"
        name="Certificate"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
        enctype="multipart/form-data"
      >
        <a-form-item label="Module Name" name="label">
          <a-input v-model:value="moduleEditModal.data.label" />
        </a-form-item>
      </a-form>
    </a-modal>
    <!-- Modal End -->

    <!-- Modal Start for Delete Module -->
    <a-modal
      v-model:visible="moduleDeleteModal.isOpen"
      :title="$t(moduleDeleteModal.title)"
      width="60%"
      :afterClose="moduleDeleteModalClose"
      @ok="onRecordDelete"
      ok-text="Confirm"
    >
      <a-form
        ref="modalRef"
        :model="moduleDeleteModal.data"
        name="Certificate"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
        enctype="multipart/form-data"
      >
        <p>Are you sure you want to delete this module?</p>
      </a-form>
    </a-modal>
    <!-- Modal End -->
  </OrganizationLayout>
</template>
  
<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import CourseBuilder from "@/Components/Organization/CourseBuilder.vue";
import {
  UploadOutlined,
  LoadingOutlined,
  PlusOutlined,
  InfoCircleFilled,
} from "@ant-design/icons-vue";
import { defineComponent, reactive } from "vue";
import CropperModal from "@/Components/Member/CropperModal.vue";

export default {
  components: {
    OrganizationLayout,
    UploadOutlined,
    LoadingOutlined,
    PlusOutlined,
    InfoCircleFilled,
    CropperModal,
    CourseBuilder
  },
  props: ["course", 'content_types'],
  data() {
    return {
      open: false,
      individualContents: [],
      moduleCreateModal: {
        isOpen: false,
        data: {},
        title: "Create Module",
        mode: "",
      },
      moduleEditModal: {
        isOpen: false,
        data: {},
        title: "Edit Module",
        mode: "",
      },
      moduleDeleteModal: {
        isOpen: false,
        data: {},
        title: "Delete Module",
        mode: "",
      },
      rules: {
        category_code: { required: true },
        cert_title: { required: true },

        label: { required: true },
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
  created() { },
  mounted() {
    const modules = this.course.modules.map(m => m.value)
    console.log(modules)
    this.individualContents = this.course.contents.filter(c => !modules.includes(c.module))
    console.log(this.individualContents);
  },
  methods: {
    goBack() {
      window.history.back();
    },
    createModuleRecord() {
      this.moduleCreateModal.data = {};
      this.moduleCreateModal.mode = "CREATE";
      this.moduleCreateModal.isOpen = true;
      this.moduleEditModal.isOpen = false;
      this.moduleDeleteModal.isOpen = false;
    },
    moduleCreateModalClose() {
      console.log('Close create module modal.');
    },
    onRecordSave(e) {
      console.log(e);
      console.log(this.moduleCreateModal.data)
      this.$refs.modalRef.validateFields().then(() => {
        this.$inertia.post(route('manage.course.createModule', this.course.id), this.moduleCreateModal.data, {
          onSuccess: (page) => {
            console.log(page);
            this.moduleCreateModal.isOpen = false;
          },
          onError: (err) => {
            console.log(err);
          }
        });
      })
    },
    moduleUpdateRecord(module) {
      this.moduleEditModal.data = { value: module.value, label : module.label };
      this.moduleEditModal.mode = "UPDATE";
      this.moduleEditModal.isOpen = true;
      this.moduleCreateModal.isOpen = false;
      this.moduleDeleteModal.isOpen = false;
    },
    moduleEditModalClose() {
      console.log('Close edit module modal.');
    },
    onRecordUpdate(e) {
      console.log(e);
      console.log(this.moduleEditModal.data)
      this.$refs.modalRef.validateFields().then(() => {
        this.$inertia.patch(route('manage.course.updateModule', this.course.id), this.moduleEditModal.data, {
          onSuccess: (page) => {
            console.log(page);
            this.moduleEditModal.isOpen = false;
          },
          onError: (err) => {
            console.log(err);
          }
        });
      })
    },
    moduleDeleteRecord(module) {
      this.moduleDeleteModal.data = { value: module.value, label: module.label };
      this.moduleDeleteModal.mode = "DELETE";
      this.moduleDeleteModal.isOpen = true;
      this.moduleCreateModal.isOpen = false;
      this.moduleEditModal.isOpen = false;
    },
    moduleDeleteModalClose() {
      console.log('Close delete module modal.');
    },
    onRecordDelete(e) {
      console.log(e);
      console.log(this.moduleDeleteModal.data)      
      this.$inertia.delete(route('manage.course.destroyModule', this.course.id), this.moduleDeleteModal.data, {
        onSuccess: (page) => {
          console.log(page);
          this.moduleDeleteModal.isOpen = false;
        },
        onError: (err) => {
          console.log(err);
        }
      });
    },
    contentEditRecord(content) {
      this.$inertia.get(route('manage.course.contents.edit', { course: content.course_id, content: content.id }))
    }
  }
};
</script>

<style>
.ant-collapse-content>.ant-collapse-content-box {
  padding: 0 !important
}

.module-list-item {
  padding-left: 10px;
  border-bottom: 1px solid lightgray;
}

.module-list {
  line-height: 30px;
}
</style>