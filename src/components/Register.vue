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
    <div class="d-flex justify-content-center align-items-center vh-100">
      <div class="register-container">
        <h2 class="text-center mb-4">Registrieren</h2>
        <form @submit.prevent="register">
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
          <div class="mb-3">
            <input 
              v-model="firstName" 
              type="text" 
              class="form-control" 
              placeholder="Vorname" 
            /> 
          </div>
          <div class="mb-3">
            <input 
              v-model="lastName"
              type="text" 
              class="form-control"  
              placeholder="Nachname" 
            />
          </div>
          <button type="submit" class="btn btn-primary w-100">Registrieren</button>
        </form>
      </div>
    </div>
  </template>
  
<style scoped>
/* Container für das Registrierungsformular */
.register-container {
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
  