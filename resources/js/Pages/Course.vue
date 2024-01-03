<script>
import WebLayout from '@/Layouts/WebLayout.vue';

export default {
    components: {
        WebLayout,
    },
    props:['course'],
    data() {
        return{
        }
    }
}
</script>

<template>
    <WebLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
      
        <div class="flex flex-wrap gap-4 mb-6">
            {{ course }}
        </div>
    </WebLayout>
</template>

<style >
.ql-align-right {
	text-align: right;
}
.ql-align-center {
	text-align: center;
}
.ql-align-left {
	text-align: left;
}
</style>