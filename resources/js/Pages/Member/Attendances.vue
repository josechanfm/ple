<template>
  <MemberLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $t("Events") }}
      </h2>
    </template>
    <p></p>
    <a-collapse
      v-for="(instance, key) in instances"
      :expand-icon-position="expandIconPosition"
    >
      <template #expandIcon="{ isActive }">
        <CalendarOutlined v-if="key == 'events'" style="color: darkgreen" />
        <!-- <FormOutlined v-if="key=='forms'" style="color:blue"/> -->
        <!-- <CheckSquareOutlined v-if="key=='attendances'" style="color:darkred"/> -->
        <CaretRightOutlined :rotate="isActive ? 90 : 0" />
      </template>
      <a-collapse-panel v-for="record in instance" :key="key" :header="record.title_en">
        <p>{{ $t("title") }}: {{ record.title_en }}</p>
        <p>{{ $t("start_date") }}: {{ record.start_date }}</p>
        <p>{{ $t("end_date") }}: {{ record.end_date }}</p>
        <p>{{ $t("credit") }}: {{ record.credit }}</p>
        <div v-html="record.description" />
        <template #extra>
          <inertia-link
            :href="route('member.event.attendees.scan', record.id)"
            class="ant-btn"
          >
            {{ $t("scan") }}
          </inertia-link>
          <inertia-link
            :href="route('member.event.attendees.index', record.id)"
            class="ant-btn"
          >
            {{ $t("tick") }}
          </inertia-link>
        </template>
      </a-collapse-panel>
    </a-collapse>
  </MemberLayout>
</template>

<script>
import MemberLayout from "@/Layouts/MemberLayout.vue";
import {
  CalendarOutlined,
  FormOutlined,
  CheckSquareOutlined,
  CaretRightOutlined,
  SettingOutlined,
} from "@ant-design/icons-vue";

import { defineComponent, reactive } from "vue";

export default {
  components: {
    MemberLayout,
    CalendarOutlined,
    FormOutlined,
    CheckSquareOutlined,
    CaretRightOutlined,
    SettingOutlined,
  },
  props: ["instances", "members"],
  data() {
    return {
      expandIconPosition:"right",
      searchResult: [],
      selected: null,
      targetKeys: [],
      columns: [
        {
          title: "Category",
          i18n: "",
          dataIndex: "category",
        },
        {
          title: "Title",
          dataIndex: "title",
        },
        {
          title: "Credit",
          dataIndex: "credit",
        },
        {
          title: "Start date",
          dataIndex: "data_start",
        },
        {
          title: "End date",
          dataIndex: "date_end",
        },
        {
          title: "Operation",
          dataIndex: "operation",
          key: "operation",
        },
      ],
      rules: {
        name_zh: { required: true },
        mobile: { required: true },
        state: { required: true },
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
      labelCol: {
        style: {
          width: "150px",
        },
      },
    };
  },
  created() {
    //this.members.unshift({id:0,given_name:'Show all'})
    this.searchResult = this.members;
  },
  methods: {
    destroy(record) {
      if (confirm("Are you sure to delete the attendance record?"))
        this.$inertia.delete(
          route("member.event.attendances.destroy", {
            event: this.event.id,
            attendance: record.id,
          }),
          {
            onSuccess: (page) => {
              console.log(page);
            },
            onError: (error) => {
              alert(error.message);
            },
          }
        );
    },
    handleChange(keys, direction, moveKeys) {
      console.log(keys, direction, moveKeys);
    },
    onCheck() {
      console.log(this.targetKeys);
    },
    onChangeStatus(record) {
      this.$inertia.put(
        route("member.event.attendances.update", {
          event: this.event.id,
          attendance: record.id,
        }),
        record,
        {
          onSuccess: (page) => {
            console.log(page);
          },
          onError: (error) => {
            alert(error.message);
          },
        }
      );

      console.log(record);
    },
    handleChange(val) {
      console.log(val);
      this.selected = val;
    },
    handleSearch(val) {
      //this.members.
      console.log(val);
      if (val == "") {
        this.searchResult = this.members;
      } else {
        this.searchResult = this.members.filter((m) => m.given_name.includes(val));
      }
    },
    addAttendance() {
      const data = { member_id: this.selected, status: "ATT" };
      this.$inertia.post(route("member.event.attendances.store", this.event.id), data, {
        onSuccess: (page) => {
          console.log(page);
        },
        onError: (error) => {
          alert(error.message);
        },
      });
    },
  },
};
</script>
