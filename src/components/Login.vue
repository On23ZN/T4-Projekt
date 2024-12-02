  <script>
  export default {
    data() {
      return {
        username: '',
        password: ''
      };
    },
    methods: {
      async login() {
        try {
          // Sende eine POST-Anfrage an das Backend, um den Benutzer zu authentifizieren
          const response = await fetch('http://localhost/T4-Projekt/backend/login.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ username: this.username, password: this.password })
          });
  
          // Wandle die Antwort in JSON um
          const data = await response.json();
  
          // Überprüfe das Ergebnis des Logins
          if (data.message) {
            alert('Login erfolgreich');
            this.$router.push('/todos');
            this.$root.isLoggedIn = true; // Setze den Login-Status in der Hauptkomponente
          } else {
            alert('Fehler beim Login: ' + data.error);
          }
        } catch (error) {
          console.error('Fehler:', error);
        }
      }
    }
  };
  </script>

  <template>
    <div class="d-flex justify-content-center align-items-center vh-100">
      <div class="login-container">
        <h2 class="text-center mb-4">Login</h2>
        <form @submit.prevent="login">
          <div class="mb-3">
            <input 
              v-model="username" 
              type="text" 
              class="form-control" 
              placeholder="Benutzername" 
              required 
            />
          </div>
          <div class="mb-3">
            <input 
              v-model="password" 
              type="password" 
              class="form-control" 
              placeholder="Passwort" 
              required 
            />
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </template>

<style scoped>
/* Container für das Login-Formular */
.login-container {
  background-color: #dbdbdb;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  padding: 2rem;
  border-radius: 8px;
}

/* Stellt sicher, dass der gesamte Bildschirm genutzt wird */
.vh-100 {
  height: 100vh;
}
</style>
  