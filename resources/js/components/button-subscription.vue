<template>
    <div>
        <button class="btn-danger" @click="toggleSubscription">
            Subscribe {{sum_subscription}}
        </button>
    </div>
</template>

<script>
    export default {
        props:[
            'sum_subscription'
        ],
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            toggleSubscription(){
                if(! __auth()){
                    alert('Please Login to Subscribe');
                }
            }
        }
    }
</script>
