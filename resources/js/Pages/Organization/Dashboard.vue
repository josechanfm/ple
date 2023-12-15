<template>
    <OrganizationLayout title="Dashboard" >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Management Dashboard
                
            </h2>
        </template>
        <div v-if="member">
            <inertia-link :href="route('member.dashboard')">Member Dashboard</inertia-link>
        </div>
    </OrganizationLayout>
</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import OrganizationList from '@/Components/Organization/OrganizationList.vue';

export default {
    components: {
        OrganizationLayout,
        OrganizationList,
    },
    props: ['organizations','member'],
    data() {
        return {

        }
    },
    methods: {

    },
}
</script>