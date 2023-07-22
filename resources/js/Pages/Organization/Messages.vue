<template>
  <OrganizationLayout title="Dashboard">
    <div class="p-8 pt-8">
      <div class="flex pb-2">
        <div
          class="flex-auto w-1/2 font-semibold text-xl text-gray-800 truncate whitespace-nowrap"
        >
          通信管理
        </div>
        <div class="flex-auto w-1/2 text-right">
          <a-button type="primary" class="!rounded" @click="createRecord()"
            >新增通信</a-button
          >
        </div>
      </div>
      <div class="card drop-shadow-md pt-4">
        <a-table
          :dataSource="messages.data"
          :columns="columns"
          :pagination="pagination"
          @change="onPaginationChange"
          ref="dataTable"
        >
          <template #bodyCell="{ column, text, record, index }">
            <template v-if="column.dataIndex == 'operation'">
              <div class="space-x-2">
                <a-button @click="editRecord(record)">修改</a-button>
                <a-popconfirm
                  title="是否確定刪除這個通信"
                  ok-text="是"
                  cancel-text="否"
                  @confirm="deleteRecord(record.id)"
                >
                  <a-button>刪除</a-button>
                </a-popconfirm>
              </div>
            </template>
            <template v-else-if="column.dataIndex == 'category'">
              {{ messageCategories.find((x) => x.value == record.category)["label"] }}
            </template>
            <template v-else-if="column.dataIndex == 'receiver'">
              <div v-if="record.category == 'personal' || record.category == 'public'">
                {{ messageCategories.find((x) => x.value == record.category)["label"] }}
              </div>
              <div v-else>{{ record.receiver ?? "--" }}</div>
            </template>
          </template>
        </a-table>
      </div>
      <!-- Modal Start-->
      <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
        <a-form
          ref="modalRef"
          :model="modal.data"
          name="Teacher"
          :label-col="{ span: 4 }"
          :wrapper-col="{ span: 20 }"
          autocomplete="off"
          :rules="rules"
          :validate-messages="validateMessages"
        >
          <a-form-item :label="$t('classification')" name="category">
            <a-select v-model:value="modal.data.category" :options="messageCategories" />
          </a-form-item>
          <a-form-item
            label="收件人"
            name="receiver"
            v-if="modal.data.category == 'personal'"
          >
            <a-select
              v-model:value="modal.data.receiver"
              :options="members"
              :field-names="{ label: 'display_name', value: 'id' }"
            />
          </a-form-item>
          <a-form-item :label="$t('sender')" name="sender">
            <a-input v-model:value="modal.data.sender" />
          </a-form-item>
          <a-form-item :label="$t('title')" name="title">
            <a-input v-model:value="modal.data.title" />
          </a-form-item>
          <a-form-item :label="$t('content')" name="content">
            <quill-editor v-model:value="modal.data.content" style="min-height: 200px" />
          </a-form-item>
        </a-form>
        <template #footer>
          <a-button
            v-if="modal.mode == 'EDIT'"
            key="Update"
            type="primary"
            @click="updateRecord()"
            >Update</a-button
          >
          <a-button
            v-if="modal.mode == 'CREATE'"
            key="Store"
            type="primary"
            @click="storeRecord()"
            >Add</a-button
          >
        </template>
      </a-modal>
      <!-- Modal End-->
    </div>
  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { UploadOutlined } from "@ant-design/icons-vue";
import Icon, { RestFilled } from "@ant-design/icons-vue";
import { quillEditor } from "vue3-quill";
import { message } from "ant-design-vue";

export default {
  components: {
    OrganizationLayout,
    UploadOutlined,
    RestFilled,
    quillEditor,
  },
  props: ["messageCategories", "messages", "members"],
  data() {
    return {
      modal: {
        isOpen: false,
        data: {},
        title: "Modal",
        mode: "",
      },
      pagination: {
        total: this.messages.total,
        current: this.messages.current_page,
        pageSize: this.messages.per_page,
      },
      filter: {},
      columns: [
        {
          title: "分類",
          dataIndex: "category",
          width: 80,
        },
        {
          title: "標題",
          dataIndex: "title",
        },
        {
          title: "發件人",
          dataIndex: "sender",
          width: 120,
        },
        {
          title: "收件人",
          dataIndex: "receiver",
          width: 120,
        },
        {
          title: "操作",
          dataIndex: "operation",
          key: "operation",
          width: 200,
        },
      ],
      rules: {
        field: { required: true },
        label: { required: true },
      },
      validateMessages: {
        required: "請输入${label}",
        types: {
          email: "${label} 不是正確的郵箱格式",
          number: "${label} 不是正確的數字格式",
        },
        number: {
          range: "${label} 必須在${min}和${max}之間",
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
    createRecord(record) {
      this.modal.data = {};
      this.modal.mode = "CREATE";
      this.modal.isOpen = true;
    },
    editRecord(record) {
      this.modal.data = { ...record };
      this.modal.mode = "EDIT";
      this.modal.isOpen = true;
    },
    storeRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.$inertia.post(route("admin.messages.store"), this.modal.data, {
            preserveState: false,
            onSuccess: (page) => {
              this.modal.isOpen = false;
              message.success("新增成功");
            },
            onError: (err) => {
              console.log(err);
            },
          });
        })
        .catch((err) => {
          console.log(err);
        });
    },
    updateRecord() {
      this.$refs.modalRef
        .validateFields()
        .then(() => {
          this.modal.data._method = "PATCH";
          this.$inertia.post(
            route("admin.messages.update", this.modal.data.id),
            this.modal.data,
            {
              preserveState: false,
              onSuccess: (page) => {
                this.modal.isOpen = false;
                message.success("修改成功");
              },
              onError: (error) => {
                console.log(error);
              },
            }
          );
        })
        .catch((err) => {
          console.log("error", err);
        });
    },

    deleteRecord(recordId) {
      this.$inertia.delete("/admin/messages/" + recordId, {
        preserveState: false,
        onSuccess: (page) => {
          message.success("刪除成功");
          console.log(page);
        },
        onError: (error) => {
          alert(error.message);
        },
      });
    },
    onPaginationChange(page, filters, sorter) {
      this.$inertia.get(
        route("admin.messages.index"),
        {
          page: page.current,
          per_page: page.pageSize,
        },
        {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (error) => {
            console.log(error);
          },
        }
      );
    },
  },
};
</script>
