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
    async toggleComplete() {
      try {
        const response = await fetch('http://localhost/T4-Projekt/backend/updateTodo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({ id: this.todo.id, completed: this.todo.completed ? 0 : 1 })
        });

        const data = await response.json();

        if (data.message) {
          this.todo.completed = !this.todo.completed; // Status umschalten
        } else {
          console.error(data.error); // Fehlerbehandlung
        }
      } catch (error) {
        console.error('Fehler:', error);
      }
    }
  }
};
</script>

<template>
  <!-- Einzelnes Listenelement für eine Aufgabe -->
  <li class="d-flex align-items-center justify-content-between mb-2 p-2 border rounded bg-light shadow-sm">
    <!-- Text der Aufgabe, mit einem CSS-Klasse-Bindung, wenn die Aufgabe erledigt ist -->
    <span :class="{ completed: todo.completed }" class="fw-bold">{{ todo.text }}</span>
    <!-- Button zum Umschalten des Erledigt-Status -->
    <div>
    <button 
      @click="toggleComplete" 
      class="btn btn-success btn-sm me-2"
    >
      {{ todo.completed ? 'Nicht Erledigt' : 'Erledigt' }}
    </button>

    <!-- Button zum Löschen der Aufgabe, löst ein benutzerdefiniertes Event aus -->
    <button 
      @click="$emit('deleteToDo')" 
      class="btn btn-danger btn-sm"
    >
      Löschen
    </button>
  </div>
  </li>
</template>

<style scoped>
/* CSS-Klasse für erledigte Aufgaben */
.completed {
  text-decoration: line-through; /* Durchstreichen des Textes */
  color: gray;
}
</style>
