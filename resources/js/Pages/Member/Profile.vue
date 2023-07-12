<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard..
            </h2>
        </template>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <a-form ref="formRef" name="Form" autocomplete="off" 
                        v-bind="layout"
                        :model="member"
                        layout="vertical" 
                        :rules="rules"
                        :validate-messages="validateMessages" 
                        @finish="onFinish">

                        <a-collapse v-model:activeKey="activeKey">

                            <a-collapse-panel key="1" :header="$t('profile_title')">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item :label="$t('family_name')" name="family_name">
                                            <a-input v-model:value="member.family_name" />
                                        </a-form-item>
                                        <a-form-item :label="$t('middle_name')" name="middle_name">
                                            <a-input v-model:value="member.middle_name" />
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item :label="$t('given_name')" name="given_name">
                                            <a-input v-model:value="member.given_name" />
                                        </a-form-item>
                                        <a-form-item :label="$t('display_name')" name="display_name">
                                            <a-input v-model:value="member.display_name" />
                                        </a-form-item>
                                    </a-col>
                                </a-row>
                            </a-collapse-panel>
                            <a-collapse-panel key="2" :header="$t('personal_title')">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item :label="$t('dob')" name="dob">
                                            <a-input v-model:value="member.dob" />
                                        </a-form-item>
                                        <a-form-item :label="$t('country')" name="title">
                                            <a-input v-model:value="member.country" />
                                        </a-form-item>
                                        <a-form-item :label="$t('street')" name="street">
                                            <a-input v-model:value="member.street" />
                                        </a-form-item>
                                        <a-form-item :label="$t('zip')" name="zip">
                                            <a-input v-model:value="member.zip" />
                                        </a-form-item>
                                        <a-form-item :label="$t('email')" name="email">
                                            <a-input v-model:value="member.email" />
                                        </a-form-item>
                                        <a-form-item :label="$t('dod')" name="dod">
                                            <a-input v-model:value="member.dod" />
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item :label="$t('gender')" name="gender">
                                            <a-input v-model:value="member.gender" />
                                        </a-form-item>
                                        <a-form-item :label="$t('club')" name="club">
                                            <a-input v-model:value="member.club" />
                                        </a-form-item>
                                        <a-form-item :label="$t('city')" name="city">
                                            <a-input v-model:value="member.city" />
                                        </a-form-item>
                                        <a-form-item :label="$t('vat')" name="vat">
                                            <a-input v-model:value="member.vat" />
                                        </a-form-item>
                                        <a-form-item :label="$t('mobile')" name="mobile">
                                            <a-input v-model:value="member.mobile" />
                                        </a-form-item>
                                    </a-col>
                                </a-row>
                            </a-collapse-panel>
                            <a-collapse-panel key="3" :header="$t('position_title')">
                                <a-checkbox-group v-model:value="member.positions">
                                    <a-checkbox :style="virticalStyle" value="ATH">Compettitor</a-checkbox>
                                    <a-checkbox :style="virticalStyle" value="REF">Referee</a-checkbox>
                                    <a-checkbox :style="virticalStyle" value="COA">Coach</a-checkbox>
                                    <a-checkbox :style="virticalStyle" value="OFF">Official</a-checkbox>
                                    <a-checkbox :style="virticalStyle" value="GUE">Guest <a-typography-text
                                            type="secondary"> (VIP, VVIP, Media etc.)</a-typography-text></a-checkbox>
                                </a-checkbox-group>
                            </a-collapse-panel>
                            <a-collapse-panel key="4" :header="$t('athlete_title')" v-if="member.positions.includes('ATH')">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item label="Coach" name="coach">
                                            <a-input v-model:value="member.athlete.coach" />
                                        </a-form-item>
                                        <a-form-item label="Favourite technique" name="technique">
                                            <a-input v-model:value="member.athlete.technique" />
                                        </a-form-item>
                                        <a-form-item label="Side" name="side">
                                            <a-input v-model:value="member.athlete.site" />
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item label="Belt" name="belt">
                                            <a-input v-model:value="member.athlete.belt" />
                                        </a-form-item>
                                        <a-form-item label="Height" name="height">
                                            <a-input v-model:value="member.athlete.height" />
                                        </a-form-item>
                                        <a-form-item label="Weight" name="weight">
                                            <a-input v-model:value="member.athlete.weight" />
                                        </a-form-item>
                                    </a-col>
                                </a-row>

                            </a-collapse-panel>
                            <a-collapse-panel key="5" header="Referee" v-if="member.positions.includes('REF')">
                                <a-checkbox-group v-model:value="profile.roles">
                                    <a-checkbox v-for="position in positions.filter(p=>p.scope=='REFEREE')" :style="virticalStyle" :value="position.code">{{ position.title_en }}</a-checkbox>
                                </a-checkbox-group>
                            </a-collapse-panel>
                            <a-collapse-panel key="6" header="Coach" v-if="profile.roles.includes('COA')">
                                Coach
                            </a-collapse-panel>
                            <a-collapse-panel key="7" header="Official" v-if="profile.roles.includes('OFF')">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item label="Federation function" name="federation">
                                            <a-checkbox-group v-model:value="profile.roles">
                                                <a-checkbox :style="virticalStyle" value="INT">President</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Vice president</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">General secretary</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Treasurer</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Contact person for
                                                    IJF</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Technical director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Member of NOC</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Referee Commision
                                                    Director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Media Director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">IT Director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Team Doctor</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Team
                                                    Physiotherapist</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Youth Commissioner</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Kata Commissioner</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Mass Sports
                                                    Commissioner</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Veterans contact</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Legal Affairs
                                                    Commissioner</a-checkbox>
                                            </a-checkbox-group>
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item label="Federation function" name="federation">
                                            <a-checkbox-group v-model:value="profile.roles">
                                                <a-checkbox :style="virticalStyle" value="">President</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Vice President</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">General secrtetary</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Treasurer</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Contact person for
                                                    IJF</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Technical director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Member of NOC</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Referee Commision
                                                    Director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Media Director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">IT Director</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Team Doctor</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Team
                                                    Physiotherapist</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Youth Commissioner</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Kata Commissioner</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Mass Sports
                                                    Commissioner</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Veterans contact</a-checkbox>
                                                <a-checkbox :style="virticalStyle" value="">Legal Affairs
                                                    Commissioner</a-checkbox>
                                            </a-checkbox-group>
                                        </a-form-item>
                                    </a-col>
                                </a-row>
                            </a-collapse-panel>
                            <a-collapse-panel key="8" header="Guest" v-if="profile.roles.includes('GUE')">
                                888
                            </a-collapse-panel>
                            <a-collapse-panel key="8" header="Profile Picture"
                                v-if="!profile.roles.includes('OFF') && profile.roles.length > 0">
                                <a-upload v-model:file-list="member.athlete.avator" name="avatar"
                                    list-type="picture-card" class="avatar-uploader" :show-upload-list="false"
                                    action="https://www.mocky.io/v2/5cc8019d300000980a055e76" :before-upload="beforeUpload"
                                    @change="handleChange">
                                    <img v-if="imageUrl" :src="imageUrl" alt="avatar" />
                                    <div v-else>
                                        <loading-outlined v-if="loading"></loading-outlined>
                                        <plus-outlined v-else></plus-outlined>
                                        <div class="ant-upload-text">Upload</div>
                                    </div>
                                </a-upload>
                            </a-collapse-panel>
                        </a-collapse>

                        <a-form-item :wrapper-col="{ ...layout.wrapperCol, offset: 8 }">
                            <a-button type="primary" html-type="submit">Submit</a-button>
                        </a-form-item>

                    </a-form>

                </div>
            </div>
        </div>


    </MemberLayout>
