<script>
import WebLayout from '@/Layouts/WebLayout.vue';

import { reactive } from 'vue';

export default {
    components: {
        WebLayout
    },
    props: ['organizations'],
    data() {
        return {
            formState: {
                username: '',
                password: '',
            }
        }
    },
    methods: {
        onFinish(values) {
            console.log('Success:', values);
            this.$inertia.post(route('registration.store'), this.formState, {
                onSuccess: (page) => {
                    console.log(page);
                    //this.modal.isOpen = false;
                },
                onError: (err) => {
                    console.log(err);
                }
            });

        },
        onFinishFailed(errorInfo) {
            console.log('Failed:', errorInfo);
        }
    }
}

</script>

<template>
    <WebLayout title="Dashboard">
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <a-typography-title :level="3">Registration Form</a-typography-title>
            <div class="w-full max-w-lg mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"><!--v-if-->
                <a-form :model="formState" name="basic" layout="vertical" autocomplete="off" @finish="onFinish"
                    @finishFailed="onFinishFailed">
                    <a-form-item label="Given name" name="given_name"
                        :rules="[{ required: true, message: 'Please input your given name!' }]">
                        <a-input v-model:value="formState.given_name" />
                    </a-form-item>
                    <a-form-item label="Middle name" name="middle_name">
                        <a-input v-model:value="formState.middle_name" />
                    </a-form-item>
                    <a-form-item label="Family name" name="family_name"
                        :rules="[{ required: true, message: 'Please input your family_name!' }]">
                        <a-input v-model:value="formState.family_name" />
                    </a-form-item>
                    <a-form-item label="Organization" name="organization_id"
                        :rules="[{ required: true, message: 'Please input your organization belongs to!' }]">
                        <a-select v-model:value="formState.organization_id" :options="organizations"
                            :fieldNames="{ value: 'id', label: 'full_name' }" />
                    </a-form-item>
                    <a-form-item label="Registration Code" name="registration_code"
                        :rules="[{ required: true, message: 'Please input the organization registration' }]">
                        <a-input v-model:value="formState.registration_code" />
                    </a-form-item>
                    <a-form-item label="Email (for login)" name="email"
                        :rules="[{ required: true, message: 'Please input your email!' }]">
                        <a-input v-model:value="formState.email" type="email" />
                    </a-form-item>
                    <a-form-item label="Password" name="password"
                        :rules="[{ required: true, message: 'Please input your password!' }]">
                        <a-input-password v-model:value="formState.password" />
                    </a-form-item>

                    <a-form-item :wrapper-col="{ offset: 8, span: 16 }">
                        <a-button type="primary" html-type="submit">Submit</a-button>
                    </a-form-item>
                </a-form>
            </div>
        </div>
    </WebLayout>
</template>

