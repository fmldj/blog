<template>
    <button class="btn btn-default" v-bind:class="{'btn-success':status}" v-text="text" v-on:click="getFollow()"></button>
</template>

<script>
    export default {
        props:['user_id'],
        data() {
            return {
                'status':false
            }
            
        },
        mounted() {
                if(window.Zhihu.name == ''){
                            this.status = false;
                }else{
                            axios.get('/api/follower/index/'+this.user_id).then(response => {
                                    this.status = response.data.status;
                            });
                }



        },
        computed:{
            text(){
                return this.status == true ? '已关注' : '关注他'
            }
        },
        methods:{
            getFollow(){
                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }

                axios.post('/api/follower',{'user_id':this.user_id}).then(response => {

                        this.status = response.data.status;


                },function(res){
                        
                });
            }
        }
    }
</script>
