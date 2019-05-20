<template>
    <div style="display:inline">
        <button class="btn btn-default" v-on:click="showSendMessage">发送私信</button>

        <!-- Access Token Modal -->
        <div class="modal fade" id="modal-access-token" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            发送私信
                        </h4>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-success" v-if="status">
                                <strong>私信发送成功</strong>
                        </div>
                        <textarea name="body" v-model="body" class="form-control"></textarea>

                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="store">发送</button>
        
                    </div>
                </div>
            </div>
        </div>



    </div>
    
</template>

<script>
    export default {
        props:['user_id'],
        data() {
            return {
                'body':'',
                'status':false,
            }
            
        },
        methods:{
            showSendMessage(){

                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }
                    $('#modal-access-token').modal('show');
            },
            store(){
                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }
                
                axios.post('/api/send/messages',{'user_id':this.user_id,'body':this.body}).then(response =>{
                     this.status = response.data.status;
                     setTimeout(function(){
                                $('#modal-access-token').modal('hide');
                     },2000);
                     
                },function(){
                     
                     
                     $('#modal-access-token').modal('hide');
                });

            }
        }
    }
</script>
