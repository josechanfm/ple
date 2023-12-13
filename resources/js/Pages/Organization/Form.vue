<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("form_generator") }}
      </h2>
    </template>
    <div class="container mx-auto">
      <div class="bg-white relative shadow  p-5 rounded-lg overflow-x-auto">
        <a-form
            ref="modalRef"
            :model="form"
            name="From"
            :label-col="{ span: 6 }"
            :wrapper-col="{ span: 18 }"
            autocomplete="off"
            :rules="rules"
            :validate-messages="validateMessages"
            @finish="onFinish"
        >
            <a-form-item :label="$t('form_name')" name="name">
                <a-input v-model:value="form.name" />
            </a-form-item>
            <a-form-item :label="$t('title')" name="title">
                <a-input v-model:value="form.title" />
            </a-form-item>
                <div class="text-right">
                    <a @click="form.openWelcome=!form.openWelcome">{{ $t('form_welcome') }}</a>
                </div>
            <a-form-item :label="$t('form_welcome')" name="welcome" v-if="form.openWelcome">
                <quill-editor
                    v-model:value="form.welcome"
                    style="min-height: 200px"
                />
            </a-form-item>
            <a-form-item :label="$t('description')" name="description">
                <quill-editor
                    v-model:value="form.description"
                    style="min-height: 200px"
                />
            </a-form-item>
            <div class="text-right">
                <a @click="form.openThankyou=!form.openThankyou">{{ $t('form_thankyou') }}</a>
            </div>
            <a-form-item :label="$t('form_thankyou')" name="thankyou" v-if="form.openThankyou">
                <quill-editor
                    v-model:value="form.thankyou"
                    style="min-height: 200px"
                />
            </a-form-item>
            <a-form-item :label="$t('require_login')" name="require_login">
                <a-switch
                    v-model:checked="form.require_login"
                    :unCheckedValue="0"
                    :checkedValue="1"
                    @change="form.for_member = false"
                />
                <span class="pl-3">{{ $t("require_login_note") }}</span>
            </a-form-item>
            <a-form-item
                :label="$t('for_member')"
                name="for_member"
                v-if="form.require_login"
            >
                <a-switch
                    v-model:checked="form.for_member"
                    :unCheckedValue="0"
                    :checkedValue="1"
                />
                <span class="pl-3">{{ $t("for_member_note") }}</span>
            </a-form-item>
            <a-form-item :label="$t('published')" name="published">
                <a-switch
                    v-model:checked="form.published"
                    :unCheckedValue="0"
                    :checkedValue="1"
                    @change="form.with_attendance = false"
                    :disabled="form.entries_count > 0"
                />
                <span class="pl-3">{{ $t("published_note") }}</span
                ><br />
                <span v-if="form.entries_count > 0">
                    The form has responses, please backup before unpublished.</span
                >
            </a-form-item>
            <a-form-item
                :label="$t('with_attendance')"
                name="with_attendance"
                v-if="form.published"
            >
                <a-switch
                    v-model:checked="form.with_attendance"
                    :unCheckedValue="0"
                    :checkedValue="1"
                />
                <span class="pl-3">{{ $t("with_attendance_note") }}</span>
            </a-form-item>
            <a-form-item :label="$t('banner_image')" name="banner_image">
                <div v-if="form.media.length">
                    <inertia-link
                    :href="route('manage.form.deleteMedia', form.media[0].id)"
                    class="float-right text-red-500"
                    >
                    <svg
                        focusable="false"
                        class=""
                        data-icon="delete"
                        width="1em"
                        height="1em"
                        fill="currentColor"
                        aria-hidden="true"
                        viewBox="64 64 896 896"
                    >
                        <path
                        d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"
                        ></path>
                    </svg>
                    </inertia-link>
                    <img :src="form.media[0].preview_url" width="100" />
                </div>
                <div v-else>
                    <a-upload
                    v-model:file-list="form.image"
                    :multiple="false"
                    :max-count="1"
                    list-type="picture-card"
                    :beforeUpload="
                        () => {
                        return false;
                        }
                    "
                    :show-upload-list="false"
                    @change="uploadChange"
                    >
                    <img v-if="imageUrl" :src="imageUrl" alt="banner" />
                    <div v-else>
                        <loading-outlined v-if="loading"></loading-outlined>
                        <plus-outlined v-else></plus-outlined>
                        <div class="ant-upload-text">{{ $t("upload") }}</div>
                    </div>
                    </a-upload>
                </div>
            </a-form-item>
            <a-form-item :wrapper-col="{ offset: 12, span: 10 }">
                <a-button type="primary" html-type="submit">Submit</a-button>
            </a-form-item>
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
import Icon, { RestFilled } from "@ant-design/icons-vue";
import { quillEditor, Quill } from "vue3-quill";
import { message } from "ant-design-vue";

export default {
  components: {
    OrganizationLayout,
    UploadOutlined,
    LoadingOutlined,
    PlusOutlined,
    RestFilled,
    quillEditor,
    message,
  },
  props: ["organization", "form"],
  data() {
    return {
      loading: false,
      imageUrl: null,
      rules: {
        name: { required: true },
        title: { required: true },
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
  created() {
  },
  mounted() {
    console.log(this.form)
  },
  methods: {
    onFinish(){
        console.log('on Finshed')
        if(this.form.id){
            console.log('Update')
            this.updateRecord()
        }else{
            console.log('Create')
            this.storeRecord()
        }
    },
    storeRecord() {
        this.$inertia.post(route("manage.forms.store"), this.form, {
        onSuccess: (page) => {
            this.imageUrl = null;
        },
        onError: (err) => {
            console.log(err);
        },
        });
    },
    updateRecord() {
        this.form._method = "PATCH";
        this.$inertia.post(
            route("manage.forms.update", this.form.id),this.form,{
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    console.log(error);
                },
            }
        );
    },
    uploadChange(info) {
      console.log(info);
      const isJpgOrPng =
        info.file.type === "image/jpeg" || info.file.type === "image/png";
      if (!isJpgOrPng) {
        console.log("image format!");
        message.error("You can only upload JPG/PNG file!");
      }
      const isLt2M = info.file.size / 1024 / 1024 < 0.2;
      if (!isLt2M) {
        console.log("image size");
        message.error("Image must smaller than 2MB!");
      }

      if (isJpgOrPng && isLt2M) {
        this.getBase64(info.file, (base64Url) => {
          this.imageUrl = base64Url;
          this.loading = true;
        });
      } else {
        this.form.image = [];
      }
    },
    getBase64(img, callback) {
      const reader = new FileReader();
      reader.addEventListener("load", () => callback(reader.result));
      reader.readAsDataURL(img);
    },
  },
};
</script>
