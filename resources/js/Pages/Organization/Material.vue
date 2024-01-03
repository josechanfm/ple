<template>
    <OrganizationLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t("material") }}
            </h2>
        </template>
        <div v-if="material.id">
            On Edit
        </div>
        <div v-else>
            On Create
        </div>

        <div class="container mx-auto pt-5">
            <div class="bg-white relative shadow rounded-lg overflow-x-auto">
                <a-form 
                    ref="modalRef" 
                    :model="material" 
                    name="Lecture" 
                    :label-col="{ span: 8 }"
                    :wrapper-col="{ span: 16 }" 
                    autocomplete="off" 
                    :rules="rules" 
                    :validate-messages="validateMessages"
                    enctype="multipart/form-data" 
                    @finish="onFinish"
                >
                    <a-form-item :label="$t('material_title')" name="title">
                        <a-input v-model:value="material.title" />
                    </a-form-item>
                    <a-form-item :label="$t('brief')" name="brief">
                        <a-input v-model:value="material.brief" />
                    </a-form-item>
                    <a-form-item :label="$t('description')" name="description">
                        <a-input v-model:value="material.description" />
                    </a-form-item>
                    <div class="flex flex-row item-center justify-center">
                        <a-button type="primary" html-type="submit">{{$t('submit')}}</a-button>
                    </div>

                </a-form>

            </div>
        </div>

    </OrganizationLayout>
</template>
  
<script>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import {
    UploadOutlined,
    LoadingOutlined,
    PlusOutlined,
    InfoCircleFilled,
} from "@ant-design/icons-vue";
import { defineComponent, reactive } from "vue";
import CropperModal from "@/Components/Member/CropperModal.vue";

export default {
    components: {
        OrganizationLayout,
        UploadOutlined,
        LoadingOutlined,
        PlusOutlined,
        InfoCircleFilled,
        CropperModal,
    },
    props: ["course", "material"],
    data() {
        return {
            rules: {
                title: { required: true },
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
    created() { },
    methods: {
        onFinish() {
            if(this.material.id===undefined){
                this.$inertia.post(route('manage.course.materials.store'), this.material,{
                    onSuccess:(page)=>{
                        console.log(page);
                    },
                    onError:(err)=>{
                        console.log(err);
                    }
                });
            }else{
                this.$inertia.patch(route('manage.course.materials.update',{course: this.material.course_id,material:this.material.id}), this.material,{
                    onSuccess:(page)=>{
                        console.log(page);
                    },
                    onError:(err)=>{
                        console.log(err);
                    }
                });

            }
        },

    },
};
</script>
  