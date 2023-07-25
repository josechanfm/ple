<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create competition
      </h2>
    </template>

    <div class="container mx-auto">
      <div class="bg-white relative shadow rounded-lg p-5">
        <a-form :model="competition" name="nest-messages" :validate-messages="validateMessages"
          layout="vertical" :rules="rules" @finish="onFinish">
          <a-form-item :label="$t('competition_title_en')" name="title_en">
            <a-input v-model:value="competition.title_en" />
          </a-form-item>
          <a-form-item :label="$t('competition_title_fn')" name="title_fn">
            <a-input v-model:value="competition.title_fn" />
          </a-form-item>
          <a-form-item :label="$t('description')" name="description">
            <quill-editor v-model:value="competition.description" style="min-height: 200px" />
          </a-form-item>
          <a-form-item :label="$t('competition_period')" name="period">
            <a-range-picker v-model:value="competition.period" :format="dateFormat" @change="onCompetitionPeriodChange" />
          </a-form-item>
          <a-form-item :label="$t('competition_dates')" name="match_dates">
            <a-select v-model:value="competition.match_dates" mode="multiple">
              <a-select-option v-for="d in dateList" :value="d">{{ d }}</a-select-option>
            </a-select>
          </a-form-item>
          <a-checkbox-group v-model:value="competition.cwSelected" class="w-full">
            <a-row :span="24">
              <template v-for="cw in categories_weights">
                <a-col :span="6">
                  <a-checkbox :value="cw.code">{{ cw.name }}</a-checkbox>
                  <ol>
                    <li v-for="male in cw.male">
                      {{ male.name }} : {{ male.limit[0] }} - {{ male.limit[1] }}
                    </li>
                  </ol>
                </a-col>
              </template>
            </a-row>
          </a-checkbox-group>
          <a-form-item :label="$t('role')" name="roleSelected">
            <a-checkbox-group v-model:value="competition.roleSelected">
              <a-checkbox v-for="role in roles" :style="virticalStyle" :value="role.value">{{ role.label }}</a-checkbox>
            </a-checkbox-group>
          </a-form-item>
          <a-form-item :wrapper-col="{ ...layout.wrapperCol, offset: 8 }">
            <a-button type="primary" html-type="submit">Submit</a-button>
          </a-form-item>
        </a-form>
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
  props: ["competitionSource", "categories_weights", "roles"],
  data() {
    return {
      mode: null,
      dateFormat: "YYYY-MM-DD",
      dateList: ['2023-01-02'],
      competition: {},
      rules: {
        title_en: { required: true },
        period: { required: true },
        match_date: { required: true },
        categoreis_weights: { required: true },
        roleSelected: { required: true },
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
      layout: {
        labelCol: {
          span: 8,
        },
        wrapperCol: {
          span: 16,
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
  mounted() {
    if (this.competitionSource == null) {
      this.mode = 'CREATE';
    } else {
      this.mode = 'EDIT';
      this.competition = { ...this.competitionSource };
      this.competition.period = []
      this.competition.period[0] = dayjs(this.competitionSource.start_date)
      this.competition.period[1] = dayjs(this.competitionSource.end_date)
      this.competition.cwSelected = this.competitionSource.categories_weights.map(cw => cw.code);
      this.competition.roleSelected = this.competitionSource.roles.map(cw => cw.value);
      this.getDaysArray(this.competition.period[0], this.competition.period[1])
      // this.competition.period[1] = this.competitionSource.end_date
    }
  },
  created() {

  },
  methods: {
    onCompetitionPeriodChange() {
      //var days = (this.competition.period[1]-this.competition.period[0])/(1000*60*60*24)+1
      //var getDaysArray = function(s,e) {for(var a=[],d=new Date(s);d<=new Date(e);d.setDate(d.getDate()+1)){ a.push(new Date(d));}return a;};
      this.getDaysArray(this.competition.period[0], this.competition.period[1])
    },
    getDaysArray(start, end) {

      for (var arr = [], dt = new Date(start); dt <= new Date(end); dt.setDate(dt.getDate() + 1)) {
        //arr.push(new Date(dt));
        arr.push(dt.getFullYear() + '-' + (dt.getMonth() + 1) + "-" + dt.getDate());
      }
      this.dateList = arr;
    },
    onFinish() {
      this.competition.categories_weights = this.categories_weights.filter(cw => this.competition.cwSelected.includes(cw.code));
      this.competition.roles = this.roles.filter(r => this.competition.roleSelected.includes(r.value));
      if (this.mode == "CREATE") {
        this.$inertia.post(route('manage.competitions.store'), this.competition, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (err) => {
            console.log(err);
          }
        });
      } else {
        this.$inertia.put(route('manage.competitions.update', this.competition.id), this.competition, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (err) => {
            console.log(err);
          }
        });

      }
    }
  },
};
</script>
