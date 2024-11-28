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
    addToDo() {
      // Überprüft, ob die Eingabe nicht leer ist
      if (this.newToDo.trim() !== '') {
         // Verwende fetch, um eine POST-Anfrage an das Backend zu senden
        fetch('http://localhost/T4-Projekt/backend/createTodo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({ title: this.newTodo })
        })
        .then(response => response.json()) // Antwort in JSON umwandeln
        .then(data => {
          if (data.message) {
            // Fügt eine neue Aufgabe zum Array hinzu
            this.todos.push({ text: this.newToDo, completed: false });
            // Leert das Eingabefeld
            this.newToDo = '';
          } else {
            console.error(data.error); // Fehlerbehandlung
          }
        })
        .catch(error => console.error('Fehler:', error));
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
    }  
    // Methode zum Löschen einer Aufgabe basierend auf dem Index
    deleteToDo(index) {
      // Entfernt die Aufgabe aus dem Array
      this.todos.splice(index, 1);
    }
  }
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
        :key="index" 
        :todo="todo" 
        @deleteToDo="deleteToDo(index)" 
      />
    </ul>
  </div>
</template>
