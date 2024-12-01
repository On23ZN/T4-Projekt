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
    <div>
      <h2>Login</h2>
      <form @submit.prevent="login">
        <input v-model="username" placeholder="Benutzername" required />
        <input v-model="password" type="password" placeholder="Passwort" required />
        <button type="submit">Login</button>
      </form>
    </div>
  </template>
  