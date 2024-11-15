<script>
export default {
  // Name der Komponente
  name: 'ToDoItem',
  // Props sind Eingaben für die Komponente
  props: {
    // Die aktuelle Aufgabe, die als Objekt übergeben wird
    todo: Object
  },
  // Methoden, um die Aufgabe zu verwalten
  methods: {
    // Methode zum Umschalten des Erledigt-Status
    switchComplete() {
      // Ändert den Status der Aufgabe (true/false)
      this.todo.completed = !this.todo.completed;
    }
  }
};
</script>