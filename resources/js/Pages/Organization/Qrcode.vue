<template>
    <OrganizationLayout title="Dashboard" >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Qrcode Scanner
            </h2>
        </template>
        <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream>
        <qrcode-drop-zone></qrcode-drop-zone>
        <qrcode-capture></qrcode-capture>

        <p class="error">{{ error }}</p>
        <p class="decode-result">Last result: <b>{{ result }}</b></p>

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
        onDecode (result) {
        this.result = result
        },

        async onInit (promise) {
            try {
                await promise
            } catch (error) {
                if (error.name === 'NotAllowedError') {
                this.error = "ERROR: you need to grant camera access permisson"
                } else if (error.name === 'NotFoundError') {
                this.error = "ERROR: no camera on this device"
                } else if (error.name === 'NotSupportedError') {
                this.error = "ERROR: secure context required (HTTPS, localhost)"
                } else if (error.name === 'NotReadableError') {
                this.error = "ERROR: is the camera already in use?"
                } else if (error.name === 'OverconstrainedError') {
                this.error = "ERROR: installed cameras are not suitable"
                } else if (error.name === 'StreamApiNotSupportedError') {
                this.error = "ERROR: Stream API is not supported in this browser"
                }
            }
        }
    },
}
</script>