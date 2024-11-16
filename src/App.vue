<script>
// Import der ToDoList-Komponente aus der components-Ordner
import ToDoList from './components/ToDoList.vue';

export default {
  // Name der Hauptkomponente
  name: 'App',
  // Registrieren der ToDoList-Komponente, damit sie im Template verwendet werden kann
  components: {
    ToDoList
  }
};
</script>

<template>
<!-- Template definiert HTML-Struktur der Haupt-App-Komponente -->
  <div id="app">
    <!-- Einfügen der ToDoList-Komponente, die To-Do-Aufgaben verwaltet -->
    <ToDoList />
  </div>
</template>


