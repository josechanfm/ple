<template>
  <OrganizationLayout title="Dashboard">
    <template #header>
      <h2
        v-if="mode == 'CREATE'"
        class="font-semibold text-xl text-gray-800 leading-tight"
      >
        {{ $t("create_competition") }}
      </h2>
      <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("edit_competition") }}
      </h2>
    </template>
    <div class="container mx-auto">
      <div class="bg-white relative shadow rounded-lg p-5">
        <a-form
          :model="competitionData"
          name="nest-messages"
          :validate-messages="validateMessages"
          layout="vertical"
          :rules="rules"
          @finish="onFinish"
        >
          <a-form-item :label="$t('competition_title_zh')" name="title_zh">
            <a-input v-model:value="competitionData.title_zh" />
          </a-form-item>
          <a-form-item :label="$t('competition_title_fn')" name="title_fn">
            <a-input v-model:value="competitionData.title_fn" />
          </a-form-item>
          <a-form-item :label="$t('brief')" name="brief">
            <a-textarea v-model:value="competitionData.brief" style="min-height: 100px" />
          </a-form-item>
          <a-form-item :label="$t('description')" name="description">
            <quill-editor
              v-model:value="competitionData.description"
              style="min-height: 200px"
            />
          </a-form-item>
          <a-form-item :label="$t('competition_period')" name="period">
            <a-range-picker
              v-model:value="competitionData.period"
              :format="dateFormat"
              @change="onCompetitionPeriodChange"
            />
          </a-form-item>
          <a-form-item :label="$t('competition_dates')" name="match_dates">
            <a-select v-model:value="competitionData.match_dates" mode="multiple">
              <a-select-option v-for="d in dateList" :value="d">{{ d }}</a-select-option>
            </a-select>
          </a-form-item>
          <a-form-item :label="$t('group')" name="cwSelected">
            <a @click="showWeightList = !showWeightList" class="float-right">詳細內容</a>
            <a-checkbox-group v-model:value="competitionData.cwSelected" class="w-full">
              <a-row :span="24">
                <template v-for="cw in categories_weights">
                  <a-col :span="24 / categories_weights.length">
                    <a-checkbox :value="cw.code">{{ cw.name }}</a-checkbox
                    ><br />
                  </a-col>
                </template>
              </a-row>
            </a-checkbox-group>
          </a-form-item>
          <a-divider></a-divider>

          <a-card v-show="showWeightList">
            <template #title> 各級重量 </template>
            <table width="100%">
              <tr>
                <th v-for="cw in categories_weights" class="text-left">
                  <a-typography-title :level="5">{{ cw.name }}</a-typography-title>
                </th>
              </tr>
              <tr class="align-top">
                <td v-for="cw in categories_weights">
                  <a-typography-text strong>男子組</a-typography-text>
                  <ol>
                    <li v-for="male in cw.male">
                      {{ male.name }} : {{ male.limit[0] }} - {{ male.limit[1] }}
                    </li>
                  </ol>
                  <a-typography-text strong>女子組</a-typography-text>
                  <ol>
                    <li v-for="female in cw.female">
                      {{ female.name }} : {{ female.limit[0] }} - {{ female.limit[1] }}
                    </li>
                  </ol>
                </td>
              </tr>
            </table>
          </a-card>

          <a-form-item :label="$t('role')" name="roleSelected">
            <a-checkbox-group v-model:value="competitionData.roleSelected">
              <a-checkbox
                v-for="role in roles"
                :style="virticalStyle"
                :value="role.value"
                >{{ role.label }}</a-checkbox
              >
            </a-checkbox-group>
          </a-form-item>
          <a-form-item
            :label="$t('referee_options')"
            name="referee_options"
            v-if="competitionData.roleSelected.includes('referee')"
            :rules="
              competitionData.roleSelected.includes('referee') ? [{ required: true }] : []
            "
          >
            <a-checkbox-group v-model:value="competitionData.referee_options">
              <a-checkbox
                v-for="option in referee_options"
                :style="virticalStyle"
                :value="option"
                >{{ option.label }}</a-checkbox
              >
            </a-checkbox-group>
          </a-form-item>
          <a-form-item
            :label="$t('staff_options')"
            name="staff_options"
            v-if="competitionData.roleSelected.includes('staff')"
            :rules="
              competitionData.roleSelected.includes('staff') ? [{ required: true }] : []
            "
          >
            <a-checkbox-group v-model:value="competitionData.staff_options">
              <a-checkbox
                v-for="option in staff_options"
                :style="virticalStyle"
                :value="option"
                >{{ option.label }}</a-checkbox
              >
            </a-checkbox-group>
          </a-form-item>

          <a-form-item :label="$t('banner_image')" name="competition_banner">
            <div
              v-if="
                mode == 'EDIT' &&
                competition.media.find((m) => m.collection_name == 'competitionBanner')
              "
            >
              <inertia-link
                :href="
                  route('manage.competition.deleteMedia', {
                    type: 'banner',
                    competition_id: competition.id,
                  })
                "
                method="post"
                as="button"
                type="button"
                class="float-right text-red-500"
              >
                <svg
                  focusable="false"
                  class=""
                  data-icon="delete"
                  width="1em"
                  height="1em"
                  fill="currentColor"
                  aria-hidden="true"
                  viewBox="64 64 896 896"
                >
                  <path
                    d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"
                  ></path>
                </svg>
              </inertia-link>
              <img
                :src="
                  competition.media.find((m) => m.collection_name == 'competitionBanner')
                    .preview_url
                "
              />
            </div>
            <div v-else>
              <a-upload
                v-model:file-list="competitionData.banner"
                :multiple="false"
                :beforeUpload="beforeBannerUpload"
                :max-count="1"
                :accept="uploadValidator.banner.format.toString()"
                list-type="picture"
                :capture="null"
              >
                <a-button>
                  <upload-outlined></upload-outlined>
                  {{ $t("upload_file") }}
                </a-button>
              </a-upload>
            </div>
          </a-form-item>
          <a-form-item :label="$t('attachment')" name="attachment">
            <div v-if="mode == 'EDIT'">
              <div
                v-for="file in competition.media.filter(
                  (m) => m.collection_name == 'competitionAttachment'
                )"
              >
                <inertia-link
                  :href="
                    route('manage.competition.deleteMedia', {
                      type: 'attachment',
                      competition_id: competition.id,
                      media_id: file.id,
                    })
                  "
                  method="post"
                  as="button"
                  type="button"
                  class="float-right text-red-500"
                >
                  <svg
                    focusable="false"
                    class=""
                    data-icon="delete"
                    width="1em"
                    height="1em"
                    fill="currentColor"
                    aria-hidden="true"
                    viewBox="64 64 896 896"
                  >
                    <path
                      d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z"
                    ></path>
                  </svg>
                </inertia-link>

                <div v-if="file.mime_type.includes('image')">
                  <img :src="file.preview_url" />
                </div>
                <div v-else>
                  <a :href="file.original_url" target="_blank">{{ file.file_name }}</a>
                </div>
              </div>
            </div>
            <div>
              <a-upload
                v-model:file-list="competitionData.attachment"
                :multiple="true"
                :beforeUpload="beforeAttachmentUpload"
                :max-count="5"
                :accept="uploadValidator.attachment.format.toString()"
                list-type="picture"
              >
                <a-button>
                  <upload-outlined></upload-outlined>
                  {{ $t("upload_file") }}
                </a-button>
              </a-upload>
            </div>
          </a-form-item>

          <a-form-item :label="$t('application_fee')" name="fee">
            <a-input v-model:value="competitionData.fee" style="width: 100px" />
          </a-form-item>

          <a-form-item :label="$t('published')" name="published">
            <a-switch
              v-model:checked="competitionData.published"
              :checkedValue="1"
              :unCheckedValue="0"
            />
          </a-form-item>

          <a-form-item :label="$t('scope')" name="scope">
            <a-radio-group v-model:value="competitionData.scope" button-style="solid">
              <a-radio-button value="PUB">{{ $t("public") }}</a-radio-button>
              <a-radio-button value="MJA">MJA {{ $t("members") }}</a-radio-button>
              <a-radio-button value="ORG">{{
                $t("organization_member_only")
              }}</a-radio-button>
            </a-radio-group>
          </a-form-item>

          <div class="flex flex-row item-center justify-center">
            <a-button type="primary" html-type="submit">{{ $t("submit") }}</a-button>
          </div>
        </a-form>
      </div>
    </div>
  </OrganizationLayout>
