import Login from 'pages/Login.vue'
import Books from 'pages/Books.vue'
import Booksreserved from 'pages/Booksreserved.vue'
import Clients from 'pages/Clients.vue'

const routes = [
  {
    path: '/',
    component: () => import('layouts/LoginLayout.vue'),
    children: [
      { path: '', component: Login, name: 'login' },
    ]
  },
  {
    path: '/books',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '/books', component: Books, name: 'books' },
      { path: '/booksreserved', component: Booksreserved, name: 'booksreserved' },
      { path: '/clients', component: Clients, name: 'clients' },

    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
