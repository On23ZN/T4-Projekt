<script>
// Import der ToDoItem-Komponente
import ToDoItem from './ToDoItem.vue';

export default {
  // Name der Komponente
  name: 'ToDoList',
  // Registrieren der ToDoItem-Komponente
  components: {
    ToDoItem
  },
  // Empfangen der Benutzer-ID als Prop 
  props: { 
    
    userId: { 
      type: Number, 
      required: true
    } 
  },
  // Definieren des Datenmodells der Komponente
  data() {
    return {
      // Die neue Aufgabe, die der Benutzer eingeben kann
      newToDo: '',
      // Array, das alle Aufgaben speichert
      todos: []
    };
  },
  // Methoden zur Verwaltung der Aufgaben
  methods: {
    // Methode zum Hinzufügen einer neuen Aufgabe
    async addToDo() {
      // Überprüft, ob die Eingabe nicht leer ist
      if (this.newToDo.trim() !== '') {
        try {
          console.log('Benutzer-ID:', this.userId); // Benutzer-ID in der Konsole ausgeben 
          console.log('Titel:', this.newToDo); // Titel in der Konsole ausgeben
          
         // Sende eine POST-Anfrage an das Backend, um eine neue Aufgabe zu erstellen
         const response = await fetch('http://localhost/T4-Projekt/backend/createTodo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({ title: this.newToDo, user_id: this.userId })
        });
        // Überprüfe, ob die Antwort erfolgreich war
        if (!response.ok) {
          throw new Error('Netzwerkantwort war nicht ok');
        }
        // Wandle die Antwort in JSON um
        const data = await response.json();
        // Überprüfe, ob die Aufgabe erfolgreich erstellt wurde
        if (data.message) {
          // Fügt eine neue Aufgabe zur Liste hinzu
          this.todos.push({ id: data.todo_id, text: this.newToDo, completed: false });
          // Leert das Eingabefeld
          this.newToDo = '';
        } else {
          console.error('Fehler beim Erstellen der Aufgabe:', data.error);
        }
      } catch (error) {
        // Fehlerbehandlung: Fehlermeldung in der Konsole 
        console.error('Fehler:', error);
      }
      } else { 
        console.error('Eingabe ist leer'); 
      }
      },
    
    //Methode zum abrufen der Aufgabenliste
    async getTodos() {
      try {
        // Get-Anfrage an Backend senden, um die Aufgabe abzurufen
        const response = await fetch('http://localhost/T4-Projekt/backend/getTodos.php', {
        method: 'POST', 
        headers: { 
          'Content-Type': 'application/x-www-form-urlencoded' 
        }, 
        body: new URLSearchParams({ user_id: this.userId }) 
      });
        //Überprüfen, war Antwort erfolgreich
        if (!response.ok) {
          throw new Error('Netzwerkantwort war nicht ok');
        }
        //Wandle die Antwort in JSON um
        const data = await response.json();
        //Aktualisieren der Aufgabenliste mit den empfangenen Daten
        if (Array.isArray(data)) {
          this.todos = data; 
        } else { 
          console.error('Fehler beim Abrufen der Todos:', data.error || 'Ungültige Antwort'); 
        }
      } catch (error) {
        // Fehlerbehandlung: Fehlermeldung in der Konsole
        console.error('Fehler beim Abrufen der Todos:', error);
      }
    },  
    // Methode zum Löschen einer Aufgabe basierend auf dem Index
    async deleteToDo(index) {
      console.log('Index:', index);
      // Hole die Aufgabe, die gelöscht werden soll 
      const todo = this.todos[index]; 
      console.log('To-Do-Element:', todo);

      // Überprüfe, ob `todo` definiert ist 
      if (!todo) { 
        console.error('To-Do-Element nicht gefunden'); 
        return; 
      }

      try {
        // Sende eine POST-Anfrage an das Backend, um die Aufgabe zu löschen 
        const response = await fetch('http://localhost/T4-Projekt/backend/deleteTodo.php', {
          method: 'POST', 
          headers: {
             'Content-Type': 'application/x-www-form-urlencoded'  
          },
          body: new URLSearchParams({ id: todo.id, user_id: this.userId }) 
        });

        // Überprüfe, ob die Antwort erfolgreich war 
        if (!response.ok) { 
          throw new Error('Netzwerkantwort war nicht ok'); 
        }

        // Wandle die Antwort in JSON um 
        const data = await response.json();

        // Überprüfe, ob die Aufgabe erfolgreich gelöscht wurde 
        if (data.message) {
          // Erfolg: Aufgabe aus der Liste entfernen
          this.todos.splice(index, 1); 
        } else {
          console.error(data.error); // Fehlerbehandlung 
        }
      } catch (error) {
        // Fehlerbehandlung: Fehlermeldung in der Konsole 
        console.error('Fehler:', error); 
      } 
    }
  },
  mounted() {
  // Aufgaben abrufen, wenn die Komponente geladen wird
    if (this.userId) {
      this.getTodos();
    } else {
    console.error('Benutzer-ID ist null. Todos können nicht geladen werden.');
    }
  }
};
</script>

<template>
  <!-- Hauptcontainer der To-Do-Liste -->
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="todo-container">
      <h2 class="text-center mb-4">Aufgabenliste</h2>
      <form @submit.prevent="addToDo" class="mb-4">
        <!-- Eingabefeld für neue Aufgaben -->
        <div class="input-group mb-3">
          <input 
            v-model="newToDo" 
            type="text" 
            class="form-control" 
            placeholder="Neue Aufgabe hinzufügen"
            required  
          />
          <!-- Button zum Hinzufügen einer neuen Aufgabe -->
          <button 
            type="submit" 
            class="btn btn-primary"
          >
            Hinzufügen
          </button>
        </div>
      </form>
      <!-- Liste aller Aufgaben, jede Aufgabe wird als ToDoItem-Komponente dargestellt -->
      <!-- Iteration über alle Aufgaben -->
      <!-- Einzigartiger Schlüssel für jedes Element in der Liste -->
      <!-- Übergibt die aktuelle Aufgabe als Prop an die ToDoItem-Komponente -->
      <!-- Event zum Löschen einer Aufgabe -->
      <ul class="list-group">
        <ToDoItem
         v-for="(todo, index) in todos" 
          :key="todo.id" 
          :todo="todo" 
          :userId="userId" 
          @deleteToDo="deleteToDo(index)" 
          @toggleComplete="toggleComplete(todo.id, !todo.completed)"
        />
      </ul>
    </div>
  </div>
</template>

<style scoped>
/* Container für die Aufgabenliste */
.todo-container {
  background-color: #dbdbdb;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  padding: 2rem;
  border-radius: 8px;
}

/* Höhe des Containers */
.vh-100 {
  height: 100vh;
}

/* Aufgabenliste-Element */
.list-group-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>