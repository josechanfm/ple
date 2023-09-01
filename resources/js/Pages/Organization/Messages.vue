<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Messages
            </h2>
        </template>
        <div class="flex-auto pb-3 text-right">
          <a-button type="primary" class="!rounded" @click="createRecord()">Create Message</a-button>
        </div>

      <div class="container mx-auto pt-5">
        <div class="bg-white relative shadow rounded-lg overflow-x-auto">
          <a-table :dataSource="messages.data" :columns="columns" :pagination="pagination" @change="onPaginationChange"
            ref="dataTable">
            <template #bodyCell="{ column, text, record, index }">
              <template v-if="column.dataIndex == 'operation'">
                <div class="space-x-2">
                  <a-button @click="editRecord(record)">Edit</a-button>
                  <a-popconfirm title="Are you sure to DELETE?" ok-text="Yes" cancel-text="No"
                    @confirm="deleteRecord(record.id)">
                    <a-button>Delete</a-button>
                  </a-popconfirm>
                </div>
              </template>
              <template v-else-if="column.dataIndex == 'category_code'">
                {{ messageCategories.find((x) => x.value == record.category_code)["label"] }}
              </template>
              <template v-else-if="column.dataIndex == 'receiver'">
                <ol>
                  <li v-for="member in record.received_members">{{ member.given_name }}</li>
                </ol>
              </template>
            </template>
          </a-table>
        </div>
      </div>
      <!-- Modal Start-->
      <a-modal v-model:visible="modal.isOpen" :title="modal.title" width="60%">
        <a-form ref="modalRef" :model="modal.data" name="Teacher" :label-col="{ span: 4 }" :wrapper-col="{ span: 20 }"
          autocomplete="off" :rules="rules" :validate-messages="validateMessages">
          <a-form-item :label="$t('classification')" name="category_code">
            <a-select v-model:value="modal.data.category_code" :options="messageCategories" />
          </a-form-item>
          <a-form-item label="Receiver" name="receiver" v-if="modal.data.category_code == 'IND'">
            <a-select mode="multiple" v-model:value="modal.data.receiver" :options="members"
              :field-names="{ label: 'display_name', value: 'id' }" />
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
          <a-button v-if="modal.mode == 'EDIT'" key="Update" type="primary" @click="updateRecord()">Update</a-button>
          <a-button v-if="modal.mode == 'CREATE'" key="Store" type="primary" @click="storeRecord()">Add</a-button>
        </template>
      </a-modal>
      <!-- Modal End-->
    
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
          title: "Category",
          dataIndex: "category_code",
          width: 80,
        },
        {
          title: "Title",
          dataIndex: "title",
        },
        {
          title: "Sender",
          dataIndex: "sender",
          width: 120,
        },
        {
          title: "Receiver",
          dataIndex: "receiver",
          width: 120,
        },
        {
          title: "Operation",
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
        required: '${label} is required!',
        types: {
          email: '${label} is not a valid email!',
          number: '${label} is not a valid number!',
        },
        number: {
          range: '${label} must be between ${min} and ${max}',
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
          this.$inertia.post(route("manage.messages.store"), this.modal.data, {
            preserveState: false,
            onSuccess: (page) => {
              this.modal.isOpen = false;
              message.success("Create Successful.");
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
            route("manage.messages.update", this.modal.data.id),
            this.modal.data,
            {
              preserveState: false,
              onSuccess: (page) => {
                this.modal.isOpen = false;
                message.success("Update Successful.");
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
      this.$inertia.delete(route('manage.messages.destroy', recordId), {
        preserveState: false,
        onSuccess: (page) => {
          message.success("Delete Successful.");
          console.log(page);
        },
        onError: (error) => {
          alert(error.message);
        },
      });
    },
    onPaginationChange(page, filters, sorter) {
      this.$inertia.get(
        route("manage.messages.index"),
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
