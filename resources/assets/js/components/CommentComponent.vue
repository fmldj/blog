<template>
    <div style="display:inline">
        <button type="button" class="btn btn-default btn-sm" v-on:click="showCommentForm">
          <span class="glyphicon glyphicon-comment"></span> <span v-text='text'></span>条评论
        </button>


        <!-- Access Token Modal -->
        <div class="modal fade" v-bind:id="dialog" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            评论列表
                        </h4>
                    </div>

                    <div class="modal-body">

                        <div v-if="comments.length > 0">

                                <div class="media" v-for="(m,k) in comments">
                                        <div v-on:mouseenter="enter(m.id)" v-on:mouseleave="leave()" v-bind:class="m.parent_id!=0?'margin-left-30':''">
                                          <div class="media-left">
                                            <a href="#">
                                              <img class="media-object" style="width:25px" v-bind:src="m.user.avatar">
                                            </a>
                                          </div>
                                          <div class="media-body">
                                            <h5 class="media-heading">{{m.user.name}} 
                                                <span v-if="m.parent_name != ''">回复 {{m.parent_name}}</span>
                                                <h5 style="font-size: 10px" class="f_right">{{m.created_at}}</h5>
                                            </h5>
                                                    {{m.body}}
                                          </div>

                                          <div class="margin-left-35">
                                             <div v-show="index==m.id&&look" v-on:click="pl(m.id,k)" style="cursor: pointer;">
                                                      <span class="glyphicon glyphicon-comment"></span> <span>回复</span>
                                              </div>
                                              <div v-if="i==m.id&&is_cancel_reply" class="flex">
                                                    <input v-bind:placeholder="'回复 '+m.user.name" type="text" class="form-control" v-model="pl_body" name="">
                                                    <button type="button" class="btn btn-primary margin-left-5" @click="pl_store">发布</button>

                                               </div>
                                          </div>
                                          
                                        </div>
                                </div>
                                
                        </div>


                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer flex">
                        <input type="text" class="form-control" v-model="body" name="">
                        <button type="button" class="btn btn-primary margin-left-5" @click="store">评论</button>
        
                    </div>
                </div>
            </div>
        </div>

    </div>
    
</template>


<script>
    export default {
        props:['type','model','count'],
        data() {
            return {
                'body': '',
                'status': false,
                'comments': [],
                'look': false,
                'index': null,
                'i': null,
                'pl_body': '',
                'parent_id':null,
                'k':null,
                'counts':this.count,
            }
            
        },
        computed:{
            dialog() {
                return 'comments-dialog' + this.type + '-' + this.model;
            },
            text() {
                return this.counts;
            }
        },
        methods:{
            pl(i,k){
                this.i = i;
                this.is_cancel_reply = true;
                this.look = true;
                this.k = k;
                console.log(k);
            },
            pl_store(){
                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }

                axios.post('/api/comment/pl',{'pl_body':this.pl_body,'parent_id':this.parent_id,'type':this.type,'model':this.model}).then(response => {
                    console.log(response.data);
                        let newcomment = {
                            id: response.data.comments.id,
                            user : {
                                    name:response.data.comments.user.name,
                                    avatar:response.data.comments.user.avatar,
                            },
                            body: response.data.comments.body,
                            parent_name: response.data.parent_name,
                            parent_id: response.data.comments.parent_id,
                            created_at:response.data.comments.created_at,
                        };
                        this.counts++;
                        this.pl_body = '';
                        this.comments.splice(this.k+1,0,newcomment); 
                                           
                });
            },
            enter(index){
                this.look = true;
                this.index = index;
                this.parent_id = index;

            },
            leave(){
                this.look = false;
                this.index = null;
                this.i = null;
                this.is_cancel_reply = false;
                this.parent_id = null;
                this.k = null;
            },
            showCommentForm(){
                    this.getComments();
                    $('#'+this.dialog).modal('show');
            },
            store(){
                if(window.Zhihu.name == ''){
                            alert('请登录在进行操作');
                            return;
                }

                axios.post('/api/comment',{'type':this.type,'model':this.model,'body':this.body}).then(response =>{
                        let newcomment = {
                            id: response.data.id,
                            user : {
                                    name:Zhihu.name,
                                    avatar:Zhihu.avatar,
                            },
                            body:{},
                            parent_name: '',
                            parent_id: 0,
                            created_at:'',        
                        };
                        newcomment.body = response.data.body;
                        newcomment.created_at = response.data.created_at;
                        this.comments.push(newcomment);
                        // console.log(this.comments);
                        this.body = '';
                        this.counts++;

                     
                });

            },
            getComments() {
                
                axios.get('/api/'+ this.type + '/' + this.model + '/comments' ).then(response => {
                        this.comments = response.data;

                });
            }
        }
    }
</script>
