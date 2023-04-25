<template>
  <q-page class="row">
    <div class="col-12 q-pa-md">
      <q-table dense :data="rows" :columns="columns" row-key="name">
        <template v-slot:top>
        <span><b>Libros</b></span>
        <q-space />
        <q-btn v-if="workerRole" round dense color="primary" icon="add" @click.prevent="openModal('add')">
          <q-tooltip>Adicionar</q-tooltip>
        </q-btn>
      </template>
        <template v-slot:body="props">
          <q-tr :props="props">
            <q-td key="title" :props="props">
              {{ props.row.title }}
            </q-td>
            <q-td key="description" :props="props">
              {{ props.row.description }}
            </q-td>
            <q-td v-if="props.row.user != null" key="user" :props="props">
              {{ props.row.user.name+' '+props.row.user.lastname }}
            </q-td>
            <q-td v-else key="user" :props="props">
              -
            </q-td>
            <q-td key="actions" :props="props">
              <q-btn v-if="workerRole" round flat color="primary" icon="edit" @click="openModal('update', props.row)">
                <q-tooltip>Actualizar</q-tooltip>
              </q-btn>
              <q-btn v-else round flat color="primary" icon="shopping_bag" @click="reserve(props.row)"
              >
                <q-tooltip>Reservar</q-tooltip>
              </q-btn>
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>
    <q-dialog v-model="dialog" persistent transition-show="scale" transition-hide="scale">
      <q-card>
        <q-form @submit="action === 'add' ? save(): update()" class="q-gutter-md">
          <q-card-section class="bg-primary">
            <div class="text-h6 text-white">
              {{action === 'add' ? 'Adicionar Libro': 'Editar Libro'}}
            </div>
          </q-card-section>
          <div class="row">
            <div class="col-12 q-px-md">
              <q-input v-model="formData.title" dense label="Título" lazy-rules :rules="[ val => val && val.length > 0 || 'El título es necesario']"/>
            </div>
            <div class="col-12 q-px-md">
              <q-input dense v-model="formData.description" label="Descripción" autogrow lazy-rules :rules="[ val => val && val.length > 0 || 'El correo es necesario']"/>
            </div>
            <div class="col-12">
              <q-toggle v-model="formData.active" label="Disponible"/>
            </div>
          </div>
          <div class="row justify-end">
            <q-btn type="submit" icon="save" label="Guardar" color="primary" flat/>
            <q-btn type="button" icon="close" @click="dialog = false" label="Cancelar" color="negative" flat/>
          </div>
        </q-form>
      </q-card>
    </q-dialog>
  </q-page>
</template>
<script>
export default {
  name: 'Books',
  data () {
    return {
      columns: [
        { name: 'title', required: true, label: 'Título', align: 'left', field: 'title' },
        { name: 'description', label: 'Descripción', field: 'description' },
        { name: 'user', label: 'Reservado por', field: 'user' },
        { name: 'actions', label: 'Acciones', field: 'actions' }
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
    this.workerRole = localStorage.getItem('rol') == '2'
    this.loadData()
  },
  methods:  {
    async loadData () {
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
      let url = this.workerRole ? '/api/book': '/api/booksActive'
      await this.$axios
        .get(url)
        .then(response => {
          this.rows = response.data.data
        })
    },
    openModal (action, data) {
      this.action = action
      if (action === 'add') {
        this.resetData()
        this.dialog = true
      } else {
          console.log(data, 'data')
          this.setData(data)
          this.dialog = true
        }
    },
    async reserve (book) {
      console.log(book.id, 'id libro')
      this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
      await this.$axios
        .post('/api/reserveBook', {book_id: book.id})
        .then(response => {
          this.rows = response.data.data
        })
    },
    resetData () {
        this.formData.id = '',
        this.formData.title = '',
        this.formData.description = '',
        this.formData.active = true
      },
      setData (data) {
        this.formData.id = data.id,
        this.formData.title = data.title,
        this.formData.description = data.description,
        this.formData.active = data.active == 1? true:false
      },
      async save () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .post('/api/book', this.formData)
          .then(response => {
            this.rows.push(this.formData)
            this.dialog = false
          })
      },
      async update () {
        this.$axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        await this.$axios
          .put('/api/book/'+this.formData.id, this.formData)
          .then(response => {
            this.dialog = false
            this.rows.forEach(book => {
              if(book.id == this.formData.id){
                book.id =this.formData.id,
                book.title = this.formData.title,
                book.description = this.formData.description,
                book.active = this.formData.active
              }
            });
          })
      },
  }
}
</script>

