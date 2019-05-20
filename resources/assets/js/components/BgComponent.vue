<template>

<div class="ProfileHeader-userCover">
    <div class="UserCover" style="position: relative;">
        <img class="UserCover-image" v-if="cover" v-bind:src="cover" alt="用户封面">
        <div class="UserCover UserCover--colorBlock" v-else></div>

        <div style="position: absolute;top: 0px;right: 0">
          <vue-core-image-upload
          v-if="is_self == 1"
          class="btn btn-primary"
          text="上传封面背景"
          :crop="false"
          @imageuploaded="imageuploaded"
          :data="data"
          :max-file-size="5242880"
          inputOfFile="file"
          extensions="png,jpg,gif"
          url="/user/changeCover" >
        </vue-core-image-upload>
        </div>
    </div>

</div>
</template>

<script>
import VueCoreImageUpload from 'vue-core-image-upload'

export default {
  props:['cover','is_self'],
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
        this.cover = res.src;
        console.log(res.src);
    }
  }
};
</script>
