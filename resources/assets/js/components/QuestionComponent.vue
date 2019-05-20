<template>

    <button type="button" class="btn btn-sm" v-bind:class="[ status ? 'btn-success' : 'btn-default' ]" v-on:click="getFollow()">
                  <span class="glyphicon glyphicon-heart"></span> 
                  <span v-text="text"></span>
                  <span v-text="followers"></span>
    </button>
</template>

<script>
    export default {
        props:['question','followers_count'],
        data() {
            return {
                'status':false,
                'count':this.followers_count,
            }
            
        },
        mounted() {

            if(window.Zhihu.name == ''){
                        this.status = false;

            }else{
                axios.post('/api/question/followed',{'question_id':this.question}).then(response => {
                        this.status = response.data.status;
                });
            }

        },
        computed:{
            text(){
                return this.status == true ? '已关注' : '关注问题'
            },
            followers(){
                return this.count
            }
        },
        methods:{
            getFollow(){

                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }   

                axios.post('/api/question/follow',{'question_id':this.question}).then(response => {

                        this.status = response.data.status;
                        this.status ? this.count++ : this.count--
                },function(res){
                        // alert('请登录在进行操作');
                });
            }
        }
    }
</script>
