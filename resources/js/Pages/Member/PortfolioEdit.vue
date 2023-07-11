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
                    <a-form ref="modalRef" name="From" autocomplete="off" :rules="rules"
                        :validate-messages="validateMessages" layout="vertical">

                        <a-collapse v-model:activeKey="activeKey">

                            <a-collapse-panel key="1" header="International name with A-Z characters">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item label="Family Name" name="family_name">
                                            <a-input v-model:value="portfolio.family_name" />
                                        </a-form-item>
                                        <a-form-item label="Middle Name" name="middle_name">
                                            <a-input v-model:value="portfolio.middle_name" />
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item label="Given Name" name="given_name">
                                            <a-input v-model:value="portfolio.given_name" />
                                        </a-form-item>
                                        <a-form-item label="Display Name" name="display_name">
                                            <a-input v-model:value="portfolio.display_name" />
                                        </a-form-item>
                                    </a-col>
                                </a-row>

                            </a-collapse-panel>
                            <a-collapse-panel key="2" header="Personal Data">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item label="Date of birth" name="dob">
                                            <a-input v-model:value="portfolio.dob" />
                                        </a-form-item>
                                        <a-form-item label="Country" name="title">
                                            <a-input v-model:value="portfolio.country" />
                                        </a-form-item>
                                        <a-form-item label="Stree" name="stree">
                                            <a-input v-model:value="portfolio.stree" />
                                        </a-form-item>
                                        <a-form-item label="ZIP" name="zip">
                                            <a-input v-model:value="portfolio.zip" />
                                        </a-form-item>
                                        <a-form-item label="E-mail" name="email">
                                            <a-input v-model:value="portfolio.email" />
                                        </a-form-item>
                                        <a-form-item label="Date of Death" name="dod">
                                            <a-input v-model:value="portfolio.dod" />
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item label="Gender" name="gender">
                                            <a-input v-model:value="portfolio.gender" />
                                        </a-form-item>
                                        <a-form-item label="Club" name="club">
                                            <a-input v-model:value="portfolio.club" />
                                        </a-form-item>
                                        <a-form-item label="City" name="city">
                                            <a-input v-model:value="portfolio.city" />
                                        </a-form-item>
                                        <a-form-item label="VAT ID" name="vat">
                                            <a-input v-model:value="portfolio.vat" />
                                        </a-form-item>
                                        <a-form-item label="Mobile Phone" name="mobile">
                                            <a-input v-model:value="portfolio.mobile" />
                                        </a-form-item>
                                    </a-col>
                                </a-row>
                            </a-collapse-panel>
                            <a-collapse-panel key="3" header="Role">
                                <a-checkbox-group v-model:value="portfolio.roles">
                                    <a-checkbox :style="radioVirticalStyle" value="ATH">Compettitor</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="REF">Referee</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="COA">Coach</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="OFF">Official</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="GUE">Guest <a-typography-text
                                            type="secondary"> (VIP, VVIP, Media etc.)</a-typography-text></a-checkbox>
                                </a-checkbox-group>
                            </a-collapse-panel>
                            <a-collapse-panel key="4" header="Competitor" v-if="portfolio.roles.includes('ATH')">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item label="Coach" name="coach">
                                            <a-input v-model:value="portfolio.athlete.coach" />
                                        </a-form-item>
                                        <a-form-item label="Favourite technique" name="technique">
                                            <a-input v-model:value="portfolio.athlete.technique" />
                                        </a-form-item>
                                        <a-form-item label="Side" name="side">
                                            <a-input v-model:value="portfolio.athlete.site" />
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item label="Belt" name="belt">
                                            <a-input v-model:value="portfolio.athlete.belt" />
                                        </a-form-item>
                                        <a-form-item label="Height" name="height">
                                            <a-input v-model:value="portfolio.athlete.height" />
                                        </a-form-item>
                                        <a-form-item label="Weight" name="weight">
                                            <a-input v-model:value="portfolio.athlete.weight" />
                                        </a-form-item>
                                    </a-col>
                                </a-row>

                            </a-collapse-panel>
                            <a-collapse-panel key="5" header="Referee" v-if="portfolio.roles.includes('REF')">
                                <a-checkbox-group v-model:value="portfolio.roles">
                                    <a-checkbox :style="radioVirticalStyle" value="INT">International referee</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="CON">Continental referee</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="NAT">National referee</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="KAT">Kata referee</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="COM">Commission member</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="ASS">Assessor</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="SUP">Supervisor</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="IBSA">IBSA referee</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="HIR">Honorary international referee</a-checkbox>
                                    <a-checkbox :style="radioVirticalStyle" value="HCR">Nonorary continental referee</a-checkbox>
                                </a-checkbox-group>
                            </a-collapse-panel>
                            <a-collapse-panel key="6" header="Coach" v-if="portfolio.roles.includes('COA')">
                                Coach
                            </a-collapse-panel>
                            <a-collapse-panel key="7" header="Official" v-if="portfolio.roles.includes('OFF')">
                                <a-row :gutter="24" :span="24">
                                    <a-col :span="12">
                                        <a-form-item label="Federation function" name="federation">
                                            <a-checkbox-group v-model:value="portfolio.roles">
                                                <a-checkbox :style="radioVirticalStyle" value="INT">President</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Vice president</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">General secretary</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Treasurer</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Contact person for IJF</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Technical director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Member of NOC</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Referee Commision Director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Media Director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">IT Director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Team Doctor</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Team Physiotherapist</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Youth Commissioner</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Kata Commissioner</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Mass Sports Commissioner</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Veterans contact</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Legal Affairs Commissioner</a-checkbox>
                                            </a-checkbox-group>
                                        </a-form-item>
                                    </a-col>
                                    <a-col :span="12">
                                        <a-form-item label="Federation function" name="federation">
                                            <a-checkbox-group v-model:value="portfolio.roles">
                                                <a-checkbox :style="radioVirticalStyle" value="">President</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Vice President</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">General secrtetary</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Treasurer</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Contact person for IJF</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Technical director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Member of NOC</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Referee Commision Director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Media Director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">IT Director</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Team Doctor</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Team Physiotherapist</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Youth Commissioner</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Kata Commissioner</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Mass Sports Commissioner</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Veterans contact</a-checkbox>
                                                <a-checkbox :style="radioVirticalStyle" value="">Legal Affairs Commissioner</a-checkbox>
                                            </a-checkbox-group>
                                        </a-form-item>
                                    </a-col>
                                </a-row>
                            </a-collapse-panel>
                            <a-collapse-panel key="8" header="Guest" v-if="portfolio.roles.includes('GUE')">
                                888
                            </a-collapse-panel>
                            <a-collapse-panel key="8" header="Profile Picture" v-if="!portfolio.roles.includes('OFF') && portfolio.roles.length>0">
                                <a-upload v-model:file-list="portfolio.athlete.avator" name="avatar"
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
    props: ['member', 'approbates', 'portfolio'],
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
            radioVirticalStyle: {
                display: 'flex',
                height: '30px',
                lineHeight: '30px',
            },
        }
    },
    created() {
        this.portfolio.roles = []
        this.portfolio.athlete = []
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
        handleChange(info){
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
    },
}
</script>
