<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Сброс пароля</div>

          <div class="card-body">
            <div class="alert alert-success" role="alert" v-if="success">
              Ссылка на изменение пароля отправлена Вам на email
            </div>
             <div class="alert alert-danger" role="alert" v-if="faild">
              Email не найден. Проверьте его
            </div>

            <div>
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

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary" @click="sendLink">
                    Отправить ссылку для сброса пароля
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      
  </div>
</template>

<script>
import { email, required } from 'vuelidate/lib/validators'

export default {
  name: 'ForgotPassword',
  data() {
    return {
      email: '',
      success: false,
      faild: false
    }
  },
  validations: {
    email: {
      required,
      email
    },
  },
  methods: {
    sendLink() {
      this.success = false
      this.faild = false

      this.$v.$touch()
      
      if (this.$v.$invalid) {
        return
      }

      this
        .$store
        .dispatch('auth/sendResetPasswordLink', this.email)
        .then((res) => {
          this.success = true
          this.email = ''
        })
        .catch(() => {
          this.faild = true  
        })
    }
  }
}
</script>