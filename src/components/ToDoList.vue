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
  // Definieren des Datenmodells der Komponente
  data() {
    return {
      // Die neue Aufgabe, die der Benutzer eingeben kann
      newToDo: '',
      // Array, das alle Aufgaben speichert
      toDos: []
    };
  },
  // Methoden zur Verwaltung der Aufgaben
  methods: {
    // Methode zum Hinzufügen einer neuen Aufgabe
    async addToDo() {
      // Überprüft, ob die Eingabe nicht leer ist
      if (this.newToDo.trim() !== '') {
        try {
         // Sende eine POST-Anfrage an das Backend, um eine neue Aufgabe zu erstellen
         const response = await fetch('http://localhost/T4-Projekt/backend/createTodo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({ title: this.newTodo })
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
          this.todos.push({ text: this.newToDo, completed: false });
          // Leert das Eingabefeld
          this.newToDo = '';
        } else {
          console.error(data.error); // Fehlerbehandlung
        }
      } catch (error) {
        // Fehlerbehandlung: Fehlermeldung in der Konsole 
        console.error('Fehler:', error);
        }
      }
    },
    //Methode zum abrufen der Aufgabenliste
    async getTodos() {
      try {
        // Get-Anfrage an Backend senden, um die Aufgabe abzurufen
        const response = await fetch('http://localhost/T4-Projekt/backend/getTodos.php');
        //Überprüfen, war Antwort erfolgreich
        if (!response.ok) {
          throw new Error('Netzwerkantwort war nicht ok');
        }
        //Wandle die Antwort in JSON um
        const data = await response.json();
        //Aktualisieren der Aufgabenliste mit den empfangenen Daten
        this.todos = data; 
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
          body: new URLSearchParams({ id: todo.id }) 
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
  this.getTodos();
  }
};
</script>

<template>
  <!-- Hauptcontainer der To-Do-Liste -->
  <div>
    <!-- Eingabefeld für neue Aufgaben -->
    <input 
      v-model="newToDo" 
      placeholder="Neue Aufgabe hinzufügen" 
      @keyup.enter="addToDo" 
    />
    <!-- Button zum Hinzufügen einer neuen Aufgabe -->
    <button @click="addToDo">Hinzufügen</button>

    <!-- Liste aller Aufgaben, jede Aufgabe wird als ToDoItem-Komponente dargestellt -->
    <!-- Iteration über alle Aufgaben -->
     <!-- Einzigartiger Schlüssel für jedes Element in der Liste -->
     <!-- Übergibt die aktuelle Aufgabe als Prop an die ToDoItem-Komponente -->
     <!-- Event zum Löschen einer Aufgabe -->
    <ul>
      <ToDoItem
        v-for="(todo, index) in todos" 
        :key="todo.id" 
        :todo="todo" 
        @deleteToDo="deleteToDo(index)" 
      />
    </ul>
  </div>
</template>
