<template>
  <div class="container d-flex flex-column" style="height: 100%;">
    <main class="flex-grow-1">
      <div class="row">
        <div class="col">
          <p>Benvenuto Un Referrer</p>
        </div>
      </div>
      <!-- lascio spazio -->
      <div style="height: 50px;"></div>

      <div class="row">
        <div class="col-12 col-md-4">
          <div class="d-lg-none">
            <a href="/referrer/61bc2ea2-79b4-4e5c-9df6-3e13c3d9e33d/form" class="btn btn-primary" type="button">Aggiungi Invitato</a>
          </div>
          <div class="d-none d-lg-block">
            <form @submit.prevent="submitForm" name="referee" method="post">
              <div class="row row-cols-1 row-cols-xl-2">
                <div class="col">
                  <div class="mb-3"><label for="referee_firstName" class="form-label required">Nome</label><input v-model="firstName" type="text" id="referee_firstName" name="referee[firstName]" required="required" class="form-control"> </div>
                </div>
                <div class="col">
                  <div class="mb-3"><label for="referee_lastName" class="form-label required">Cognome</label><input v-model="lastName" type="text" id="referee_lastName" name="referee[lastName]" required="required" class="form-control"> </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3"><label for="referee_phoneNumber" class="form-label required">Numero di telefono</label><input v-model="phoneNumber" type="tel" id="referee_phoneNumber" name="referee[phoneNumber]" required="required" class="form-control"> </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3"><label for="referee_email" class="form-label">E-mail</label><input v-model="email" type="email" id="referee_email" name="referee[email]" class="form-control"> </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3"><label for="referee_notes" class="form-label">Note aggiuntive e appuntamento</label><textarea v-model="notes" id="referee_notes" name="referee[notes]" class="form-control"></textarea> </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <button class="btn btn-primary" type="submit">Aggiungi invitato</button>
                </div>
              </div>
              <input type="hidden" id="referee__token" name="referee[_token]" value="1140dd1cff5.6qlLlSZBlI3v5f8NIOSiPkVXJ4H2V6TZeTCgYQfp5bc.jtgH3GAIxMbZi7R8VNPtaCNmSOrCAsC9C3L4ET-BtvaLnznaShTyxJmyxw">
            </form>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-8 d-flex flex-column">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Telefono</th>
                <th>E-mail</th>
              </tr>
              </thead>
              <tbody>
              <!-- Visualizza qui i dati inseriti dall'utente -->
              <tr v-if="submitted">
                <td>{{ firstName }}</td>
                <td>{{ lastName }}</td>
                <td>{{ phoneNumber }}</td>
                <td>{{ email }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      firstName: '',
      lastName: '',
      phoneNumber: '',
      email: '',
      notes: '',
      submitted: false // Flag per indicare se il form è stato inviato
    };
  },
  methods: {
    submitForm() {
      //logica per inviare i dati del form al server
      //richiesta POST con Axios??

      //mostrare i dati inseriti dall'utente nella tabella
      this.submitted = true;
    }
  }
};
</script>

<style scoped>

</style>


