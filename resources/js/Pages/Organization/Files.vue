<template>
    <OrganizationLayout title="Dashboard">
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Files
        </h2>
      </template>

      <div class="flex-auto pb-3 text-right">
        <a-button>Create Folder</a-button>
        <a-button
            color="primary" 
            rounded 
            dark 
            :loading="isSelecting" 
            @click="handleFileImport"
        >
            Upload File
        </a-button>
        <!-- Create a File Input that will be hidden but triggered with JavaScript -->
        <input 
            ref="uploader" 
            style="display: none"
            type="file" 
            @change="onFileChanged"
            multiple
        >

        
      </div>



      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-table :dataSource="files" :columns="columns">
            <template #headerCell="{ column }">
              {{ column.i18n ? $t(column.i18n) : column.title }}
            </template>
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <inertia-link
                  :href="route('manage.courses.show', record.id)"
                  class="ant-btn">{{ $t("show") }}</inertia-link
                >
                <inertia-link
                  :href="route('manage.courses.edit', record.id)"
                  class="ant-btn">{{ $t("edit") }}</inertia-link
                >
                <inertia-link
                  :href="route('manage.course.contents.index', record.id)"
                  class="ant-btn">{{ $t("course_contents") }}</inertia-link
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
    props: ["files"],
    data() {
      return {
        fileSizeLimit: 1024*1024*5,
        isSelecting: false,
        selectedFile: null,
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
        handleFileImport() {
                this.isSelecting = true;

                // After obtaining the focus when closing the FilePicker, return the button state to normal
                window.addEventListener('focus', () => {
                    this.isSelecting = false
                }, { once: true });
                
                // Trigger click on the FileInput
                this.$refs.uploader.click();
            },
        onFileChanged(e) {
            console.log(this.fileSizeLimit);
            this.selectedFile = e.target.files[0];
            let fileSizeExceed=false;
            [...e.target.files].forEach(f=>{
                if(f.size>this.fileSizeLimit){
                    fileSizeExceed=true;
                }
                console.log(f.size);
            })
            console.log(fileSizeExceed);

            // Do whatever you need with the file, liek reading it with FileReader
        },
   },
  };
  </script>
  