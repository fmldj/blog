<template>
<div class="center" style="text-align:center">
  <div><img v-bind:src="avatar" style="width:80px;margin-bottom:30px"></div>
  <vue-core-image-upload
    class="btn btn-primary"
    text="上传头像"
    :crop="true"
    @imageuploaded="imageuploaded"
    :data="data"
    :max-file-size="5242880"
    inputOfFile="file"
    extensions="png,jpg,gif"
    url="/user/changeAvatar" >
  </vue-core-image-upload>
</div>

</template>

<script>
import VueCoreImageUpload from 'vue-core-image-upload'

export default {
  props:['avatar'],
  data() {
    return {
      data: {
        _token: document.head.querySelector('meta[name="csrf-token"]').content
      }
    }
  },
  components: {
    'vue-core-image-upload': VueCoreImageUpload,
  },
  methods: {

    imageuploaded(res) {
        this.avatar = res.src;
        console.log(res.src);
    }
  }
};
</script>
