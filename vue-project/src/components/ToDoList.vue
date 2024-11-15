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
}
</script>

