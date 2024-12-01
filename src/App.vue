<script>
// Import der ToDoList-, Login- und Register-Komponenten 
import ToDoList from './components/ToDoList.vue';
import Login from './components/Login.vue'; 
import Register from './components/Register.vue';

export default {
  // Name der Hauptkomponente
  name: 'App',
  // Registrieren der Komponenten, damit sie im Template verwendet werden können
  components: {
    ToDoList,
    Login, 
    Register
  },
};
</script>

<template>
<!-- Template definiert HTML-Struktur der Haupt-App-Komponente -->
  <div id="app">

    <!-- Navigation für Login und Registrierung --> 
    <nav> 
      <router-link to="/login">Login</router-link> 
      <router-link to="/register">Registrieren</router-link> 
    </nav> 

    <!-- Router-View für die Anzeige der aktuellen Route --> 
    <router-view></router-view>

    <button type="submit" class="btn btn-primary mb-3">Test</button>
  </div>
</template>


