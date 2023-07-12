<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create competition
      </h2>
    </template>
    <p>{{ competition.title_en }}</p>
    <p>{{ competition.title_fn }}</p>
    <p>{{ competition.start_date }}</p>
    <p>{{ competition.end_date }}</p>
    <p>Dates:
        <ol>
            <li v-for="date in competition.match_dates">{{ date }}</li>
        </ol>
    </p>
    <p>Categories Weights
        <ol>
            <li v-for="cw in competition.categories_weights">
                {{ cw.name }}
                <p>Male</p>
                <ol>
                    <li v-for="male in cw.male">{{ male.name }}</li>
                </ol>
                <p>Female</p>
                <ol>
                    <li v-for="female in cw.female">{{ female.name }}</li>
                </ol>
            </li>
        </ol>
    </p>
    <p>Roles:
        <ol>
            <li v-for="role in competition.roles">{{ role.label }}</li>
        </ol>
    </p>
    <a-form
      :model="competition"
      v-bind="layout"
      name="nest-messages"
      :validate-messages="validateMessages"
      layout="vertical"
      :rules="rules"
      @finish="onFinish"
    >
    </a-form>
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
  props: ["competitionSource","categories_weights", "roles"],
  data() {
    return {
      mode:null,
      dateFormat: "YYYY-MM-DD",
      dateList:['2023-01-02'],
      competition:{},
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
  mounted(){
    if(this.competitionSource==null){
      this.mode='CREATE';
    }else{
      this.mode='EDIT';
      this.competition={...this.competitionSource};
      this.competition.period=[]
      this.competition.period[0] = dayjs(this.competitionSource.start_date)
      this.competition.period[1] = dayjs(this.competitionSource.end_date)
      this.competition.cwSelected=this.competitionSource.categories_weights.map(cw=>cw.code);
      this.getDaysArray(this.competition.period[0],this.competition.period[1])
      // this.competition.period[1] = this.competitionSource.end_date
    }
  },
  created() {
      
  },
  methods: {
    getDaysArray(start,end){

        for(var arr=[],dt=new Date(start); dt<=new Date(end); dt.setDate(dt.getDate()+1)){
            //arr.push(new Date(dt));
            arr.push(dt.getFullYear()+'-'+(dt.getMonth()+1)+"-"+dt.getDate());
        }
        this.dateList=arr;
    },
    onFinish(){
    }
  },
};
</script>

