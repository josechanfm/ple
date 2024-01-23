<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("course") }}
      </h2>
    </template>
    <div class="flex-auto pb-3 text-right">
      <a-button @click="createModuleRecord" type="primary">Create Module</a-button>
    </div>
    <CourseBuilder :course="course">
        <a-collapse>
          <template v-for="modul in course.modules">
            <a-collapse-panel :header="modul.label">
              <div class="flex-auto pb-3 text-right">
                <a-button @click="createContentRecord" type="primary">Create Content</a-button>
              </div>
              <ul class="module-list">
                <template v-for="content in course.contents">
                  <li v-if="content.module==modul.value" class="module-list-item">
                    {{ content.title }}
                    <a-button @click="editRecord(content)">edit</a-button>
                  </li>
                </template>
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

    <!-- Modal Start-->
     <a-modal
      v-model:visible="modalCreateModule.isOpen"
      :title="$t(modalCreateModule.title)"
      width="60%"
      :afterClose="modalCreateModuleClose"
      @ok="onRecordSave"
      ok-text="Save"
    >
      <a-form
        ref="modalFormRef"
        :model="modalCreateModule.data"
        name="Certificate"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
        enctype="multipart/form-data"
      >
        <a-form-item label="Module Name" name="module_name">
          <a-input v-model:value="modalCreateModule.data.module_name" />
        </a-form-item>
        
      </a-form>
    </a-modal>


    <!-- Modal Start-->
    <a-modal
      v-model:visible="modal.isOpen"
      :title="$t(modal.title)"
      width="60%"
      :afterClose="modalClose"
      @ok="onRecordUpdate"
      ok-text="Update"
    >

      <a-form
        ref="modalRef"
        :model="modal.data"
        name="Certificate"
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        autocomplete="off"
        :rules="rules"
        :validate-messages="validateMessages"
        enctype="multipart/form-data"
      >
        <a-form-item label="Module" name="module">
          <a-select v-model:value="modal.data.module" :options="course.modules" />
        </a-form-item>
        <a-form-item label="Type" name="type">
          <a-select v-model:value="modal.data.type" :options="content_types" />
        </a-form-item>
        <a-form-item label="Title" name="title">
          <a-input v-model:value="modal.data.title" />
        </a-form-item>
        <a-form-item label="Content" name="content">
          <a-textarea v-model:value="modal.data.content" />
        </a-form-item>
      </a-form>
    </a-modal>
    <!-- Modal End-->



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
  props: ["course",'content_types'],
  data() {
    return {
      open:false,
      individualContents:[],
      modal: {
        isOpen: false,
        data: {},
        title: "Edit Content",
        mode: "",
      },
      modalCreateModule: {
        isOpen: false,
        data: {},
        title: "Create Module",
        mode: "",
      },
      rules: {
        category_code: { required: true },
        cert_title: { required: true },

        module_name: { required: true },
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
    const modules=this.course.modules.map(m=>m.value)
    console.log(modules)
    this.individualContents = this.course.contents.filter(c=>!modules.includes(c.module))
    console.log(this.individualContents);
  },
  methods: {
    createModuleRecord(){
      this.modalCreateModule.data = {};
      this.modalCreateModule.mode = "CREATE";
      this.modalCreateModule.isOpen = true;
      this.modal.isOpen = false;
    },
    onRecordSave(e){
      console.log(e);
      console.log(this.modalCreateModule.data)
      this.$refs.modalFormRef.validateFields().then(()=>{
        this.$inertia.post(route('manage.course.createModule', this.course.id), this.modalCreateModule.data, {
          onSuccess: (page) => {
            console.log(page);
            this.modalCreateModule.isOpen = false;
          },
          onError: (err) => {
            console.log(err);
          }
        });
      })
    },
    showDrawer(){
      console.log('oepn drawer');
        this.open=true
        console.log(this.open);
    }, 
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.mode = "EDIT";
      this.modal.isOpen = true;
      this.modalCreateModule.isOpen = false;
    },
    modalClose(){
      console.log('Close modal');
    },
    modalCreateModuleClose(){
      console.log('test');
    },
    // onClose(){
    //     this.open=false
    // },

    // onFinish() {
    //   if (this.course.id === undefined) {
    //     this.$inertia.post(route('manage.courses.store'), this.course, {
    //       onSuccess: (page) => {
    //         console.log(page);
    //       },
    //       onError: (err) => {
    //         console.log(err);
    //       }
    //     });
    //   } else {
    //     this.$inertia.patch(route('manage.courses.update', this.course.id), this.course, {
    //       onSuccess: (page) => {
    //         console.log(page);
    //       },
    //       onError: (err) => {
    //         console.log(err);
    //       }
    //     });

    //   }

    // },
    onRecordUpdate(e){
      console.log(e);
        console.log(this.modal.data)
        this.$refs.modalRef.validateFields().then(()=>{
          this.$inertia.patch(route('manage.contents.update', this.modal.data.id), this.modal.data, {
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
  },
};
</script>

<style>
.ant-collapse-content > .ant-collapse-content-box {
  padding:0!important
}
.module-list-item{
  padding-left:10px;
  border-bottom: 1px solid lightgray;
}
.module-list{
  line-height:30px;
}
</style>