</template>

<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { quillEditor } from "vue3-quill";
import dayjs from "dayjs";
import { UploadOutlined } from "@ant-design/icons-vue";
import { message, Upload } from "ant-design-vue";

export default {
  components: {
    OrganizationLayout,
    quillEditor,
    dayjs,
    UploadOutlined,
  },
  props: [
    "competition",
    "medias",
    "categories_weights",
    "roles",
    "staff_options",
    "referee_options",
  ],
  data() {
    return {
      mode: null,
      showWeightList: false,
      dateFormat: "YYYY-MM-DD",
      dateList: ["2023-01-02"],
      competitionData: {},
      uploadValidator: {
        banner: {
          size: 2, //Magabyte
          format: ["image/jpeg", "image/png"],
        },
        attachment: {
          size: 1, //Magabyte
          format: [
            "image/jpeg",
            "image/png",
            "application/pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ".doc",
            ".docx",
            ".xls",
            ".xlsx",
          ],
        },
      },
      rules: {
        title_zh: { required: true },
        period: { required: true },
        match_date: { required: true },
        roleSelected: { required: true },
        cwSelected: { required: true },
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
  mounted() {},
  created() {
    if (this.competition == null) {
      this.mode = "CREATE";
      this.competitionData.roleSelected = [];
    } else {
      this.mode = "EDIT";
      this.competitionData = { ...this.competition };
      this.competitionData.period = [];
      this.competitionData.period[0] = dayjs(this.competition.start_date);
      this.competitionData.period[1] = dayjs(this.competition.end_date);
      this.competitionData.cwSelected = this.competition.categories_weights.map(
        (cw) => cw.code
      );
      this.competitionData.roleSelected = this.competition.roles.map((cw) => cw.value);
      this.competitionData.staffOptionsSelected = this.competition.staff_options?.map(
        (so) => so.value
      );
      this.competitionData.refereeOptionsSelected = this.competition.referee_options?.map(
        (ro) => ro.value
      );
      this.getDaysArray(this.competitionData.period[0], this.competitionData.period[1]);
      // this.competition.period[1] = this.competitionSource.end_date
    }
  },
  methods: {
    onCompetitionPeriodChange() {
      //var days = (this.competition.period[1]-this.competition.period[0])/(1000*60*60*24)+1
      //var getDaysArray = function(s,e) {for(var a=[],d=new Date(s);d<=new Date(e);d.setDate(d.getDate()+1)){ a.push(new Date(d));}return a;};
      this.competitionData.match_dates = [];
      this.getDaysArray(this.competitionData.period[0], this.competitionData.period[1]);
    },
    getDaysArray(start, end) {
      for (
        var arr = [], dt = new Date(start);
        dt <= new Date(end);
        dt.setDate(dt.getDate() + 1)
      ) {
        //arr.push(new Date(dt));
        arr.push(dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate());
      }
      this.dateList = arr;
    },
    beforeBannerUpload(file) {
      var isOverSize = file.size / 1024 / 1024 > this.uploadValidator.banner.size;
      var isFormatInvalid = !this.uploadValidator.banner.format.includes(file.type);

      if (isOverSize || isFormatInvalid) {
        message.error({
          content: () =>
            "檔案格式不符或大小超過限制. The file format does not match or the size exceeds the limit.",
          class: "custom-class",
          style: {
            marginTop: "50vh",
          },
        });
        return false || Upload.LIST_IGNORE;
      }
    },
    beforeAttachmentUpload(file) {
      var isOverSize = file.size / 1024 / 1024 > this.uploadValidator.attachment.size;
      var isFormatInvalid = !this.uploadValidator.attachment.format.includes(file.type);

      if (isOverSize || isFormatInvalid) {
        message.error({
          content: () =>
            "檔案格式不符或大小超過限制. The file format does not match or the size exceeds the limit.",
          class: "custom-class",
          style: {
            marginTop: "50vh",
          },
        });
        return false || Upload.LIST_IGNORE;
      }
    },
    onFinish() {
      console.log(this.competitionData);
      this.competitionData.categories_weights = this.categories_weights.filter((cw) =>
        this.competitionData.cwSelected.includes(cw.code)
      );
      this.competitionData.roles = this.roles.filter((rs) =>
        this.competitionData.roleSelected.includes(rs.value)
      );
      this.competitionData.start_date = this.competitionData.period[0].format(
        "YYYY-MM-DD"
      );
      this.competitionData.end_date = this.competitionData.period[1].format("YYYY-MM-DD");
      if (this.mode == "CREATE") {
        console.log(this.competitionData);
        this.$inertia.post(route("manage.competitions.store"), this.competitionData, {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (err) => {
            console.log(err);
          },
        });
      } else {
        console.log(this.competitionData);
        this.competitionData._method = "PATCH";
        this.$inertia.post(
          route("manage.competitions.update", this.competitionData.id),
          this.competitionData,
          {
            onSuccess: (page) => {
              console.log(page);
            },
            onError: (err) => {
              console.log(err);
            },
          }
        );
      }
    },
  },
};
</script>
