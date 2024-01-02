<template>
  <WebLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">表格例表</h2>
    </template>
    <div class="py-0">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-5 bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- <div id="pure-html">
                <div v-html="html" />
            </div>
            <hr>
            success
            {{ application }} -->
          <div>
            <p>你已成功報名參賽:</p>
          </div>
          <div class="text-center">
            <a-typography-title :level="3">{{
              application.competition.title_zh
            }}</a-typography-title>
          </div>
          <div class="ant-table ant-table-bordered">
            <div class="ant-table-container">
              <div class="ant-table-content">
                <table id="applicationSuccess" style="table-layout: auto">
                  <tbody class="ant-table-tbody">
                    <tr>
                      <td>{{ $t("name_zh") }}</td>
                      <td>{{ application.name_zh }}</td>
                      <td>{{ $t("id_num") }}</td>
                      <td>{{ application.id_num }}</td>
                    </tr>
                    <tr>
                      <td>{{ $t("name_fn") }}</td>
                      <td colspan="3">{{ application.name_fn }}</td>
                    </tr>
                    <tr>
                      <td>{{ $t("gender") }}</td>
                      <td>{{ application.gender }}</td>
                      <td>{{ $t("dob") }}</td>
                      <td>{{ application.dob }}</td>
                    </tr>
                    <tr>
                      <td>{{ $t("email") }}</td>
                      <td>{{ application.email }}</td>
                      <td>{{ $t("mobile_number") }}</td>
                      <td>{{ application.mobile }}</td>
                    </tr>
                    <tr>
                      <td>{{ $t("belt_rank") }}</td>
                      <td>
                        {{
                          belt_ranks.find((b) => b.rankCode == application.belt_rank)
                            .name_zh
                        }}
                      </td>
                      <td>{{ $t("role") }}</td>
                      <td>
                        {{
                          application.competition.roles.find(
                            (r) => r.value == application.role
                          ).label
                        }}
                      </td>
                    </tr>
                    <tr v-if="application.role == 'athlete'">
                      <td>{{ $t("category") }}</td>
                      <td>{{ application.category }}</td>
                      <td>{{ $t("weight") }}</td>
                      <td>{{ application.weight }}</td>
                    </tr>
                    <tr v-if="application.role == 'staff'">
                      <td>{{ $t("staff_options") }}</td>
                      <td colspan="3">
                        <ol>
                          <li v-for="option in application.staff_options">
                            {{
                              application.competition.staff_options.find(
                                (o) => o.value == option
                              ).label
                            }}
                          </li>
                        </ol>
                      </td>
                    </tr>
                    <tr v-if="application.role == 'referee'">
                      <td>{{ $t("referee_options") }}</td>
                      <td colspan="3">
                        {{
                          application.competition.referee_options.find(
                            (o) => o.value == application.referee_options
                          ).label
                        }}
                      </td>
                    </tr>
                    <tr v-if="application.avatar">
                      <td>{{ $t("avatar") }}</td>
                      <td colspan="3">
                        <img :src="application.avatar_url" width="200" />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="flex justify-between py-10">
            <div>
              <a :href="route('/')">返回主頁</a>
            </div>
            <div>
              <a
                :href="
                  '/competition/application/' + application.id + '/success?format=pdf'
                "
                >打印發票</a
              >
            </div>
            <div>
              <a :href="route('competitions.index')">賽事列表</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </WebLayout>
</template>

<script>
import WebLayout from "@/Layouts/WebLayout.vue";
import dayjs from "dayjs";
import { message } from "ant-design-vue";
import { Modal } from "ant-design-vue";
import CropperModal from "@/Components/Member/CropperModal.vue";

export default {
  components: {
    WebLayout,
    dayjs,
    message,
    Modal,
    CropperModal,
  },
  props: ["organizations", "competition", "application", "belt_ranks"],
  data() {
    return {};
  },
  mounted() {},
  created() {},
  methods: {},
};
</script>

<style scope>
#pure-html {
  all: initial;
}

#pure-html * {
  all: revert;
}
/* 
table {
  width: 100%;
}
table tr,table td {
  border: 1px solid;
  padding-left: 5px;
} */
</style>
