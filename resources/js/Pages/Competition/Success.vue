<template>
  <WebLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        表格例表
      </h2>
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
            <p>{{application.competition.title_zh}}</p> 
            <table id="applicationSuccess">
                <tr>
                    <th>{{ $t('name_zh') }}</th>
                    <td colspan="4">{{ application.name_zh }}</td>
                </tr>
                <tr>
                    <th>{{ $t('name_fn') }}</th>
                    <td colspan="4">{{ application.name_fn }}</td>
                </tr>
                <tr>
                    <th>{{ $t('gender') }}</th>
                    <td>{{ application.gender }}</td>
                    <th>{{ $t('dob') }}</th>
                    <td>{{ application.dob }}</td>
                </tr>
                <tr>
                    <th>{{ $t('email') }}</th>
                    <td>{{ application.email }}</td>
                    <th>{{ $t('mobile') }}</th>
                    <td>{{ application.mobile }}</td>
                </tr>
                <tr>
                    <th>{{ $t('belt_rank') }}</th>
                    <td>{{ belt_ranks.find(b=>b.rankCode==application.belt_rank).name_zh }}</td>
                    <th>{{ $t('role') }}</th>
                    <td>{{ application.competition.roles.find(r=>r.value==application.role).label }}</td>
                </tr>
                <tr v-if="application.role=='athlete'">
                    <th>{{ $t('category') }}</th>
                    <td>{{ application.category }}</td>
                    <th>{{ $t('weight') }}</th>
                    <td>{{ application.weight }}</td>
                </tr>
                <tr v-if="application.role=='staff'">
                    <th>{{ $t('staff_options') }}</th>
                    <td colspan="4">
                        <ol>
                            <li v-for="option in application.staff_options">
                                {{ application.competition.staff_options.find(o=>o.value==option).label }}
                            </li>
                        </ol>
                    </td>
                </tr>
                <tr v-if="application.role=='referee'">
                    <th>{{ $t('referee_options') }}</th>
                    <td colspan="4">
                        {{ application.competition.referee_options.find(o=>o.value==application.referee_options).label}}
                    </td>
                </tr>
                <tr>
                    <th>{{ $t('avatar') }}</th>
                    <td colspan="4">
                        <img :src="application.avatar_url" width="200"/>
                    </td>
                </tr>
            </table>
            <a :href="route('/')">返回主頁</a><br>
            <a :href="route('competitions.index')">賽事列表</a>
            
        </div>
      </div>
    </div>
  </WebLayout>
</template>

<script>
import WebLayout from "@/Layouts/WebLayout.vue";
import dayjs from "dayjs";
import { message } from 'ant-design-vue';
import { Modal } from 'ant-design-vue';
import CropperModal from "@/Components/Member/CropperModal.vue";

export default {
  components: {
    WebLayout,
    dayjs,
    message,
    Modal,
    CropperModal
  },
  props: ["competition","application","belt_ranks"],
  data() {
    return {
    };
  },
  mounted() {
  },
  created() {

  },
  methods: {
  },
};
</script>

<style scope>
#pure-html {
  all: initial
}

#pure-html * {
  all: revert;
}
table{
    width:100%;
}
table, tr, td{
    border:1px solid;
}
</style>
