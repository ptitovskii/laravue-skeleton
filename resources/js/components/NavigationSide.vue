<template>
  <div
    :class="{'-active' : isActive}"
    class="navigation-wrapper"
  >
    <span
      @click="onClickOverlay"
      class="overlay"
    />

    <aside class="navigation-content">
      <div
        @click="$emit('hide')"
        class="toggle-navigation-bar -close"
      >
        <div class="menu-icon-wrapper">
            <icon name="x"/>
        </div>
      </div>
      <div class="menu-container">
        <div class="body">
          <ul class="list">
            <li class="item" @click="$emit('hide')">
              <router-link
                :to="{ name: '' }">
                  link1_m
              </router-link>
            </li>
            <li class="item">
              <div class="dropdown-wrapper">
                <div
                  class="header"
                  @click="toggleAdminItem"
                >
                  dropdown
                  <div class="icon">
                    <icon :name="isShowCPItems ? 'chevron-up' : 'chevron-down'"/>
                  </div>
                </div>
                <ul v-if="isShowCPItems" class="sub-list">
                  <li
                    class="item" 
                    @click="$emit('hide')">
                    <router-link
                      :to="{name: ''}"
                    >
                      sub_link
                    </router-link>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
        <div class="footer">
          <span @click="$emit('logout')">
            Выход
          </span>
        </div>
      </div>
    </aside>
  </div>
</template>

<script>
  export default {
    name: 'NavigationSide',
    components: {
    },
    props: [
      'isActive'
    ],
    data() {
      return {
        isShowCPItems: false,
      }
    },
    methods: {
      onClickOverlay: function () {
        if (this.isActive) {
          this.$emit('hide');
        }
      },
      toggleAdminItem() {
        this.isShowCPItems = !this.isShowCPItems
      }
    }
  }
</script>
