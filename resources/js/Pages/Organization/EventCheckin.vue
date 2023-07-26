<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Attendance
      </h2>
    </template>
    <div class="flex-auto pb-3 text-right">
        <a-button type="primary" :href="route('manage.event.qrcode')">Scan</a-button>
    </div>

    <div class="container mx-auto">
      <div class="bg-white relative shadow rounded-lg p-5">
        {{ event.title_en }}
        {{ event.start_date }}
        {{ event.end_date }}
        {{ event.description }}
        <div class="ant-table">
            <div class="ant-table-container">
                <div class="ant-table-content">
                    <table style="table-layout: auto;">
                        <thead class="ant-table-thead">
                            <tr>
                                <th class="ant-table-cell">a</th>
                                <th class="ant-table-cell">a</th>
                                <th class="ant-table-cell">a</th>
                            </tr>
                        </thead>
                        <tbody class="ant-table-tbody">
                            <tr v-for="member in members">
                                <td>{{ member.id }}</td>
                                <td>{{ member.given_name }} {{ member.family_name }}</td>
                                <td>{{ member.gender }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>

  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { quillEditor } from 'vue3-quill';
import { callWithAsyncErrorHandling, defineComponent, reactive } from "vue";
import dayjs from 'dayjs';

export default {
  components: {
    OrganizationLayout,
    quillEditor,
    dayjs,
  },
  props: ['event','members'],
  data() {
    return {
      dateFormat: "YYYY-MM-DD",
      rules: {
        title_en: { required: true },
        category: { required: true },
        start_date: { required: true },
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
      virticalStyle: {
        display: "flex",
        height: "30px",
        lineHeight: "30px",
        marginLeft: "8px",
      },
    };
  },
  created() {

  },
  mounted() {
  },
  methods: {
    onFinish() {

    }
  },
};
</script>

