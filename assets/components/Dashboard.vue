<template>
  <div>
    <h1>Dashboard</h1>
    <!-- Verifica se la sessione è valida -->
    <div v-if="session.sessionIsValid">
      <div style="display: none;">
        <pre>Sessione valida: {{ session.sessionIsValid }}</pre>
        <pre>Informazioni sulla sessione: {{ session.sessionInfo }}</pre>
        <pre>Ruolo della sessione: {{ session.sessionRole }}</pre>
      </div>
    </div>
    <div v-else>
      <p>Sessione non valida. Si prega di effettuare l'accesso.</p>
    </div>
  </div>
</template>

<script setup>
import { useSession } from '../session.js';

const session = useSession();
</script>

<style scoped>

</style>

