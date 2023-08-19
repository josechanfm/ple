<template>
  <OrganizationLayout title="Dashboard">
    <div class="p-8 pt-8">
      <div class="flex pb-2">
        <div
          class="flex-auto w-1/2 font-semibold text-xl text-gray-800 truncate whitespace-nowrap"
        >
          Bulletins
        </div>
        <div class="flex-auto w-1/2 text-right">
          <a-button type="primary" class="!rounded" @click="createRecord()"
            >Create Buletin</a-button>
        </div>
      </div>
      <div class="card drop-shadow-md pt-4">
        <!-- {{ new Date().getFullYear() - 2009 + 1 }}
        {{ yearLength }} -->
        <a-table
          :dataSource="bulletins.data"
          :columns="columns"
          :pagination="pagination"
          @change="onPaginationChange"
          ref="dataTable"
        >
          <template #headerCell="{column}">
              {{ column.i18n?$t(column.i18n):column.title}}
          </template>
          <template #bodyCell="{ column, text, record, index }">
            <template v-if="column.key == 'published'">{{
              record.published == 1 ? "Yes" : "No"
            }}</template>
            <template v-if="column.dataIndex == 'operation'">
              <div class="space-x-2">
                <a-button @click="editRecord(record)">Edit</a-button>
                <a-popconfirm
                  title="Are you sure to delete the record?"
                  ok-text="Yes"
                  cancel-text="No"
                  @confirm="deleteRecord(record.id)"
                >
                  <a-button>Delete</a-button>
                </a-popconfirm>
              </div></template
            >
            <template v-else-if="column.dataIndex == 'category'">
              {{ bulletinCategories.find((x) => x.value == text)["label"] }}
            </template>
          </template>
        </a-table>
      </div>
      <!-- Modal Start-->
      <a-modal
        v-model:visible="modal.isOpen"
        :title="modal.mode == 'CREATE' ? 'Create' : 'Edit'"
        width="60%"
      >
        <a-form
          ref="modalRef"
          :model="modal.data"
          :label-col="{ span: 4 }"
          :wrapper-col="{ span: 20 }"
          :rules="rules"
          :validate-messages="validateMessages"
        >
          <a-form-item :label="$t('category')" name="category">
            <a-select v-model:value="modal.data.category" :options="bulletinCategories" />
          </a-form-item>
          <a-form-item :label="$t('date')" name="date">
            <a-date-picker
              v-model:value="modal.data.date"
              :format="dateFormat"
              :valueFormat="dateFormat"
            />
          </a-form-item>
          <a-form-item :label="$t('title')" name="title">
            <a-input v-model:value="modal.data.title" />
          </a-form-item>
          <a-form-item :label="$t('description')" name="description">
            <a-input v-model:value="modal.data.description" />
          </a-form-item>
          <a-form-item :label="$t('content')" name="content">
            <a-textarea v-model:value="modal.data.content" />
          </a-form-item>
          <a-form-item :label="$t('published')" name="published">
            <a-switch
              v-model:checked="modal.data.published"
              :unCheckedValue="0"
              :checkedValue="1"
            />
          </a-form-item>
          <a-form-item :label="$t('image')" name="images">
            <a-upload
              v-model:file-list="modal.data.images"
              list-type="picture-card"
              :beforeUpload="() => false"
            >
              <div>
                <upload-outlined></upload-outlined>
                <div style="margin-top: 8px">Upload</div>
              </div>
            </a-upload>
          </a-form-item>
        </a-form>
        <template #footer>
          <a-button
            v-if="modal.mode == 'EDIT'"
            :loading="loading"
            key="Update"
            type="primary"
            @click="updateRecord()"
            >修改</a-button
          >
          <a-button
            v-if="modal.mode == 'CREATE'"
            :loading="loading"
            key="Store"
            type="primary"
            @click="storeRecord()"
            >新增</a-button
          >
        </template>
      </a-modal>
    </div>
    <!-- Modal End-->
  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { UploadOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";
import Icon, { RestFilled } from "@ant-design/icons-vue";
import { quillEditor } from "vue3-quill";

export default {
  components: {
    OrganizationLayout,
    UploadOutlined,
    RestFilled,
    quillEditor,
  },
  props: ["bulletinCategories", "bulletins"],
  data() {
    return {
      dateFormat: "YYYY-MM-DD",
      yearCurrent: 2023,
      yearStart: new Date().getFullYear() + 1,
      yearLength: new Date().getFullYear() - 2009 + 2,
      loading: false,
      modal: {
        isOpen: false,
        data: {
          published: 1,
        },
        title: "公告",
        mode: "",
      },
      pagination: {
        total: this.bulletins.total,
        current: this.bulletins.current_page,
        pageSize: this.bulletins.per_page,
      },
      filter: {},
      columns: [
        {
          title: "Title",
          dataIndex: "title",
        },
        {
          title: "Date",
          dataIndex: "date",
        },
        {
          title: "Category",
          dataIndex: "category",
        },
        {
          title: "Published",
          dataIndex: "published",
          key: "published",
        },
        {
          title: "Operation",
          dataIndex: "operation",
          key: "operation",
        },
      ],
      rules: {
        title: { required: true },
        date: { required: true },
        category: { required: true },
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
  compunted: {
    pagination() {
      return {
        total: this.bulletins.total,
        current: this.bulletins.current_page,
        pageSize: this.bulletins.per_page,
      };
    },
  },
  methods: {
    createRecord(record) {
      this.modal.data = {
        published: 1,
      };
      this.modal.mode = "CREATE";
      this.modal.isOpen = true;
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.mode = "EDIT";
      console.log(record);
      this.modal.isOpen = true;
    },
    storeRecord() {
      this.loading = true;
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.post(route("admin.bulletins.store"), this.modal.data, {
            preserveState: false,
            onSuccess: (page) => {
              this.modal.isOpen = false;
              console.log(page);
              message.success("新增成功");
            },
            onError: (err) => {
              console.log(err);
            },
            onFinish: (visit) => {
              this.loading = false;
            },
          });
        })
        .catch((err) => {
          this.loading = false;
          console.log(err);
        });
    },
    updateRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.modal.data._method = "PATCH";
          this.$inertia.post(
            route("admin.bulletins.update", this.modal.data.id),
            this.modal.data,
            {
              preserveState: false,
              onSuccess: (page) => {
                this.modal.isOpen = false;
                message.success("修改成功");
              },
              onError: (error) => {
                console.log(error);
                message.error(error.error);
              },
            }
          );
        })
        .catch((err) => {
          console.log("error", err);
        });
    },

    deleteRecord(recordId) {
      this.$inertia.delete("/admin/bulletins/" + recordId, {
        preserveState: false,
        onSuccess: (page) => {
          console.log(page);
        },
        onError: (error) => {
          alert(error.message);
        },
      });
    },
    onPaginationChange(page, filters, sorter) {
      this.$inertia.get(route("admin.bulletins.index"), {
        page: page.current,
        per_page: page.pageSize,
      });
    },
  },
};
</script>
