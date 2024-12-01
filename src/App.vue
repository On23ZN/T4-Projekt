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
  data() { 
    return { 
      isLoggedIn: false, // Initialer Login-Status 
      userId: null // Benutzer-ID initialisieren
    };
  },
  methods: { 
  async checkLoginStatus() {
    try {
      // Überprüfe den Login-Status (z.B. durch Überprüfung der Session oder eines Tokens)
      const response = await fetch('http://localhost/T4-Projekt/backend/checkLoginStatus.php', {
        method: 'GET',
        credentials: 'include'
      });
      const data = await response.json();
      this.isLoggedIn = data.isLoggedIn;
      this.userId = data.userId; // Benutzer-ID setzen
    } catch (error) {
      console.error('Fehler beim Überprüfen des Login-Status:', error);
    }
  },
  async logout() { 
    try {
      // Beende die Session und leite den Benutzer zur Login-Seite weiter 
      const response = await fetch('http://localhost/T4-Projekt/backend/logout.php', { 
        method: 'POST', 
        credentials: 'include' 
      });
      if (!response.ok) { 
        throw new Error('Netzwerkantwort war nicht ok'); 
      } 
      const data = await response.json(); 
      if (data.message) { 
        this.isLoggedIn = false; 
        this.userId = null; // Benutzer-ID zurücksetzen
        this.$router.push('/login'); 
      } else { 
        console.error('Fehler beim Logout:', data.error); 
      } 
    } catch (error) { 
      console.error('Fehler beim Logout:', error); 
    }
  } 
},
  mounted() { 
    this.checkLoginStatus(); // Überprüfe den Login-Status beim Laden der Komponente 
  }
};
</script>

<template>
<!-- Template definiert HTML-Struktur der Haupt-App-Komponente -->
  <div id="app">
   
    <!-- Navigation für Login und Registrierung --> 
    <nav> 
      <router-link v-if="!isLoggedIn" to="/login">Login</router-link> 
      <router-link v-if="!isLoggedIn" to="/register">Registrieren</router-link>
      <router-link v-if="isLoggedIn" to="/todos">To-Do-Liste</router-link> 
      <button v-if="isLoggedIn" @click="logout">Logout</button>
    </nav> 

    <!-- Router-View für die Anzeige der aktuellen Route --> 
    <router-view :userId="userId"></router-view>

    <button type="submit" class="btn btn-primary mb-3">Test</button>
  </div>
</template>