</template>


<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { PlusOutlined, LoadingOutlined } from '@ant-design/icons-vue';
import { message } from 'ant-design-vue';

import { quillEditor } from 'vue3-quill';

export default {
    components: {
        MemberLayout,
        PlusOutlined,
        LoadingOutlined,
        quillEditor
    },
    props: ['member', 'approbates', 'profile','positions'],
    data() {
        return {
            activeKey: ['1'],
            loading: false,
            imageUrl: '',
            modal: {
                isOpen: false,
                data: {},
                title: "Modal",
                mode: ""
            },
            rules: {
                field: { required: true },
                label: { required: true },
            },
            validateMessages: {
                required: '${label} is required!',
                types: {
                    email: '${label} is not a valid email!',
                    number: '${label} is not a valid number!',
                },
                number: {
                    range: '${label} must be between ${min} and ${max}',
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
                display: 'flex',
                height: '30px',
                lineHeight: '30px',
                marginLeft: "8px",
            },
        }
    },
    created() {
        this.profile.roles = []
        this.member.athlete = []
    },
    methods: {
        createRecord(record) {
            this.modal.data = {};
            // this.modal.data.organization_id=this.organization.id;
            // this.modal.data.require_login=false;
            // this.modal.data.for_member=false;
            // this.modal.data.published=false;
            // this.modal.data.media=[];
            this.modal.mode = "CREATE";
            this.modal.isOpen = true;
        },
        editRecord(record) {
            console.log(record);
            this.modal.data = { ...record };
            this.modal.mode = "EDIT";
            this.modal.isOpen = true;
        },
        storeRecord() {
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(() => {
                this.$inertia.post(route('member.portfolios.store'), this.modal.data, {
                    onSuccess: (page) => {
                        this.modal.isOpen = false;
                    },
                    onError: (err) => {
                        console.log(err);
                    }
                });
            }).catch(err => {
                console.log(err);
            });
        },
        updateRecord() {
            console.log(this.modal.data);
            this.$refs.modalRef.validateFields().then(() => {
                this.modal.data._method = 'PATCH';
                this.$inertia.post(route('member.porfolios.update', this.modal.data.id), this.modal.data, {
                    onSuccess: (page) => {
                        this.modal.isOpen = false;
                        console.log(page);
                    },
                    onError: (error) => {
                        console.log(error);
                    }
                });
            }).catch(err => {
                console.log("error", err);
            });
        },

        deleteRecord(record) {
            if (!confirm('Are you sure want to remove?')) return;
            this.$inertia.delete(route('member.porfolios.destroy', { form: record.id }), {
                onSuccess: (page) => {
                    console.log(page);
                },
                onError: (error) => {
                    alert(error.message);
                }

            });
        },
        handleChange(info) {
            if (info.file.status === 'uploading') {
                this.loading = true;
                return;
            }
            if (info.file.status === 'done') {
                // Get this url from response in real world.
                getBase64(info.file.originFileObj, base64Url => {
                    this.imageUrl = base64Url;
                    this.loading = false;
                });
            }
            if (info.file.status === 'error') {
                this.loading = false;
                message.error('upload error');
            }
        },
        beforeUpload(file) {
            const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
            if (!isJpgOrPng) {
                message.error('You can only upload JPG file!');
            }
            const isLt2M = file.size / 1024 / 1024 < 2;
            if (!isLt2M) {
                message.error('Image must smaller than 2MB!');
            }
            return isJpgOrPng && isLt2M;
        },
        onFinish() {
            console.log(this.member);
        }
    },
}
</script>
