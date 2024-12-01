  <script>
  export default {
    data() {
      return {
        username: '',
        password: '',
        firstName: '',
        lastName: ''
      };
    },
    methods: {
      async register() {
        try {
          // Sende eine POST-Anfrage an das Backend, um den Benutzer zu registrieren
          const response = await fetch('http://localhost/T4-Projekt/backend/register.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ 
                username: this.username,
                password: this.password,
                first_name: this.firstName, 
                last_name: this.lastName
             })
          });
  
          // Wandle die Antwort in JSON um
          const data = await response.json();
  
          // Überprüfe das Ergebnis der Registrierung
          if (data.message) {
            alert('Registrierung erfolgreich');
            this.$router.push('/login');
          } else {
            alert('Fehler bei der Registrierung: ' + data.error);
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
      <h2>Registrieren</h2>
      <form @submit.prevent="register">
        <input v-model="username" placeholder="Benutzername" required />
        <input v-model="password" type="password" placeholder="Passwort" required />
        <input v-model="firstName" placeholder="Vorname" /> 
        <input v-model="lastName" placeholder="Nachname" />
        <button type="submit">Registrieren</button>
      </form>
    </div>
  </template>
  
  