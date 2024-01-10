<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("course") }}
      </h2>
    </template>

    <div v-if="course.id">
      On Edit
    </div>
    <div v-else>
      On Create
    </div>

    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <a-form ref="modalRef" :model="course" name="Course" :label-col="{ span: 8 }" :wrapper-col="{ span: 16 }"
          autocomplete="off" :rules="rules" :validate-messages="validateMessages" enctype="multipart/form-data"
          @finish="onFinish">
          <a-form-item :label="$t('course_title')" name="title">
            <a-input v-model:value="course.title" />
          </a-form-item>
          <a-form-item :label="$t('learn')" name="learn">
            <a-textarea v-model:value="course.learn" />
          </a-form-item>
          <a-form-item :label="$t('brief')" name="brief">
            <a-textarea v-model:value="course.brief" />
          </a-form-item>
          <a-form-item :label="$t('description')" name="description">
            <a-textarea v-model:value="course.description" />
          </a-form-item>
          <a-form-item :label="$t('image')" name="image">
            <a-input v-model:value="course.image" />
          </a-form-item>
          <a-form-item :label="$t('start_on')" name="start_on">
            <a-date-picker v-model:value="course.start_on" />
          </a-form-item>
          <a-form-item :label="$t('finish_on')" name="finish_on">
            <a-date-picker v-model:value="course.finish_on" />
          </a-form-item>
          <a-form-item :label="$t('finish_on')" name="finish_on">
            <a-switch v-model:checked="course.published" />
          </a-form-item>
          <a-form-item :label="$t('user_id')" name="user_id">
            <a-input v-model:value="course.user_id" />
          </a-form-item>
          <div class="flex flex-row item-center justify-center">
            <a-button type="primary" html-type="submit">{{ $t('submit') }}</a-button>
          </div>
        </a-form>

      </div>
    </div>

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
  },
  props: ["course"],
  data() {
    return {
      rules: {
        category_code: { required: true },
        cert_title: { required: true },
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
  methods: {
    onFinish() {
      if (this.course.id === undefined) {
        this.$inertia.post(route('manage.courses.store'), this.course, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (err) => {
            console.log(err);
          }
        });
      } else {
        this.$inertia.patch(route('manage.courses.update', this.course.id), this.course, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (err) => {
            console.log(err);
          }
        });

      }

    },

  },
};
</script>
  