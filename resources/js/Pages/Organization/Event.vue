<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Event
      </h2>
    </template>

    <div class="container mx-auto">
      <div class="bg-white relative shadow rounded-lg p-5">
        <a-form :model="event" name="nest-messages" :validate-messages="validateMessages"
          layout="vertical" :rules="rules" @finish="onFinish">
          <a-form-item :label="$t('event_title_en')" name="title_en">
            <a-input v-model:value="event.title_en" />
          </a-form-item>
          <a-form-item :label="$t('event_title_fn')" name="title_fn">
            <a-input v-model:value="event.title_fn" />
          </a-form-item>
          <a-form-item :label="$t('category')" name="category">
            <a-select v-model:value="event.category" :options="categories" />
          </a-form-item>
          <a-row>
            <a-col :xs="24" :md="8">
                <a-form-item :label="$t('credit')" name="credit">
                    <a-input-number v-model:value="event.credit" min="0"/>
                </a-form-item>
            </a-col>
            <a-col :xs="24" :md="8">
                <a-form-item :label="$t('start_date')" name="start_date">
                    <a-date-picker v-model:value="event.start_date" :format="dateFormat" :valueFormat="dateFormat"/>
                </a-form-item>
            </a-col>
            <a-col :xs="24" :md="8">
                <a-form-item :label="$t('end_date')" name="end_date">
                    <a-date-picker v-model:value="event.end_date" :format="dateFormat" :valueFormat="dateFormat"/>
                </a-form-item>
            </a-col>
          </a-row>

          <a-form-item :label="$t('description')" name="description">
            <quill-editor v-model:value="event.description" style="min-height: 200px" />
          </a-form-item>
          <a-form-item :label="$t('remark')" name="remark">
            <quill-editor v-model:value="event.remark" style="min-height: 200px" />
          </a-form-item>
          <a-form-item>
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
  props: ['event','categories'],
  data() {
    return {
      mode: null,
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
    console.log(this.event);
  },
  mounted() {
  },
  methods: {
    onFinish() {
      console.log(this.event);
      if(this.event.id===undefined){
        this.$inertia.post(route('manage.events.store'), this.event,{
            onSuccess:(page)=>{
                console.log(page);
            },
            onError:(err)=>{
                console.log(err);
            }
        });
      }else{
        this.$inertia.patch(route('manage.events.update',this.event.id), this.event,{
            onSuccess:(page)=>{
                console.log(page);
            },
            onError:(err)=>{
                console.log(err);
            }
        });

      }

    }
  },
};
</script>

