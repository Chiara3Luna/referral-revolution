<script setup>
import {useSession} from '../session.js';

import { ref, onMounted } from 'vue';
import axios from 'axios';

//funzione per recuperare la session info da /.well-known/bff-sessioninfo con axios
// const fetchSessionInfo = async () => {
//   try {
//     const response = await axios.get('https://referral.free.beeceptor.com/.well-known/bff-sessioninfo');
//     return response.data;
//   } catch (error) {
//     console.error('Errore nel recupero della session info:', error);
//     return null;
//   }
// };
//
// const sessionInfo = ref(null);
//
// onMounted(async () => {
//   //esegui il recupero della session info al caricamento del componente
//   sessionInfo.value = await fetchSessionInfo();
// });

const session = useSession();

</script>

<template>
  <div>
    <h1>Dashboard</h1>
    <!-- Mostra la session info -->
    <pre>{{ session.sessionIsValid }}</pre>
    <pre>{{ session.sessionInfo }}</pre>
    <pre>{{ session.sessionRole }}</pre>
  </div>
</template>

<style scoped>
</style>

