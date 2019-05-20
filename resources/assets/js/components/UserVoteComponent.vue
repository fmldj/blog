<!-- 点赞某个答案 -->
<template>
    <button class="btn btn-sm btn-default" v-bind:class="{'btn-success':status}" v-text="text" v-on:click="getFollow()"></button>
</template>

<script>
    export default {
        props:['answer','count'],
        data() {
            return {
                'status':false,
                'counts':this.count,
            }
            
        },
        mounted() {
            if(window.Zhihu.name == ''){
                        this.status = false;
            }else{
                        axios.get('/api/answer/index/'+this.answer).then(response => {
                                this.status = response.data.status;
                        });
            }


        },
        computed:{
            text(){
                return this.counts
            }
        },
        methods:{
            getFollow(){
                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }
                axios.post('/api/answer/vote',{'answer':this.answer}).then(response => {

                        this.status = response.data.status;
                        this.status ? this.counts++ : this.counts--;


                });
            }
        }
    }
</script>
