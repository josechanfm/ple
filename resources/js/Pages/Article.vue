<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import CertificateCard from '@/Pages/CertificateCard.vue';

export default {
    components: {
        MemberLayout,
        CertificateCard
    },
    props:['article'],
    data() {
        return{
        }
    }
}

</script>

<template>
    <MemberLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-gray-800">{{ article.title_en}}</h2>
            <div v-html="article.content_en"/>
        </div>
        
    </MemberLayout>

    
</template>

