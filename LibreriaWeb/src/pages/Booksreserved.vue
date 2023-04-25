<template>
  <q-page class="row">
    <div class="col-12 q-pa-md">
      <q-table dense title="Libros reservados" :data="rows" :columns="columns" row-key="name">
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td key="title" :props="props">
              {{ props.row.title }}
            </q-td>
            <q-td key="description" :props="props">
              {{ props.row.description }}
            </q-td>
            <q-td  key="date" :props="props">
              {{ props.row.reservation_date }}
            </q-td>
            <q-td key="deadline" :props="props">
              {{ outDate(props.row.deadline) }}
            </q-td>
            <q-td v-if="workerRole" key="actions" :props="props">
              <q-btn round flat color="primary" icon="calendar_month" @click="returnBook(props.row)"
              >
                <q-tooltip>Devolver</q-tooltip>
              </q-btn>
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>
  </q-page>
</template>
<script>
export default {
  name: 'booksreserved',
  data () {
    return {
      columns: [
        { name: 'title', required: true, label: 'Título', align: 'left', field: 'title' },
        { name: 'description', label: 'Descripción', field: 'description' },
        { name: 'date', label: 'Fecha de Reserva', field: 'date' },
        { name: 'deadline', label: 'Fuera de Tiempo', field: 'deadline' },
      ],
      rows: [],
      action: '',
      dialog: false,
      dialogDelete: false,
      workerRole: false,
      formData: {
        id: '',
        title: '',
        description: '',
        active: true
      },
      bookDelete: null
    }
  },
  created () {
    this.workerRole = localStorage.getItem('rol') == '1'
    this.isNotWorker()
    this.loadData()
  },
  methods:  {
    isNotWorker () {
      if(this.workerRole){
        this.columns.push({ name: 'actions', label: 'Acciones', field: 'actions' })
      }
    },
    outDate (date) {
      let time = Date.now();
      let today = new Date(time);
      let deadline = new Date(date);
      console.log(today, 'hoy')
      console.log(deadline, 'fecha limite')
      console.log(today < deadline, 'comparación')
      if(today < deadline){
        return 'No'
      }
      return 'Si'
    },
    async loadData () {
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
      let url = this.workerRole ? '/api/booksreservedXClient': '/api/booksreserved'
      await this.$axios
        .get(url)
        .then(response => {
          this.rows = response.data.data
        })
    },
    async returnBook (book) {
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
      await this.$axios
        .post('/api/returnBook', {book_id: book.id})
        .then(response => {
          this.rows = response.data.data
        })
    }
  }
}
</script>

