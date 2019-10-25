<template>
  <div :class="getClasses">
    <navigation/>
    <div class="form-signin-wrapper">
      <div class="form">
        <h1 class="h3 mb-3 font-weight-normal">
          Вход
        </h1>
        <div class="" v-if="isInvalidForm">
          <p class="text-danger">
            Не верный логин/пароль
          </p>
        </div>
        <div class="form-group">
          <input
            id="inputLogin"
            name="login"
            v-model="login"
            class="form-control"
            :class="{'is-invalid': $v.login.$error && $v.login.$invalid}"
            placeholder="Логин"
            @focusin="$v.login.$touch()"
          />
          <div class="invalid-feedback" v-if="$v.login.$invalid">
            Введите логин
          </div>
        </div>
        <div class="form-group">
          <input
            id="inputPassword"
            v-model="password"
            type="password"
            :class="{'is-invalid': $v.password.$error && $v.password.$invalid}"
            class="form-control input-password"
            placeholder="Пароль"
            name="password"
            @blur="$v.password.$touch()"
          />
          <div class="invalid-feedback" v-if="!$v.password.required">
            Введите пароль
          </div>
        </div>
        <div class="buttons-wrapper">
          <div>
            <label class="remember">
              <input
                type="checkbox"
                name="remember"
                v-model="rememberMe"
              >
              Запомнить
            </label>
          </div>
          <div class="signin-button">
            <button
              class="btn btn-success"
              type="button"
              @click="auth"
            >
              Вход
            </button>
              <small class="forgot-password">
                <a
                  class="form-text text-muted"
                  href="/forgot-password"
                >
                  Забыли пароль?
                </a>
              </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { required } from 'vuelidate/lib/validators'
  import Navigation from "../components/Navigation";

  export default {
  components: {
    Navigation,
    Cleave
  },
  data() {
    return {
      login: '',
      password: '',
      rememberMe: false,
      isInvalidForm: false,
    }
  },
  validations: {
    login: {
      required,
    },
    password: {
      required
    },
  },
  beforeMount() {
    if (this.$store.getters['auth/isAuth']) {
      window.location.replace('/')
    }
  },
  methods: {
    async auth() {
      this.isInvalidForm = false

      let loginData = {
        login: this.login,
        password: this.password,
        remember: this.rememberMe
      }

      this.$v.login.$touch()
      this.$v.password.$touch()

      if (this.$v.$invalid) {
        return false
      }

      this.$store
        .dispatch('auth/login', loginData)
        .then((res) => {
          window.location.href = '/'
        })
        .catch ((res) => {
          if (res.status === 422) {
            this.isInvalidForm = true
          }
        });
    }
  },
  computed: {
    getClasses: function () {
      return `breakpoint-${this.$mq}`
    }
  },
}
</script>
