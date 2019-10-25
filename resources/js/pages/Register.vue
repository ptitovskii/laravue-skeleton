<template>
  <div>
    <div class="row justify-content-center" v-if="canMount">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div>
              <div class="form-group row">
                <label for="login" class="col-md-4 col-form-label text-md-right">Логин</label>

                <div class="col-md-6">
                  <input
                    id="login"
                    type="text"
                    class="form-control"
                    v-model="login"
                    :class="{'is-invalid': $v.login.$error && $v.login.$invalid}"  
                  >
                  <div class="invalid-feedback" v-if="!$v.login.required">
                    Введите логин
                  </div>
                  <div class="invalid-feedback" v-else-if="loginOccupied">
                    Логин занят
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="surname" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                <div class="col-md-6">
                  <input
                    id="surname"
                    type="text"
                    class="form-control"
                    v-model="surname"
                    :class="{'is-invalid': $v.surname.$error && $v.surname.$invalid}"  
                  >
                  <div class="invalid-feedback" v-if="!$v.surname.required">
                    Введите фамилию
                  </div>
                  <div class="invalid-feedback" v-else-if="!$v.surname.minLenght">
                    Фамилия не может быть меньше {{ $v.name.$params.minLength.min }} символов
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>

                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    class="form-control"
                    v-model="name"
                    :class="{'is-invalid': $v.name.$error && $v.name.$invalid}"  
                  >
                  <div class="invalid-feedback" v-if="!$v.name.required">
                    Введите имя
                  </div>
                  <div class="invalid-feedback" v-else-if="!$v.name.minLenght">
                    Имя не может быть меньше {{ $v.name.$params.minLength.min }} символов
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="patronymic" class="col-md-4 col-form-label text-md-right">Отчество</label>

                <div class="col-md-6">
                  <input
                    id="patronymic"
                    type="text"
                    class="form-control"
                    v-model="patronymic"
                  >
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    readonly
                    v-model="email"
                    :class="{'is-invalid': $v.email.$error && $v.email.$invalid}"
                  >
                  <div class="invalid-feedback" v-if="!$v.email.required">
                    Введите e-mail
                  </div>
                  <div class="invalid-feedback" v-else-if="!$v.email.minLenght">
                    E-mail не может быть меньше {{ $v.email.$params.minLength.min }} символов
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">Телефон</label>

                <div class="col-md-6">
                  <cleave
                    :options="phoneMaskOptions"
                    id="inputEmail"
                    :raw="true"
                    name="phone"
                    type="tel"
                    v-model="phone"
                    class="form-control input-login"
                    :class="{'is-invalid': $v.phone.$error && $v.phone.$invalid}"
                  />
                  <div class="invalid-feedback" v-if="$v.phone.$invalid">
                    Неверный формат телефона
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
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвердите пароль</label>

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
                  <button type="button" class="btn btn-success" @click="register">
                    Зарегистрироваться
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
  import { email, required, minLength, sameAs, numeric } from 'vuelidate/lib/validators'
  import Cleave from 'vue-cleave-component'
  import "cleave.js/dist/addons/cleave-phone.ru"

  export default {
    name: "Register",
    components: {
      Cleave
    },
    props: {
      token: ''
    },
    data() {
      return {
        email: '',
        login: '',
        name: '',
        surname: '',
        patronymic: '',
        password: '',
        passwordConfirmation: '',
        phone: '',
        canMount: false,
        loginOccupied: false,
        phoneMaskOptions: {
          phone: true,
          prefix: '+7',
          phoneRegionCode: 'RU',
          rawValueTrimPrefix: true,
          noImmediatePrefix: true
        }
      }
    },
    validations: {
      login: {
        required
      },
      email: {
        required,
        email,
        minLength: minLength(3),
      },
      name: {
        required,
        minLength: minLength(2),
      },
      surname: {
        required,
        minLength: minLength(3),
      },
      phone: {
        required,
        minLength: minLength(10),
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
    beforeMount() {
      this.$store.dispatch('auth/validateToken', this.token)
      .then((data) => {
        this.email = data.email
        this.canMount = true
      })
      .catch(() => {
        window.location.href = '/login'
      }) 
    },
    methods: {
      register() {
        this.$v.$touch()

        if (this.$v.$invalid) {
          return 
        }

        let params = {
          "name": this.name,
          "surname": this.surname,
          "patrinymic": this.patronymic,
          "phone": this.phone,
          "email": this.email,
          "password": this.password,
          "password_confirmation": this.passwordConfirmation,  
        }

        this.$store
          .dispatch('auth/validateLogin', this.login)
          .then(() => {
            this.$store
              .dispatch('auth/register', params)
              .then(() => {
                window.location.href = '/'
              })
          })
          .catch(() => {
            this.loginOccupied = true
          })
      }
    }
  }
</script>


