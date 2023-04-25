<template>
  <q-page class="row">
    <div class="col-12 q-pa-md">
      <q-table title="Clientes" dense :data="rows" :columns="columns" row-key="name">
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td key="email" :props="props">
              {{ props.row.email }}
            </q-td>
            <q-td key="name" :props="props">
              {{ props.row.name }}
            </q-td>
            <q-td key="lastname" :props="props">
              {{ props.row.lastname }}
            </q-td>
            <q-td key="ci" :props="props">
              {{ props.row.ci }}
            </q-td>
            <q-td key="actions" :props="props">
              <q-btn round flat color="primary" icon="assignment" @click="seeBooks(props.row)"
              >
                <q-tooltip>Ver Libros</q-tooltip>
              </q-btn>
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>
    <q-dialog v-model="dialog" persistent transition-show="scale" transition-hide="scale">
      <q-card>
          <q-card-section class="bg-primary">
            <div class="text-h6 text-white">
              Libros reservados por {{ name }}{{ lastname }}
            </div>
          </q-card-section>
          <div v-for="book in books" :key="book.title" class="row">
            <div class="col-12 q-px-md">
              Título: {{ book.title }}
            </div>
            <div class="col-12 q-px-md">
              Descripción: {{ book.description }}
            </div>
            <div class="col-12 q-px-md">
              Fecha de la reserva: {{ book.reservation_date }}
            </div>
            <div class="col-12 q-px-md q-pb-md">
              Fecha de entrega: {{ book.deadline }}
            </div>
          </div>
          <div class="row justify-end">
            <q-btn type="button" icon="close" @click="dialog = false" label="Cerrar" color="negative" flat/>
          </div>
      </q-card>
    </q-dialog>
  </q-page>
</template>
<script>
export default {
  name: 'Clients',
  data () {
    return {
      columns: [
        { name: 'email', required: true, label: 'Correo', align: 'left', field: row => row.email },
        { name: 'name', label: 'Nombre', field: 'name' },
        { name: 'lastname', label: 'Apellidos', field: 'lastname' },
        { name: 'ci', label: 'CI', field: 'ci' },
        { name: 'actions', label: 'Libros Reservados', field: 'actions' }
      ],
      rows: [],
      books: [],
      dialog: false,
      name: '',
      lastname: '',
    }
  },
  created () {
    this.loadData()
  },
  methods:  {
    async loadData () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .get('/api/clients')
          .then(response => {
            this.rows = response.data.data
            console.log(this.rows)
          })
      },
      async seeBooks(user) {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/booksXClient', {id: user.id})
          .then(response => {
            this.books = response.data.data
            this.name = user.name
            this.lastname = user.lastname
            this.dialog = true
          })
      }
  }
}
</script>
