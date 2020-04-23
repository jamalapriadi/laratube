<template>
    <div class="row justify-content-center">
        <div class="col-md-8">

            <input type="file" multiple ref="videos" id="video-files" style="display:none" @change="upload">


            <div class="card p-3 d-flex justify-content-center align-items-center" v-if="!selected">
                <svg onclick="document.getElementById('video-files').click()" height="82pt" viewBox="0 -77 512.00213 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m501.453125 56.09375c-5.902344-21.933594-23.195313-39.222656-45.125-45.128906-40.066406-10.964844-200.332031-10.964844-200.332031-10.964844s-160.261719 0-200.328125 10.546875c-21.507813 5.902344-39.222657 23.617187-45.125 45.546875-10.542969 40.0625-10.542969 123.148438-10.542969 123.148438s0 83.503906 10.542969 123.148437c5.90625 21.929687 23.195312 39.222656 45.128906 45.128906 40.484375 10.964844 200.328125 10.964844 200.328125 10.964844s160.261719 0 200.328125-10.546875c21.933594-5.902344 39.222656-23.195312 45.128906-45.125 10.542969-40.066406 10.542969-123.148438 10.542969-123.148438s.421875-83.507812-10.546875-123.570312zm0 0" fill="#f00"/><path d="m204.96875 256 133.269531-76.757812-133.269531-76.757813zm0 0" fill="#fff"/></svg>
                
                <p class="text-center">Upload Videos</p>
            </div>

            <div class="card p-3" v-else>
                <div class="my-4" v-for="(video,idx) in videos" :key="'video'+idx">
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{width: `${video.percentage || progress[video.name]}%`}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            {{ video.percentage ?  video.percentage === 100 ? 'Video Processing Complete': 'Processing' : 'Uploading'}}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div v-if="!video.thumbnail" class="d-flex justify-content-center align-items-center" style="height:180px; color:white; font-size: 18px; background: #808080">
                                Loading thumbnail ...
                            </div>

                            <img v-else :src="video.thumbnail" style="width:100%">

                        </div>

                        <div class="col-md-4">
                            <a v-if="video.percentage && video.percentage === 100" :href="'/videos/'+video.id" target="_blank">
                                {{video.title}}
                            </a>  

                            <h4 v-else class="text-center">
                                {{ video.title || video.name }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            channels:{
                type: Object,
                required:true,
                default: () => ({})   
            }
        },
        data(){
            return {
                selected: false,
                videos:[],
                progress: {},
                uploads:[],
                intervals: {}
            }
        },
        methods:{
            upload(){
                this.selected = true 

                this.videos = Array.from(this.$refs.videos.files)

                const uploaders = this.videos.map(video => {
                    const form = new FormData();

                    this.progress[video.name]=0

                    form.append('video', video)

                    form.append('title', video.name)

                    return axios.post('/channels/'+this.channels.id+'/videos', form,{
                        onUploadProgress: (event) => {
                            this.progress[video.name] = Math.ceil((event.loaded / event.total) * 100)
                            // console.log(event)

                            this.$forceUpdate()
                        }
                    }).then(({ data }) => {
                        this.uploads = [
                            ...this.uploads,
                            data
                        ]
                    })
                })

                axios.all(uploaders)
                    .then( () => {
                        this.videos = this.uploads

                        this.videos.forEach(video => {
                            this.intervals[video.id] = setInterval(() => {
                                axios.get('/videos/'+video.id)
                                    .then( ({ data }) => {

                                        if(data.percentage === 100){
                                            clearInterval(this.intervals[video.id])
                                        }


                                        this.videos = this.videos.map(v => {
                                            if(v.id === data.id) 
                                            {
                                                return data
                                            }

                                            return v
                                        })
                                    })
                            }, 3000)
                        })
                    })
            }
        }
    }
</script>
