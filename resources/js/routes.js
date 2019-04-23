import MasterLogin from './components/MasterLogin'
import Dashboard from './components/Dashboard'

// function requireAuth (to, from, next) {
//   if (!auth.loggedIn()) {
//     next({
//       path: '/login',
//       query: { redirect: to.fullPath }
//     })
//   } else {
//     next()
//   }
// }

export const routes = [
	{ 
		path: '/login',
		name: 'login',
		component: MasterLogin
	},
	{ 
		path: '/dashboard',
		name: 'dashboard',
		component: Dashboard,
		meta: {
      		requiresAuth: true
    	}
	}
]

