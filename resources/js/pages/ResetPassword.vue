<template>
<div>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <div class="alert alert-success" role="alert" v-if="success">
              Пароль изменен
            </div>
             <div class="alert alert-danger" role="alert" v-if="faild">
              Ошибка. Проверьте правильность введенных данных
            </div>
          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
            <div class="col-md-6">
              <input
                id="email"
                type="email"
                class="form-control"
                name="email"
                v-model="email"
                :class="{'is-invalid': $v.email.$error && $v.email.$invalid}"  
              >
              <div class="invalid-feedback" v-if="!$v.email.required">
                Введите e-mail
              </div>
              <div class="invalid-feedback" v-else-if="!$v.email.email">
                Неверный формат email
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
            <div class="col-md-6">
              <input
                id="password"
                type="password"
                class="form-control"
                v-model="password"
                :class="{'is-invalid': $v.password.$error && $v.password.$invalid}"
              >
              <div class="invalid-feedback" v-if="!$v.password.required">
                Введите пароль
              </div>
              <div class="invalid-feedback" v-else-if="!$v.password.minLenght">
                Пароль не может быть меньше {{ $v.password.$params.minLength.min }} символов
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Повторите пароль</label>
            <div class="col-md-6">
              <input
                id="password-confirm"
                type="password"
                class="form-control"
                v-model="passwordConfirmation"
                :class="{'is-invalid': $v.passwordConfirmation.$error && $v.passwordConfirmation.$invalid}"  
              >
              <div class="invalid-feedback" v-if="$v.passwordConfirmation.$invalid">
                Пароли не совпадают
              </div>            
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
              <button type="submit" class="btn btn-primary" @click="reset">
                Сбросить пароль
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { email, required, minLength, sameAs } from 'vuelidate/lib/validators'

export default {
  name: 'ResetPassword',
  props: [
    'token',
    'email'
  ],  
  data() {
    return {
      password: '',
      passwordConfirmation: '',
      success: false,
      faild: false
    }
  },
  validations: {
    email: {
      required,
      email
    },
    password: {
      required,
      minLength: minLength(8),
    },
    passwordConfirmation: {
      required,
      sameAsPassword: sameAs('password')
    }
  },
  methods: {
    reset() {
      this.success = false
      this.faild = false
      
      this.$v.$touch()
      
      if (this.$v.$invalid) {
        return
      }

      let params = {
        "token": this.token,
        "password": this.password,
        "password_confirmation": this.passwordConfirmation,
        "email": this.email
      }

      this
        .$store
        .dispatch('auth/resetPassword', params)
        .then(() => {
          this.success = true
          window.location.replace('/')
        })
        .catch(() => {
          this.faild = true
        })
    }
  }
}
</script>