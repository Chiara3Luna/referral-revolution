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
          <div class="d-lg-none"><a href="/referrer/61bc2ea2-79b4-4e5c-9df6-3e13c3d9e33d/form" class="btn btn-primary" type="button">Aggiungi Invitato</a></div>
          <div class="d-none d-lg-block">
            <form name="referee" method="post">
              <div class="row row-cols-1 row-cols-xl-2">
                <div class="col">
                  <div class="mb-3"><label for="referee_firstName" class="form-label required">Nome</label><input type="text" id="referee_firstName" name="referee[firstName]" required="required" class="form-control">        </div>
                </div>
                <div class="col">
                  <div class="mb-3"><label for="referee_lastName" class="form-label required">Cognome</label><input type="text" id="referee_lastName" name="referee[lastName]" required="required" class="form-control">        </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3"><label for="referee_phoneNumber" class="form-label required">Numero di telefono</label><input type="tel" id="referee_phoneNumber" name="referee[phoneNumber]" required="required" class="form-control">        </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3"><label for="referee_email" class="form-label">E-mail</label><input type="email" id="referee_email" name="referee[email]" class="form-control">        </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3"><label for="referee_notes" class="form-label">Note aggiuntive e appuntamento</label><textarea id="referee_notes" name="referee[notes]" class="form-control"></textarea>        </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <button class="btn btn-primary" type="submit">Aggiungi invitato</button>
                </div>
              </div>
              <input type="hidden" id="referee__token" name="referee[_token]" value="1140dd1cff5.6qlLlSZBlI3v5f8NIOSiPkVXJ4H2V6TZeTCgYQfp5bc.jtgH3GAIxMbZi7R8VNPtaCNmSOrCAsC9C3L4ET-BtvaLnznaShTyxJmyxw"></form>
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
              <tr>
                <td>Test</td>
                <td>Oltre</td>
                <td>+393496609999</td>
                <td></td>
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

</script>

<style scoped>

/*aggiungere lo stile*/

</style>

