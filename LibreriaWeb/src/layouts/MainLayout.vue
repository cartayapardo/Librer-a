<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />

        <q-toolbar-title>
          <span>Librería</span>
        </q-toolbar-title>

        <q-btn
          round
          dense
          flat
          @click="logout"
          color="white"
          icon="logout"
        >
          <q-tooltip class="bg-indigo" :offset="[10, 10]">
            Cerrar Sesión
          </q-tooltip>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label
          header
        >
          <span>Navegación</span>
        </q-item-label>

        <EssentialLink
          v-for="link in links"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

export default {
  name: 'MainLayout',
  components: {
    EssentialLink
  },
  data () {
    return {
      leftDrawerOpen: false,
      links: [
                {
                  title: 'Libros',
                  caption: 'Listado de libros',
                  icon: 'article',
                  link: 'books'
                },
                {
                  title: 'Libros Reservados',
                  caption: 'Listado de libros reservados',
                  icon: 'fact_check',
                  link: 'booksreserved'
                }
              ]
    }
  },
  created () {
    this.createMenu()
  },
  methods: {
    async createMenu () {
      console.log(localStorage.getItem('rol'))
      if(localStorage.getItem('rol') == '2'){
        this.links.push({ title: 'Clientes', caption: 'Clientes de la aplicación', icon: 'person', link: 'clients' })
      }
    },
    async logout () {
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
      await this.$axios
          .post('/api/close')
          .then(response => {
            localStorage.setItem('user', null)
            localStorage.setItem('rol', null)
            localStorage.setItem('token', null)
            this.$router.push({ name: 'login' })
          })
    }
  }
}
</script>
