<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("articles") }}
      </h2>
    </template>
    <div>
      <a-button @click="isDrawerVisible = !isDrawerVisible" type="primary">{{
        $t("images")
      }}</a-button>
    </div>
    <a-button @click="getCursor()">{{ $t("cursor") }}</a-button>
    <div class="container mx-auto pt-5">
      <div class="bg-white relative shadow rounded-lg overflow-x-auto p-5">
        <a-form
          :model="article"
          name="Teacher"
          layout="vertical"
          autocomplete="off"
          :rules="rules"
          :validate-messages="validateMessages"
          @finish="onFinish"
        >
          <a-form-item :label="$t('article_category')" name="category_code">
            <a-select
              v-model:value="article.category_code"
              :options="articleCategories"
            />
          </a-form-item>
          <a-form-item :label="$t('title_en')" name="title_en">
            <a-input v-model:value="article.title_en" />
          </a-form-item>
          <a-form-item :label="$t('title_fn')" name="title_fn">
            <a-input v-model:value="article.title_fn" />
          </a-form-item>
          <a-form-item :label="$t('content')" name="content_en">
            <ckeditor
              ref="editorRef"
              :editor="editor"
              v-model="article.content_en"
              :config="editorConfig"
              :height="300"
            />
          </a-form-item>
          <a-form-item :label="$t('valid_at')" name="valid_at">
            <a-date-picker
              v-model:value="article.valid_at"
              :format="dateFormat"
              :valueFormat="dateFormat"
            />
          </a-form-item>
          <a-form-item :label="$t('expired_at')" name="expired_at">
            <a-date-picker v-model:value="article.expire_at" :valueFormat="dateFormat" />
          </a-form-item>
          <a-form-item :label="$t('url')" name="url">
            <a-input v-model:value="article.url" />
          </a-form-item>
          <a-row>
            <a-col>
              <a-form-item :label="$t('published')" name="published">
                <a-switch
                  v-model:checked="article.published"
                  :checkedValue="1"
                  :unCheckedValue="0"
                  @change="article.public = 0"
                />
              </a-form-item>
            </a-col>
            <a-col class="pl-10" v-if="article.published">
              <a-form-item :label="$t('public')" name="public">
                <a-switch
                  v-model:checked="article.public"
                  :checkedValue="1"
                  :unCheckedValue="0"
                />
              </a-form-item>
            </a-col>
          </a-row>
          <div class="flex flex-row item-center justify-center">
            <a-button type="primary" html-type="submit">{{ $t("submit") }}</a-button>
          </div>
        </a-form>
      </div>
      <p>Article CAN NOT be delete if published.</p>
    </div>
    <a-drawer
      v-model:visible="isDrawerVisible"
      class="custom-class"
      title="Basic Drawer"
      placement="right"
      @after-visible-change="afterVisibleChange"
    >
      <div class="h-max-48 overflow-auto">
        <ul>
          <li v-for="media in medias" @click="selectMedia(media)">
            {{ media.file_name }}
          </li>
        </ul>
      </div>
      <div>
        <div v-if="selectedMedia">
          <img
            v-if="selectedMedia.preview_url"
            :src="selectedMedia.preview_url"
            width="100"
          />
          <img v-else :src="selectedMedia.original_url" width="100" />
          <a-button @click="addToArticle">{{ $t("add") }}</a-button>
        </div>
      </div>
    </a-drawer>
  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { defineComponent, reactive } from "vue";
//import Editor from 'ckeditor5-custom-build/build/ckeditor';
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import UploadAdapter from "@/Components/ImageUploadAdapter.vue";

export default {
  components: {
    OrganizationLayout,
    ckeditor: CKEditor.component,
    UploadAdapter,
    //UploadAdapter
  },
  props: ["classifies", "articleCategories", "article", "articles"],
  data() {
    return {
      medias: [],
      selectedMedia: null,
      isDrawerVisible: false,
      dateFormat: "YYYY-MM-DD",
      editor: ClassicEditor,
      editorData: "<p>Content of the editor.</p>",
      editorConfig: {
        extraPlugins: [
          function (editor) {
            editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
              return new UploadAdapter(loader);
            };
          },
        ],
        // The configuration of the editor.
      },
      rules: {
        category_code: { required: true },
        classify_id: { required: true },
        title_en: { required: true },
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
  mounted() {},
  methods: {
    createRecord() {
      this.modal.data = {};
      this.modal.mode = "CREATE";
      this.modal.title = "Create";
      this.modal.isOpen = true;
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.mode = "EDIT";
      //this.modal.title = "Edit";
      this.modal.isOpen = true;
    },
    deleteConfirmed(record) {
      this.$inertia.delete(route("manage.articles.destroy", record.id), {
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
    uploader(editor) {
      editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return new UploadAdapter(loader);
      };
    },
    onFinish(event) {
      console.log(event);
      if (this.article.id) {
        this.$inertia.put(route("manage.articles.update", this.article.id), event, {
          onSuccess: (page) => {
            this.modal.data = {};
            this.modal.isOpen = false;
            console.log(page);
          },
          onError: (error) => {
            console.log(error);
          },
        });
      } else {
        console.log("create");
        this.$inertia.post(route("manage.articles.store"), event, {
          onSuccess: (page) => {
            this.modal.data = {};
            this.modal.isOpen = false;
          },
          onError: (err) => {
            console.log(err);
          },
        });
      }
    },
    afterVisibleChange(bool) {
      if (bool) {
        axios.get(route("manage.medias", 22)).then((response) => {
          this.medias = response.data;
        });
      }
    },
    selectMedia(media) {
      this.selectedMedia = media;
      console.log(this.selectedMedia);
    },
    addToArticle(meida) {
      var selection = this.editor.view.state.selection;
      console.log(selection);
      console.log(this.selectedMedia);
    },
    ckEditorFocusOut(event) {
      console.log("focus out");
      console.log(event);
    },
    getCursor() {
      var content = this.$refs.editorRef.modelValue;
      console.log(content);
      var selection = this.$refs.editorRef.instance;
      console.log(selection);
    },
  },
};
</script>

<style scope>
.ck-editor .ck-editor__main .ck-content {
  min-height: 500px;
}
</style>
