<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("courses") }}
      </h2>
    </template>

    <div>
      <div class="flex-auto pb-3 text-left">
        <a-button @click="goBack" type="dashed">Go Back</a-button>
      </div>
      <div class="flex-auto pb-3 text-right">
        <inertia-link :href="route('manage.courses.edit', course.id)" class="ant-btn">{{
          $t("View Contents") }}</inertia-link>
        <a-button :href="route('manage.course.contents.create', course.id)" type="primary">{{ $t("create_content")
        }}</a-button>
      </div>
    </div>

    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto p-3">
        <div v-for="courseModule in course.modules">
          <a-typography-title :level="3">
            <span v-if="courseModule.edit">
              <input v-model="courseModule.label" :readonly="false" @keyup.enter="onModuleLabelUpdate(courseModule)" />
            </span>
            <span v-else>
              {{ courseModule.label }}
              <span role="img" aria-label="form" class="anticon anticon-form ant-menu-item-icon"
                @click="courseModule.edit = true">
                <svg focusable="false" class="" data-icon="form" width="1em" height="1em" fill="currentColor"
                  aria-hidden="true" viewBox="64 64 896 896">
                  <path
                    d="M904 512h-56c-4.4 0-8 3.6-8 8v320H184V184h320c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V520c0-4.4-3.6-8-8-8z">
                  </path>
                  <path
                    d="M355.9 534.9L354 653.8c-.1 8.9 7.1 16.2 16 16.2h.4l118-2.9c2-.1 4-.9 5.4-2.3l415.9-415c3.1-3.1 3.1-8.2 0-11.3L785.4 114.3c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-415.8 415a8.3 8.3 0 00-2.3 5.6zm63.5 23.6L779.7 199l45.2 45.1-360.5 359.7-45.7 1.1.7-46.4z">
                  </path>
                </svg>
              </span>
            </span>
          </a-typography-title>
          <div v-for="content in course.contents">
            <div v-if="content.module == courseModule.value">
              <a-typography-text class="text-lg">{{ content.title }}</a-typography-text>
              <inertia-link
                :href="route('manage.course.contents.edit', { course: content.course_id, content: content.id })">
                <span role="img" aria-label="form" class="anticon anticon-form ant-menu-item-icon">
                  <svg focusable="false" class="" data-icon="form" width="1em" height="1em" fill="currentColor"
                    aria-hidden="true" viewBox="64 64 896 896">
                    <path
                      d="M904 512h-56c-4.4 0-8 3.6-8 8v320H184V184h320c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V520c0-4.4-3.6-8-8-8z">
                    </path>
                    <path
                      d="M355.9 534.9L354 653.8c-.1 8.9 7.1 16.2 16 16.2h.4l118-2.9c2-.1 4-.9 5.4-2.3l415.9-415c3.1-3.1 3.1-8.2 0-11.3L785.4 114.3c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-415.8 415a8.3 8.3 0 00-2.3 5.6zm63.5 23.6L779.7 199l45.2 45.1-360.5 359.7-45.7 1.1.7-46.4z">
                    </path>
                  </svg>
                </span>
              </inertia-link>
            </div>
            <div v-else>
              {{ addOrphen(content) }}
            </div>
          </div>
        </div>
        <div class="pt-5">
          <a-typography-title :level="3">
            Orphens
            <span role="img" aria-label="form" class="anticon anticon-form ant-menu-item-icon">
              <svg focusable="false" class="" data-icon="form" width="1em" height="1em" fill="currentColor"
                aria-hidden="true" viewBox="64 64 896 896">
                <path
                  d="M904 512h-56c-4.4 0-8 3.6-8 8v320H184V184h320c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V520c0-4.4-3.6-8-8-8z">
                </path>
                <path
                  d="M355.9 534.9L354 653.8c-.1 8.9 7.1 16.2 16 16.2h.4l118-2.9c2-.1 4-.9 5.4-2.3l415.9-415c3.1-3.1 3.1-8.2 0-11.3L785.4 114.3c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-415.8 415a8.3 8.3 0 00-2.3 5.6zm63.5 23.6L779.7 199l45.2 45.1-360.5 359.7-45.7 1.1.7-46.4z">
                </path>
              </svg>
            </span>
          </a-typography-title>
          <ol>
            <li v-for="content in orphenContents">
              {{ content.title }}
              <inertia-link
                :href="route('manage.course.contents.edit', { course: content.course_id, content: content.id })">
                <span role="img" aria-label="form" class="anticon anticon-form ant-menu-item-icon">
                  <svg focusable="false" class="" data-icon="form" width="1em" height="1em" fill="currentColor"
                    aria-hidden="true" viewBox="64 64 896 896">
                    <path
                      d="M904 512h-56c-4.4 0-8 3.6-8 8v320H184V184h320c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V520c0-4.4-3.6-8-8-8z">
                    </path>
                    <path
                      d="M355.9 534.9L354 653.8c-.1 8.9 7.1 16.2 16 16.2h.4l118-2.9c2-.1 4-.9 5.4-2.3l415.9-415c3.1-3.1 3.1-8.2 0-11.3L785.4 114.3c-1.6-1.6-3.6-2.3-5.7-2.3s-4.1.8-5.7 2.3l-415.8 415a8.3 8.3 0 00-2.3 5.6zm63.5 23.6L779.7 199l45.2 45.1-360.5 359.7-45.7 1.1.7-46.4z">
                    </path>
                  </svg>
                </span>
              </inertia-link>
            </li>
          </ol>
        </div>
      </div>
    </div>

    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto">
        <p>Alternative</p>
        <div class="ant-table">
          <div class="ant-container">
            <div class="ant-content">
              <table style="table-layout: auto;">
                <thead class="ant-table-thead">
                  <tr>
                    <th v-for="column in columns">{{ column.title }}</th>
                  </tr>
                </thead>
                <tbody class="ant-table-tbody">
                  <tr v-for="content in course.contents">
                    <td v-for="column in columns">
                      <div v-if="column.dataIndex == 'operation'">
                        <inertia-link
                          :href="route('manage.course.contents.edit', { course: content.course_id, content: content.id })"
                          class="ant-btn">{{ $t("edit") }}</inertia-link>
                          <a-button @click="deleteRecord(content.course_id, content.id)" type="danger">Delete</a-button>
                      </div>
                      <div v-else>
                        {{ content[column.dataIndex] }}
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!--
          <a-table :dataSource="course.contents" :columns="columns">
            <template #headerCell="{ column }">
              {{ column.i18n ? $t(column.i18n) : column.title }}
            </template>
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <inertia-link
                  :href="route('manage.course.contents.edit', {course:record.course_id, content:record.id})"
                  class="ant-btn">{{ $t("edit") }}</inertia-link
                >
              </template>
              <template v-else-if="column.dataIndex == 'state'">
                {{ teacherStateLabels[text] }}
              </template>
              <template v-else>
                {{ record[column.dataIndex] }}
              </template>
            </template>
          </a-table>
        -->
      </div>
    </div>


    <!-- Modal Start for Delete Course -->
    <a-modal
      v-model:visible="deleteModal.isOpen"
      :title="$t(deleteModal.title)"
      width="60%"
      :afterClose="deleteModalClose"
      @ok="onRecordDelete"
      ok-text="Confirm"
    >
      <a-form
        ref="modalRef"
        :model="deleteModal.data"
        name="Certificate"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        enctype="multipart/form-data"
      >
        <p>Are you sure you want to delete this course?</p>
      </a-form>
    </a-modal>
    <!-- Modal End -->
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
      orphenContents: {},
      columns: [
        {
          title: "Title",
          dataIndex: "title",
          i18n: "course_title",
        }, {
          title: "Type",
          dataIndex: "type",
          i18n: "type",
        }, {
          title: "操作",
          dataIndex: "operation",
          key: "operation",
          i18n: "operation",
        },
      ],
      labelCol: {
        style: {
          width: "150px",
        },
      },
      deleteModal: {
        isOpen: false,
        data: {},
        title: "Delete Content",
        mode: "",
      },
    };
  },
  created() { },
  methods: {
    goBack() {
      window.history.back();
    },
    addOrphen(content) {
      console.log(content);
      this.orphenContents[content.id] = content
    },
    onModuleLabelUpdate(courseModule) {
      console.log(courseModule);
      courseModule.edit = false
      this.$inertia.patch(route('manage.course.updateModule', this.course.id), courseModule, {
        onSuccess: (page) => {
          console.log(page);
        },
        onError: (err) => {
          console.log(err);
        }
      })
    },
    deleteRecord(courseId, contentId) {
      this.deleteModal.data = {};
      this.deleteModal.mode = "DELETE";
      this.deleteModal.isOpen = true;
      this.deleteModal.data.contentId = contentId;
      this.deleteModal.data.courseId = courseId;
    },
    deleteModalClose() {
      console.log('Close delete modal');
    },
    onRecordDelete(e) {
      console.log(e);
      console.log(this.deleteModal.data)
      this.$refs.modalRef.validateFields().then(() => {
        this.$inertia.delete(route('manage.course.contents.destroy',
          { course: this.deleteModal.data.courseId, content: this.deleteModal.data.contentId }), {
            onSuccess: (page) => {
              console.log(page);
              this.deleteModal.isOpen = false;
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
  