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
    <nav class="navbar navbar-expand-sm navbar-light bg-light shadow mb-4 fixed-top"> 
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Meine Todos</a>
        <button 
          class="navbar-toggler" 
          type="button" 
          data-bs-toggle="collapse" 
          data-bs-target="#navbarNav" 
          aria-controls="navbarNav" 
          aria-expanded="false" 
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item" v-if="!isLoggedIn">
              <router-link class="nav-link" to="/login">Login</router-link>
            </li>
            <li class="nav-item" v-if="!isLoggedIn">
              <router-link class="nav-link" to="/register">Registrieren</router-link>
            </li>
            <li class="nav-item" v-if="isLoggedIn">
              <button class="btn btn-outline-danger nav-link" @click="logout">Logout</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Router-View für die Anzeige der aktuellen Route --> 
    <router-view :userId="userId"></router-view>
  </div>
</template>

<style scoped>
/* Allgemeiner Stil für die Navigation */
.navbar {
  background-color: #dbdbdb;
  border-radius: 8px;
}

/* Schatteneffekt für die Navigation */
.navbar-light {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Styling für die Nav-Links */
.nav-link {
  font-weight: 500;
  color: #333;
}

.nav-link:hover {
  color: #007bff;
}

/* Logout-Button Anpassung */
.btn-outline-danger {
  border: 1px solid #dc3545;
}

.btn-outline-danger:hover {
  background-color: #dc3545;
  color: #fff;
}
</style>