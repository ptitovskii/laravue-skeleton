<template>
  <div>
      HOME PAGE. You are {{ role }}
  </div>
</template>

<script>
export default {
  methods: {
  },
  computed: {
    role() {
      return this.$store.getters['auth/isAdmin'] ? 'admin' : this.$store.getters['auth/isManager'] ? 'manager' : 'user'
    }
  }
}
</script>
