<template>
<div>
 <div class="row">
   <div class="col-md-11 m-auto">
       <div class="card">
           <div class="card-header">
               <h3>Video Message</h3>
           </div>
           <form @submit="saveVideo" >
               <div class="card-body">
                    <div v-if="message.length">
                        <div v-for="text in message">
                            <p class="alert p-2" v-bind:class="{ 'alert-danger': hasError, 'alert-success' : hasSuccess }">
                                {{ text }}
                            </p>
                        </div>
                    </div>
                   <input type="file" @change="onvideoUpload" required class="form-control" accept="video/*">
               </div>
               <div class="card-footer">
                   <button class="btn btn sm btn-success float-right">{{ btnText }}</button>
               </div>
           </form>
       </div>
   </div>
 </div>
 <div class="row">
    <div class="col-md-11 m-auto" v-if="videos.length">
        <div v-for="video in videos">
            <div class="card h-50 float-left m-1 border  border-primary" style="width: 48%">
                <div class="card-header" style="height:50px">
                    <div class="row">
                        <div class="col-4" v-if="video.status == 1">
                            <span class="badge badge-success">Active</span>
                        </div>
                        <div class="col-4" v-else>

                        </div>
                        <div class="col-8">
                            <button class="btn btn-danger btn-sm float-right" @click="deleteVideo(video.id)">Delete</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="height: 400px;">
                    <video v-bind:src="base_url+video.body" controls width="100%" height="100%"></video>
                </div>
            </div>
        </div>
    </div>
 </div>
 </div>
</template>
<script>
export default {
    props: ['data'],
    data() {
        return {
            base_url: this.data,
            file: null,
            message: [],
            class: null,
            videos: [],
            hasError: false,
            hasSuccess:false,
            btnText: 'save',
        }
    },
    methods: {
        onvideoUpload(event){
            this.file = event.target.files[0];
        },
        saveVideo(e){
            this.btnText = 'Uploading';
            this.message = [];
            this.hasSuccess = false;
            this.hasError = false;
            e.preventDefault();
            const fd = new FormData();
            fd.append('video', this.file);
            axios.post('/save-video-message',fd).then((resp) => {
                if(resp.data.response == true)
                {
                    this.hasSuccess = true;
                    this.message = resp.data.message;
                    this.class = resp.data.class;
                    this.btnText = 'Uploaded';
                    axios.get('/show-video-message')
                    .then((resp) => {
                        this.videos = [];
                        this.videos = resp.data;
                    })
                }
                else{
                    this.hasError = true;
                    this.message = resp.data.message;
                    this.class = resp.data.class;
                    this.btnText = 'Try again';
                }
            })
        },
        deleteVideo(id) {
            this.message = [];
            this.hasSuccess = false;
            this.hasError = false;
            axios.get('/remove-video-message/'+id).then((resp) => {
                if(resp.data.response == true)
                {
                    this.hasSuccess = true;
                    this.message = resp.data.message;
                    this.class = resp.data.class;
                    axios.get('/show-video-message')
                    .then((resp) => {
                        this.videos = [];
                        this.videos = resp.data;
                    })
                }
                else{
                    this.hasError = true;
                    this.message = resp.data.message;
                    this.class = resp.data.class;
                }
            })
        }
    },
    created(){

        axios.get('/show-video-message')
            .then((resp) => {
                this.videos = resp.data;
            });
    }
}
</script>
