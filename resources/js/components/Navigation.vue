<template>
  <nav class="navigation">
    <div class="left-side">
      <div
        class="menu-icon-wrapper"
        v-if="isMobile"
        @click="toggleMobileMenu"
      >
        <icon name="menu"/>
      </div>

      <NavigationSide
        v-if="isMobile"
        :is-active="menuIsActive"
        @hide="toggleMobileMenu"
        @logout="logout"
      />

      <div>
        <router-link
          class="navbar-brand"
          :to="{ name: 'home' }"
          v-if="$route.path !== '/login'"
        >
          {{ appName }}
        </router-link>
        <span
          class="navbar-brand"
          v-else
        >
          {{ appName }}
        </span>
        <span class="page-title">
          {{ $route.meta.title }}
        </span>
      </div>
    </div>

    <div
      class="right-side"
      v-if="$store.getters['auth/isAuth']"
    >
      <div class="list" v-if="!isMobile">
        <div class="element">
          <router-link
            :to="{ name: '' }"
          >
            link1
          </router-link>
        </div>
        <div class="element">
        <span
          class=""
          @click.prevent="logout"
        >
          Выход
        </span>
      </div>
      </div>
      <span
        class="account-label"
        id="dropdownMenuButton"
        data-toggle="dropdown"
        aria-haspopup="true"
      >
        {{ userInitials }}
      </span>
    </div>
  </nav>
</template>

<script>
import { faBars } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

export default {
  name: "Navigation",
  components: {
    FontAwesomeIcon
  },
  data() {
    return {
      menuIsActive: false,
      menuIcon: faBars
    }
  },
  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout').then(()=> {window.location.href = '/login'})
    },
    toggleMobileMenu: function () {
      this.menuIsActive = !this.menuIsActive;
    }
  },
  computed: {
    appName() {
      return this.$store.getters['app/getAppName']
    },
    userInitials() {
      return this.$store.getters['auth/getUserInitials']
    },
    isManager() {
      return this.$store.getters['auth/isManager']
    },
    isAdmin() {
      return this.$store.getters['auth/isAdmin']
    },
    isMobile() {
      let mobileBreakPoints = ["mp", "mobile"]

      return mobileBreakPoints.indexOf(this.$mq) > -1
    }
  }
}
</script>
