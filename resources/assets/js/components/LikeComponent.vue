<template>

    <button type="button" class="btn btn-sm" v-bind:class="[ status_ ? 'btn-success' : 'btn-default' ]" v-on:click="like">
        <span class="glyphicon glyphicon-thumbs-up"></span> <span v-text="dz"></span>点赞
    </button>

</template>

<script>


export default {
  props:['question_id','like_count','status'],
  data() {
    return {
        'like_counts' : this.like_count,
        'status_' : this.status
    }
  },
  computed:{
    dz(){
      return this.like_counts;
    }
  },
  methods: {
      like(){

        if(window.Zhihu.name == ''){
                    alert('请登录在进行操作');
                    return;
        }

        axios.post('/api/like',{'question_id':this.question_id}).then((e) => {

              if(e.data.code == 200){
                  this.like_counts++;
                  this.status_ = true;
              }else{
                  this.like_counts--;
                  this.status_ = false;
              }
        });
      }

  }
};
</script>
