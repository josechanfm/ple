<template>
    <OrganizationLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ $t("courses") }}
        </h2>
      </template>
      <div class="flex-auto pb-3 text-right">
        <inertia-link
            :href="route('manage.course.materials.create', course.id)"
            class="ant-btn">{{ $t("create_material") }}</inertia-link
        >

      </div>
      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-table :dataSource="course.materials" :columns="columns">
            <template #headerCell="{ column }">
              {{ column.i18n ? $t(column.i18n) : column.title }}
            </template>
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <inertia-link
                  :href="route('manage.course.materials.edit', {course:record.course_id, material:record.id})"
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
        columns: [
          {
            title: "Title",
            dataIndex: "title",
            i18n: "course_title",
          },{
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
      };
    },
    created() {},
    methods: {
   },
  };
  </script>
  