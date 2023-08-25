<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create competition
      </h2>
    </template>
    <div class="container mx-auto">
      <div class="bg-white relative shadow rounded-lg p-5">
        <div id="pure-html">
              <div v-html="competition.description"/>
          </div>
          <a-form 
            :model="application" 
            name="nest-messages" 
            :validate-messages="validateMessages"
            layout="vertical" 
            :rules="rules" 
            @finish="onFinish"
          >
            <a-form-item :label="$t('given_name')" name="given_name">
              <a-input v-model:value="application.given_name"/>
            </a-form-item>
            <a-form-item :label="$t('family_name')" name="family_name">
              <a-input v-model:value="application.family_name"/>
            </a-form-item>
            <a-form-item :label="$t('middle_name')" name="middle_name">
              <a-input v-model:value="application.middle_name"/>
            </a-form-item>
            <a-form-item :label="$t('display_name')" name="display_name">
              <a-input v-model:value="application.display_name"/>
            </a-form-item>
            <a-form-item :label="$t('dob')" name="dob" >
              <a-date-picker v-model:value="application.dob" :format="dateFormat" :valueFormat="dateFormat"/>
            </a-form-item>
            <a-form-item :label="$t('gender')" name="gender">
              <a-radio-group v-model:value="application.gender" @change="onGenderChange">
                <a-radio value="M">{{ $t('male') }}</a-radio>
                <a-radio value="F">{{ $t('female')  }}</a-radio>
              </a-radio-group>
            </a-form-item>
            <a-form-item :label="$t('email')" name="email">
              <a-input v-model:value="application.email"/>
            </a-form-item>
            <a-form-item :label="$t('mobile')" name="mobile">
              <a-input v-model:value="application.mobile"/>
            </a-form-item>
            <a-form-item :label="$t('role')" name="role">
              <a-radio-group v-model:value="application.role">
                <a-radio v-for="role in competition.roles" :style="virticalStyle" :value="role.value">{{ role.label }}
                </a-radio>
              </a-radio-group>
            </a-form-item>
            <template v-if="application.role=='athlete'">
              <a-form-item :label="$t('category')" name="category">
                <a-radio-group v-model:value="application.category">
                  <a-radio v-for="cat in competition.categories_weights" :style="virticalStyle" :value="cat.code"
                    @change="onCategoryChange">{{ cat.name }}
                  </a-radio>
                </a-radio-group>
              </a-form-item>
              <a-form-item :label="$t('weight')" name="weight">
                <a-radio-group v-model:value="application.weight">
                  <a-radio v-for="cat in competition.weights" :style="virticalStyle" :value="cat.code">{{ cat.name }}
                  </a-radio>
                </a-radio-group>
              </a-form-item>

            </template>
            <a-form-item :wrapper-col="{ ...layout.wrapperCol, offset: 8 }">
                <a-button type="primary" html-type="submit">{{$t('submit')}}</a-button>
            </a-form-item>

          </a-form>
      </div>
    </div>
  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import dayjs from 'dayjs';

export default {
  components: {
    OrganizationLayout,
    dayjs
  },
  props: ["competition", "categories_weights", "roles"],
  data() {
    return {
      dateFormat: "YYYY-MM-DD",
      application:{},
      rules: {
        given_name: { required: true },
        family_name: { required: true },
        display_name: { required: true },
        dob: { required: true },
        gender: { required: true },
        category: { required: true },
        weight: { required: true },
        role: { required: true }
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
      //this.competition = { ...this.competitionSource };
      this.competition.period = []
      this.competition.period[0] = dayjs(this.competition.start_date)
      this.competition.period[1] = dayjs(this.competition.end_date)
      this.competition.cwSelected = this.competition.categories_weights.map(cw => cw.code);
      this.getDaysArray(this.competition.period[0], this.competition.period[1])
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
        this.weightSelection(event.target.value, this.application.category);
      }
    },
    onCategoryChange(event) {
      console.log(event);
      if (this.application.gender) {
        console.log("ok");
        this.weightSelection(this.application.gender, event.target.value);
      }
    },
    weightSelection(gender, category) {
      if (gender == "M") {
        this.competition.weights = this.competition.categories_weights.find(
          (cat) => cat.code == category
        ).male;
      } else {
        this.competition.weights = this.competition.categories_weights.find(
          (cat) => cat.code == category
        ).female;
      }
    },
    onFinish() {
      Alert('done')

    },
  },
};
</script>

<style scope>
#pure-html {
  all:initial
}
#pure-html *{
  all: revert;
}

</style>