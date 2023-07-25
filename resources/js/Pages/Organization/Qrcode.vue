<template>
    <OrganizationLayout title="Dashboard" >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Qrcode Scanner
            </h2>
        </template>
        <qrcode-stream></qrcode-stream>
        <qrcode-drop-zone></qrcode-drop-zone>
        <qrcode-capture></qrcode-capture>
    </OrganizationLayout>
</template>

<script>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'qrcode-reader-vue3'

export default {
    components: {
        OrganizationLayout,
        QrcodeStream,
        QrcodeDropZone,
        QrcodeCapture
    },
    props: [],
    data() {
        return {

        }
    },
    methods: {

    },
}
</script>