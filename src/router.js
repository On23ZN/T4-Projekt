import { createRouter, createWebHistory } from 'vue-router';
import ToDoList from '@/components/ToDoList.vue';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';

  const routes = [
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    { 
      path: '/todos', 
      name: 'ToDoList', 
      component: ToDoList
    
      
    }, 
    { 
      path: '/:catchAll(.*)*',
      redirect: '/register' 
    } 
  ];
  
  const router = createRouter({
     history: createWebHistory(), 
     routes 
  }); 
  
  export default router;