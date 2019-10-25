<template>
  <div :class="getClasses">
    <slot>
      <Navigation/>
    </slot>

    <div class="content">
      <router-view v-if="canMount"/>
    </div>
  </div>
</template>

<script>
  import Navigation from "../components/Navigation";

  export default {
    name: "App",
    data() {
      return {
        canMount: false
      }
    },
    components: {
      Navigation
    },
    async beforeMount() {
      await this.$store.dispatch('app/getAppParams').then(() => {
        this.canMount = true
      })
      .catch(() => {
        if (this.$route.meta.auth === false) {
          this.canMount = true
        }            
      })
    },
    computed: {
      getClasses: function () {
        return `breakpoint-${this.$mq}`
      }
    },
  }
</script>
