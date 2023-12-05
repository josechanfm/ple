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
          <div v-if="competition.media.find(m => m.collection_name == 'competitionBanner')">
            <img :src="competition.media.find(m => m.collection_name == 'competitionBanner').original_url"
              style="width: 100%" />
          </div>
          <a-typography-title :level="3" class="text-center">{{ competition.title_zh }}</a-typography-title>
          <a-typography-title :level="4">賽事日:
            <span v-for="date in competition.match_dates">{{ date }}</span>
          </a-typography-title>
          <div id="pure-html">
            <div v-html="competition.description" />
          </div>

          <ol>
            <li v-for="file in competition.media.filter(m => m.collection_name == 'competitionAttachment')">
              <a :href="file.original_url" target="_blank">{{ file.file_name }}</a>
            </li>
          </ol>

          <a-form :model="application" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
            layout="vertical" :rules="rules" @finish="onFinish">
            <a-form-item :label="$t('organization')" name="organization_id">
              <a-select v-model:value="application.organization_id" :options="organizations"
                :field-names="{ value: 'value', label: 'label' }" />
            </a-form-item>
            <a-form-item :label="$t('name_zh')" name="name_zh">
              <a-input v-model:value="application.name_zh" />
            </a-form-item>
            <a-form-item :label="$t('name_fn')" name="name_fn">
              <a-input v-model:value="application.name_fn" />
            </a-form-item>
            <!-- <a-form-item :label="$t('middle_name')" name="middle_name">
              <a-input v-model:value="application.middle_name"/>
            </a-form-item> -->
            <!--
            <a-form-item :label="$t('display_name')" name="display_name">
              <a-input v-model:value="application.display_name" />
            </a-form-item>
            -->
            <a-form-item :label="$t('belt_rank')" name="belt_rank">
              <a-select v-model:value="application.belt_rank" :options="belt_ranks"
                :field-names="{ value: 'rankCode', label: 'name_zh' }" />
            </a-form-item>
            <a-form-item :label="$t('dob')" name="dob">
              <a-date-picker v-model:value="application.dob" :format="dateFormat" :valueFormat="dateFormat" />
            </a-form-item>
            <a-form-item :label="$t('gender')" name="gender">
              <a-radio-group v-model:value="application.gender" @change="onGenderChange">
                <a-radio value="M">{{ $t('male') }}</a-radio>
                <a-radio value="F">{{ $t('female') }}</a-radio>
              </a-radio-group>
            </a-form-item>
            <a-form-item :label="$t('email')" name="email">
              <a-input v-model:value="application.email" />
            </a-form-item>
            <a-form-item :label="$t('mobile_number')" name="mobile">
              <a-input v-model:value="application.mobile" />
            </a-form-item>
            <a-form-item :label="$t('role')" name="role" v-if="application.gender">
              <a-radio-group v-model:value="application.role">
                <a-radio v-for="role in competition.roles" :value="role.value" :style="virticalStyle">{{ role.label }}
                </a-radio>
              </a-radio-group>
            </a-form-item>
            <template v-if="application.role == 'athlete' && application.gender">
              <a-form-item :label="$t('category')" name="category">
                <a-radio-group v-model:value="application.category">
                  <a-radio v-for="cat in competition.categories_weights" :value="cat.code" :style="virticalStyle"
                    @change="onCategoryChange">
                    {{ cat.name }} - [{{ cat.description }}]
                  </a-radio>
                </a-radio-group>
              </a-form-item>
              <a-form-item :label="$t('weight')" name="weight">
                <a-radio-group v-model:value="application.weight">
                  <a-radio v-for="cat in competition.weights" :style="virticalStyle" :value="cat.code">
                    {{ cat.name }}
                  </a-radio>
                </a-radio-group>
              </a-form-item>

            </template>
            <template v-if="application.role == 'referee'">
              <a-form-item :label="$t('referee_options')" name="referee_options" v-if="application.gender">
                <a-radio-group v-model:value="application.referee_options">
                  <a-radio v-for="option in refereeOptions" :value="option.value"
                    :style="virticalStyle">{{ option.label }}</a-radio>
                </a-radio-group>
              </a-form-item>
            </template>

            <template v-if="application.role == 'staff'">
              <a-form-item :label="$t('staff_options')" name="staff_options" v-if="application.gender">
                <a-checkbox-group v-model:value="application.staff_options">
                  <a-checkbox v-for="option in staffOptions" :value="option.value"
                    :style="virticalStyle">{{ option.label }}</a-checkbox>
                </a-checkbox-group>
              </a-form-item>
            </template>

              <a-button @click="showCropModal = true">{{$t("upload_profile_image")}}</a-button>
                <CropperModal
                  v-if="showCropModal"
                  :minAspectRatioProp="{ width: 8, height: 8 }"
                  :maxAspectRatioProp="{ width: 8, height: 8 }"
                  @croppedImageData="setCroppedImageData"
                  @showModal="showCropModal = false"
                />
                <div class="flex flex-wrap mt-4 mb-6">
                  <div class="w-full md:w-1/2 px-3">
                    <div v-if="avatarPreview !== null">
                      <img :src="avatarPreview" />
                    </div>
                    <div v-else>
                      <img :src="competition.avatar_url" />
                    </div>
                  </div>
                </div>


            <div class="flex flex-row item-center justify-center">
              <a-button type="primary" html-type="submit">{{ $t('submit') }}</a-button>
            </div>
          </a-form>
        </div>
      </div>
    </div>
    <a-modal v-model:visible="modal.isOpen" :title="modal.title" :cancelButtonProps="{ style: 'display:none' }"
      okText="$t{'understand'}">
      <p>Duplicate entry,</p>
      <p>If you are Athlete, you may apply at most 2 categories in the same competition.</p>
      <p>Or you may apply one role only.</p>
      <p>{{ modal.content }}</p>
    </a-modal>

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
  props: ["belt_ranks", "member", "competition"],
  data() {
    return {
      showCropModal: false,
      avatarPreview: null,
      modal: {
        isOpen: false,
        title: 'Application Failed',
        content: "Error message"
      },
      mode: null,
      dateFormat: "YYYY-MM-DD",
      dateList: ["2023-01-02"],
      application: {},
      refereeOptions: [
        { value: "International_A", label: "已持有國際A級裁判資格" },
        { value: "International_B", label: "已持有國際B級裁判資格" },
        { value: "Local_A", label: "已持有本地裁判A級資格" },
        { value: "Local_B", label: "已持有本地裁判B級資格" },
        { value: "Other_Country", label: "其他地區裁判資格" },
        { value: "Trainee", label: "實習裁判" }
      ],
      staffOptions: [
        { value: "parent", label: "家長義工" },
        { value: "student", label: "學生義工" },
        { value: "weighting", label: "過磅工作人員(裁判人員或已有相關工作經驗優先)" },
        { value: "mc_match", label: "賽事司儀(已有相關工作經驗優先)" },
        { value: "checker", label: "檢錄組(已有相關工作經驗優先)" },
        { value: "score_digital", label: "電子計分操作員(已持有IJF 國際柔道賽事計時記分系統操作員培訓優先報名)" },
        { value: "score_manual", label: "計時記分操作員(手動計時記分)" },
        { value: "control", label: "司令台(已有相關工作經驗優先)" },
        { value: "mc_award", label: "頒獎禮司儀(已有相關工作經驗優先)" },
        { value: "helper_award", label: "頒獎小組(已有相關工作經驗優先)" },
        { value: "general", label: "總務小組" },
        { value: "venue_setup", label: "場地佈置" }
      ],
      organizations: [
        { value: "1", label: "澳門柔道館" },
        { value: "2", label: "宣道堂柔道會" },
        { value: "3", label: "一本柔道部" },
      ],
      rules: {
        organization_id: { required: true },
        given_name: { required: true },
        family_name: { required: true },
        display_name: { required: true },
        belt_rank: { required: true },
        dob: { required: true },
        gender: { required: true },
        email: { required: true, type: "email" },
        mobile: { required: true },
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
        minHeight: "30px",
        lineHeight: "30px",
        marginLeft: "8px",
      },
    };
  },
  mounted() {
    this.application.competition_id = this.competition.id;
    if (this.member) {
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
    setCroppedImageData(data) {
      this.avatarPreview = data.imageUrl;
      this.avatarData = data;
      //console.log(data);
    },
    onGenderChange(event) {
      if (this.application.category) {
        this.weightSelection(event.target.value, this.application.category);
      }
      this.application.role = null;
      this.application.category = null;
      this.application.weight = null;
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

      this.application.avatar = this.avatarData.blob;
      this.$inertia.post(route('competitions.store'), this.application, {
        onSuccess: (page) => {
          console.log(page);
          this.competition = {};
        },
        onError: (error) => {
          this.modal.content = error.message
          this.modal.isOpen = true
        }
      });

    },
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
</style>