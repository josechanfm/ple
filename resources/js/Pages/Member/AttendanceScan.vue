<template>
    <MemberLayout title="Dashboard" >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Qrcode Scanner
            </h2>
        </template>
        <qrcode-stream @decode="onDecode" @init="onInit">
            <div style="color: red;" class="frame"></div>
        </qrcode-stream>
        <qrcode-drop-zone></qrcode-drop-zone>
        <qrcode-capture></qrcode-capture>

        <p class="error">{{ error }}</p>
        <p class="decode-result">Last result: <b>{{ result }}</b></p>
        <a-input v-model:value="search" />
        <a-button @click="onSearch">Search</a-button>
    </MemberLayout>
</template>

<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'qrcode-reader-vue3';

export default {
    components: {
        MemberLayout,
        QrcodeStream,
        QrcodeDropZone,
        QrcodeCapture
    },
    props: ['event'],
    data() {
        return {
            search:'',
            error:'',
            result:'',
        }
    },
    methods: {
        onSearch(){
            this.onDecode(this.search)
            // const data={event_id:this.event.id,scan:this.search.split(',')}
            // axios.get(route('member.attendance.getMember',data)).then(response=>{
            //     console.log(response.data);      
            // })
        },
        onDecode (result) {
            this.result=result
            console.log
            // const data={event_id:this.event.id,scan:result.split(',')}
            // axios.get(route('member.attendance.getMember',data)).then(response=>{
            //     if(response.data.result){
            //         this.result = response.data.member.given_name
            //     }else{
            //         this.result = response.data.message
            //     }
            // })
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