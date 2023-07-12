<template>
  <MemberLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        表格例表
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-5 bg-white overflow-hidden shadow-xl sm:rounded-lg">
          {{ member }}
          <p>{{ member.first_name }} {{ member.last_name }}</p>
          {{ member.display_name }}
          <p>{{ competition.title_en }}</p>
          <p>{{ competition.title_fn }}</p>
          <p>{{ competition.start_date }}</p>
          <p>{{ competition.end_date }}</p>

          <p>Dates:
          <ol>
            <li v-for="date in competition.match_dates">{{ date }}</li>
          </ol>
          </p>

          <a-form :model="competition" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
            layout="vertical" :rules="rules" @finish="onFinish">
            <a-form-item label="Full name (en)" name="title_en">
              <a-input v-model:value="application.title_en" />
            </a-form-item>
            <a-form-item label="gender" name="gender">
              <a-radio-group v-model:value="application.gender" @change="onGenderChange">
                <a-radio value="M">Male</a-radio>
                <a-radio value="F">Female</a-radio>
              </a-radio-group>
            </a-form-item>
            <a-form-item label="Categories" name="category">
              <a-radio-group v-model:value="application.category">
                <a-radio v-for="cat in competition.categories_weights" :style="virticalStyle" :value="cat.code"
                  @change="onCategoryChange">{{ cat.name }}
                </a-radio>
              </a-radio-group>
            </a-form-item>
            <a-form-item label="Weight" name="weight">
              <a-radio-group v-model:value="application.weight">
                <a-radio v-for="cat in competition.weights" :style="virticalStyle" :value="cat.code">{{ cat.name }}
                </a-radio>
              </a-radio-group>
            </a-form-item>
            <a-form-item label="Role" name="role">
              <a-radio-group v-model:value="application.role">
                <a-radio v-for="role in competition.roles" :style="virticalStyle" :value="role.value">{{ role.label }}
                </a-radio>
              </a-radio-group>
            </a-form-item>
          </a-form>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import dayjs from 'dayjs';

export default {
  components: {
    MemberLayout,
    dayjs
  },
  props: ["member", "competition", "categories_weights", "roles"],
  data() {
    return {
      mode: null,
      dateFormat: "YYYY-MM-DD",
      dateList: ['2023-01-02'],
      application: {},
      rules: {
        title_en: { required: true },
        period: { required: true },
        match_date: { required: true },
        categoreis_weights: { required: true },
        roles: { required: true },
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
      this.getDaysArray(this.competition.period[0], this.competition.period[1])
      // this.competition.period[1] = this.competitionSource.end_date
    }
  },
  created() {

  },
  methods: {
    getDaysArray(start, end) {

      for (var arr = [], dt = new Date(start); dt <= new Date(end); dt.setDate(dt.getDate() + 1)) {
        //arr.push(new Date(dt));
        arr.push(dt.getFullYear() + '-' + (dt.getMonth() + 1) + "-" + dt.getDate());
      }
      this.dateList = arr;
    },
    onGenderChange(event) {
      console.log(event);
      if (this.application.category) {
        console.log("ok");
        this.weightSelection(event.target.value, this.application.category)
      }

    },
    onCategoryChange(event) {
      console.log(event);
      if (this.application.gender) {
        console.log("ok");
        this.weightSelection(this.application.gender, event.target.value)
      }
    },
    weightSelection(gender, category) {
      if (gender == 'M') {
        this.competition.weights = this.competition.categories_weights.find(cat => cat.code == category).male
      } else {
        this.competition.weights = this.competition.categories_weights.find(cat => cat.code == category).female
      }
    },
    onFinish() {
    }
  },
};
</script>

