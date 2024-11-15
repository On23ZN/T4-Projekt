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

<template>
  <!-- Einzelnes Listenelement für eine Aufgabe -->
  <li>
    <!-- Text der Aufgabe, mit einem CSS-Klasse-Bindung, wenn die Aufgabe erledigt ist -->
    <span :class="{ completed: todo.completed }">{{ todo.text }}</span>
    <!-- Button zum Umschalten des Erledigt-Status -->
    <button @click="switchComplete">Erledigt</button>
    <!-- Button zum Löschen der Aufgabe, löst ein benutzerdefiniertes Event aus -->
    <button @click="$emit('deleteToDo')">Löschen</button>
  </li>
</template>

<style>
/* CSS-Klasse für erledigte Aufgaben */
.completed {
  text-decoration: line-through; /* Durchstreichen des Textes */
}
</style>