<template>

    <button type="button" class="btn btn-sm" v-bind:class="[ statuss ? 'btn-success' : 'btn-default' ]" v-on:click="getFollow()">
                  <span class="glyphicon glyphicon-heart"></span> 
                  <span v-text="text"></span>

    </button>
</template>

<script>
    export default {
        props:['status','topic_id'],
        data() {
            return {
                'statuss':this.status
            }
            
        },
        mounted() {
            // axios.get('/api/topic/look/' + this.topic_id).then(response => {
            //         this.statuss = response.data.status;
            // });
        },
        computed:{
            text(){
                return this.statuss == true ? '已关注' : '关注话题'
            },

        },
        methods:{
            getFollow(){
                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }

                axios.post('/api/topic/following',{'topic_id':this.topic_id}).then(response => {

                        this.statuss = response.data.status;

                },function(res){
                        
                });
            }
        }
    }
</script>
