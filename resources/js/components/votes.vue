<template>
    <div>
        <svg @click="vote('up')" class="thumbs-up" :class="{ 'thumbs-up-active' : upvoted }" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M12.72 2c.15-.02.26.02.41.07c.56.19.83.79.66 1.35c-.17.55-1 3.04-1 3.58c0 .53.75 1 1.35 1h3c.6 0 1 .4 1 1s-2 7-2 7c-.17.39-.55 1-1 1H6V8h2.14c.41-.41 3.3-4.71 3.58-5.27c.21-.41.6-.68 1-.73zM2 8h2v9H2V8z" fill="#626262"/></svg>
        {{ upvotes_count }}

        <svg @click="vote('down')" class="thumbs-down" :class="{ 'thumbs-down-active' : downvoted }" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M7.28 18c-.15.02-.26-.02-.41-.07c-.56-.19-.83-.79-.66-1.35c.17-.55 1-3.04 1-3.58c0-.53-.75-1-1.35-1h-3c-.6 0-1-.4-1-1s2-7 2-7c.17-.39.55-1 1-1H14v9h-2.14c-.41.41-3.3 4.71-3.58 5.27c-.21.41-.6.68-1 .73zM18 12h-2V3h2v9z" fill="#626262"/></svg>
        {{ downvotes_count }}
    </div>
</template>

<script>
import numeral from 'numeral';

export default {
    props: {
        default_votes: {
            require:true,
            default: () => []
        },
        entity_owner:{
            require:true,
            default: ''
        },
        entity_id:{
            required:true,
            default: ''
        }
    },
    data(){
        return {
            votes : this.default_votes
        }
    },
    computed: {
        upvotes(){
            return this.votes.filter( v => v.type === 'up')
        },

        downvotes(){
            return this.votes.filter( v => v.type === 'down')
        },
        upvotes_count(){
            return numeral(this.upvotes.length).format('0a')
        },
        downvotes_count(){
            return numeral(this.downvotes.length).format('0a')
        },
        upvoted(){
            if(! __auth()) return false

            return !!this.upvotes.find( v => v.user_id === __auth().id)
        },
        downvoted(){
            if(! __auth()) return false

            return !!this.downvotes.find( v => v.user_id === __auth().id)
        }
    },
    methods:{
        vote(type){
            if(! __auth()){
                return alert('Please Login to vote')
            }
            
            if(__auth() && __auth().id === this.entity_owner)
            {
                return alert('You cannot vote this item');
            }

            if(type === 'up' && this.upvoted) return

            if(type === 'down' && this.downvoted) return

            axios.post('/votes/'+this.entity_id+'/'+type)
                .then( ({data}) => {
                    if(this.upvoted || this.downvoted){
                        this.votes = this.votes.map( v =>{
                            if(v.user_id === __auth().id){
                                return data
                            }

                            return v
                        })
                    }else{
                        this.votes = [
                            ...this.votes,
                            data
                        ]
                    }
                })
        }
    }
}
</script>

<style>
    .thumbs-up, .thumbs-down{
        width:20px;
        height:20px;
        cursor:pointer;
        fill: currentColor;
    }
    .thumbs-down-active, .thumbs-up-active{
        color: #3EA6FF;
    }
    .thums-down{
        margin-left:1rem
    }
</style>