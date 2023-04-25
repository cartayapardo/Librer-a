<template>
  <q-card class="login-form-card shadow-20">
    <q-card-section>
      <q-form v-if="seeRegister" @submit="register" class="text-primary row">
        <div class="text-h6 col-12 q-my-xs text-center">Registrarse</div>
        <div class="col-12 column items-cemter">
          <q-input
            label="Nombre:"
            v-model="formRegister.name"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El nombre es necesario']"
          />
        </div>
        <div class="col-12 column items-cemter">
          <q-input
            label="Apellidos:"
            v-model="formRegister.lastname"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Los apellidos son necesarios']"
          />
        </div>
        <div class="col-12 column items-cemter">
          <q-input
            label="CI:"
            v-model="formRegister.ci"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El CI es necesario']"
          />
        </div>
        <div class="col-12 column items-cemter">
          <q-input
            label="Correo:"
            v-model="formRegister.email"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El correo es necesario']"
          />
        </div>
        <div class="col-12 column items-cemter q-mb-lg">
          <q-input
            label="Contraseña:"
            v-model="formRegister.password"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El contraseña es necesaria']"
            :type="isPwd ? 'password' : 'text'"
          >
            <template v-slot:append>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                @click="isPwd = !isPwd"
              />
            </template>
          </q-input>
        </div>
        <div class="col-6">
          <q-btn
            class="q-px-sm"
            @click="seeRegister = false"
            color="secondary"
            dense
            label="Cancelar"
          />
        </div>
        <div class="col-5 q-pl-md">
          <q-btn
            class="q-px-sm"
            type="submit"
            color="primary"
            dense
            label="Aceptar"
          />
        </div>
      </q-form>
      <q-form v-else @submit="login" class="text-primary row">
        <div class="text-h6 col-12 q-my-md text-center">Iniciar sesión</div>
        <div class="col-12 column items-cemter">
          <q-input
            label="Correo:"
            v-model="formLogin.email"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El correo es necesario']"
          />
        </div>
        <div class="col-12 column items-cemter q-mb-lg">
          <q-input
            label="Contraseña:"
            v-model="formLogin.password"
            dense
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'El contraseña es necesaria']"
            :type="isPwd ? 'password' : 'text'"
          >
            <template v-slot:append>
              <q-icon
                :name="isPwd ? 'visibility_off' : 'visibility'"
                @click="isPwd = !isPwd"
              />
            </template>
          </q-input>
        </div>
          <div class="col-6">
            <q-btn
              class="q-px-sm"
              @click="seeRegister = true"
              color="secondary"
              dense
              label="Registrarse"
            />
          </div>
          <div class="col-5 q-pl-md">
            <q-btn
              class="q-px-sm"
              type="submit"
              color="primary"
              dense
              label="Entrar"
            />
        </div>
      </q-form>
    </q-card-section>
  </q-card>
</template>
<script>
export default {
  name: 'login-form',
  data () {
    return {
      isPwd: true,
      formLogin: { email: '', password: '' },
      formRegister: { email: '', password: '', name: '', lastname: '', ci: '', password: '' },
      seeRegister: false
    }
  },
  methods: {
    login () {
        this.$axios
          .post('/api/login', this.formLogin)
          .then(response => {
            localStorage.setItem('user', response.data.user.id)
            localStorage.setItem('rol', response.data.user.rol_id)
            localStorage.setItem('token', response.data.token)
            this.$router.push({ name: 'books' })
          })
    },
    register () {
      this.$axios
          .post('/api/register', this.formRegister)
          .then(response => {
            this.seeRegister = false
          })
    }
  }
}
</script>
