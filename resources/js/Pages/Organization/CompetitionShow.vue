<template>
  <WebLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        表格例表
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-5 bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <a-typography-title :level="3" class="text-center">{{ competition.title_fn }}</a-typography-title>
          <a-typography-title :level="4" >Date: {{ competition.start_date }} - {{ competition.end_date }}</a-typography-title>
          <!--
          <a-typography-title :level="4" >Match Date: 
            <span v-for="date in competition.match_dates">{{ date }} ,</span>
          </a-typography-title>
          -->
          <div id="pure-html">
              <div v-html="competition.description"/>
          </div>
          

          <a-form 
            :model="application" 
            v-bind="layout" 
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
            <template v-if="application.role=='athlete' && application.gender">
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
            <div class="flex flex-row item-center justify-center">
                <a-button type="primary" html-type="submit">{{$t('submit')}}</a-button>
            </div>

          </a-form>
        </div>
      </div>
    </div>
  </WebLayout>
    <a-modal v-model:visible="modal.isOpen" :title="modal.title" :okButtonProps="{style:'display:none'}" cancelText="Ok">
      <p>This is the testing page.</p>
      <p>The application form pass the test.</p>
      <p>You are ready to publish the application form of the competition.</p>
    </a-modal>
</template>

<script>
import WebLayout from "@/Layouts/WebLayout.vue";
import dayjs from "dayjs";
import { message } from 'ant-design-vue';
import { Modal } from 'ant-design-vue';

export default {
  components: {
    WebLayout,
    dayjs,
    message,
    Modal
  },
  props: ["member", "competition"],
  data() {
    return {
      modal:{
        isOpen:false,
        title:'Application Failed',
        content:"Error message"
      },
      mode: null,
      dateFormat: "YYYY-MM-DD",
      dateList: ["2023-01-02"],
      application: {},
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
    this.application.competition_id = this.competition.id;
    if(this.member){
        this.application.member_id = this.member.id;
        this.application.given_name = this.member.given_name;
        this.application.family_name = this.member.family_name;
        this.application.middle_name = this.member.middle_name;
        this.application.display_name = this.member.display_name;
        this.application.gender = this.member.gender;
        this.application.dob = this.member.dob;
        this.application.email = this.member.email;
        this.application.mobile = this.member.mobile;

    }
  },
  created() {

  },
  methods: {
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
          this.modal.content='test'
          this.modal.isOpen=true

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