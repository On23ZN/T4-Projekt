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
        // Fügt eine neue Aufgabe zum Array hinzu
        this.todos.push({ text: this.newToDo, completed: false });
        // Leert das Eingabefeld
        this.newToDo = '';
      }
    },

  }
</script>

