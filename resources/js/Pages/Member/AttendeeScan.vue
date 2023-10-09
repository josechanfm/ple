<template>
    <MemberLayout title="Dashboard" >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{event.title_en}}
            </h2>
        </template>
        <div class="p-3">
            <a-radio-group v-model:value="status" button-style="solid">
              <template v-for="status in attendance_status">
                    <a-radio-button :value="status.value">{{ status.label }}</a-radio-button>
                </template>
            </a-radio-group>
            <a href="#" onclick="history.back();return false;" class="ant-btn float-right">{{$t('go_back')}}</a>
            <div class="error">{{ error }}</div>
            <div class="decode-result pt-2">{{$t('result')}}: <b>{{ result }}</b></div>
        </div>

        <qrcode-stream @detect="onDetect" @error="onError" class="px-3 h-3">
            <div style="color: red;" class="frame"></div>
        </qrcode-stream>
        <qrcode-drop-zone></qrcode-drop-zone>

    </MemberLayout>
</template>

<script>
import MemberLayout from '@/Layouts/MemberLayout.vue';
import { ConsoleSqlOutlined } from '@ant-design/icons-vue';
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from 'vue-qrcode-reader'

export default {
    components: {
        MemberLayout,
        QrcodeStream,
        QrcodeDropZone,
        QrcodeCapture
    },
    props: ['event','attendance_status'],
    data() {
        return {
            status:'ATTEND',
            error:'',
            result:'',
        }
    },
    methods: {
        onDecode(result){
            console.log(result);
        },
        onDetect (result) {
            console.log(result);
            console.log(result[0].rawValue);
             const data={
                scan:result[0].rawValue.split(','),
                status:this.status
            }
             var beep = new  Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
             beep.play()
             axios.patch(route('member.attendees.store',{type:this.type,id:this.event.id}),data).then(resp=>{
                console.log(resp.data);
                if(resp.data){
                    this.result = resp.data.m.display_name
                }else{
                    this.result = resp.data.message
                }
            })
        },
        onError(error) {
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
        },
        
    },
}
</script>

<style scoped>
.error {
font-weight: bold;
color: red;
}
</style>

<style scoped>
  /* * {
    margin: 0;
    padding: 0;
  }
  body {
    height: 700px;
    margin: 0;
  } */

  .qr-scanner {
    background-image:
      linear-gradient(0deg,
        transparent 24%,
        rgba(32, 255, 77, 0.1) 25%,
        rgba(32, 255, 77, 0.1) 26%,
        transparent 27%,
        transparent 74%,
        rgba(32, 255, 77, 0.1) 75%,
        rgba(32, 255, 77, 0.1) 76%,
        transparent 77%,
        transparent),
      linear-gradient(90deg,
        transparent 24%,
        rgba(32, 255, 77, 0.1) 25%,
        rgba(32, 255, 77, 0.1) 26%,
        transparent 27%,
        transparent 74%,
        rgba(32, 255, 77, 0.1) 75%,
        rgba(32, 255, 77, 0.1) 76%,
        transparent 77%,
        transparent);
    background-size: 3rem 3rem;
    background-position: -1rem -1rem;
    width: 100%;
    /* height: 100%; */
    height: 100vh;
    position: relative;
    background-color: #1110;

    /* background-color: #111; */
  }

  .qr-scanner .box {
    width: 213px;
    height: 213px;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    overflow: hidden;
    border: 0.1rem solid rgba(0, 255, 51, 0.2);
    /* background: url('http://resource.beige.world/imgs/gongconghao.png') no-repeat center center; */
  }

  .qr-scanner .line {
    height: calc(100% - 2px);
    width: 100%;
    background: linear-gradient(180deg, rgba(0, 255, 51, 0) 43%, #00ff33 211%);
    border-bottom: 3px solid #00ff33;
    transform: translateY(-100%);
    animation: radar-beam 2s infinite alternate;
    animation-timing-function: cubic-bezier(0.53, 0, 0.43, 0.99);
    animation-delay: 1.4s;
  }

  .qr-scanner .box:after,
  .qr-scanner .box:before,
  .qr-scanner .angle:after,
  .qr-scanner .angle:before {
    content: '';
    display: block;
    position: absolute;
    width: 3vw;
    height: 3vw;

    border: 0.2rem solid transparent;
  }

  .qr-scanner .box:after,
  .qr-scanner .box:before {
    top: 0;
    border-top-color: #00ff33;
  }

  .qr-scanner .angle:after,
  .qr-scanner .angle:before {
    bottom: 0;
    border-bottom-color: #00ff33;
  }

  .qr-scanner .box:before,
  .qr-scanner .angle:before {
    left: 0;
    border-left-color: #00ff33;
  }

  .qr-scanner .box:after,
  .qr-scanner .angle:after {
    right: 0;
    border-right-color: #00ff33;
  }

  @keyframes radar-beam {
    0% {
      transform: translateY(-100%);
    }

    100% {
      transform: translateY(0);
    }
  }
</style>