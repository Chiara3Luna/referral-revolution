<template>
  <!-- Inizio navbar -->
  <header>
    <div class="container-fluid">
      <div class="navb-logo">
        <img src="#" alt="Logo">
      </div>

      <div class="navb-items d-none d-xl-flex">
        <div class="item">
          <router-link to="/dashboard">Home</router-link>
        </div>
        <div class="item" v-if="session.sessionIsValid && session.sessionRole === 'Referrer'">
          <router-link to="/referrer">Referrer</router-link>
        </div>
        <div class="item" v-if="session.sessionIsValid && session.sessionRole === 'Tutor'">
          <router-link to="/tutor">Tutor</router-link>
        </div>

        <div class="item-button">
          <button @click="logout" type="button">Logout</button>
        </div>
      </div>

      <!-- Mobile Toggler e Modal -->

    </div>
  </header>
</template>

<script>
import { useSession } from '../session.js';
import { createAuth0Client } from '@auth0/auth0-spa-js';

export default {
  computed: {
    session() {
      return useSession();
    }
  },
  methods: {
    async logout() {
      const auth0 = await createAuth0Client({
        domain: 'metodomerenda.auth0.com',
        client_id: 'client-id',
        redirect_uri: window.location.origin,
      });

      await auth0.logout();

      this.$store.commit('setAuthenticated', false);
      this.$store.commit('setUserRole', null);

      this.$router.push('/');
    },
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700&display=swap');

body{

  font-family: 'Urbanist', sans-serif;
  overflow-x: hidden;
}

a{

  text-decoration: none;
  color: currentColor;
}

a:hover{

  color: currentColor;
}

header{

  width: 100vw;
  height: 100px;
  background-color: #fff;
  box-shadow: 0px 3px 8px rgba(0, 0, 0, 25%);
  display: flex;
  align-items: center;
}

header .container-fluid{

  width: 100%;
  padding: 0 60px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

@media(max-width:992px){

  header .container-fluid{

    padding: 0 5%;
  }
}

header .navb-logo img{

  width: 140px;
  height: 66px;
}

header .navb-items{

  display: flex;
  align-items: center;
  justify-content: flex-end;
  letter-spacing: 3px;
}

header .item{

  text-align: center;
  margin-inline: 15%;
  font-size: 20px;
  letter-spacing: 3px;
  color: #102447;
  padding: 5px 0;
  transition: all .1s ease;
  border-bottom: 0px solid #64d6f4;
  border-top: 0px solid #64d6f4;
  cursor: pointer;
}

header .item:hover{

  border-bottom: 3px solid #64d6f4;
  border-top: 3px solid #64d6f4;
}

header .item-button a{

  background-color: #274d8a;
  width: 150px;
  height: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 16px;
  font-weight: 600;
  color: #fff;
  transition: all .5s ease;
}

header .item-button a:hover{

  background-color: #64d6f4;
}

header .mobile-toggler{

  font-size: 30px;
}

/* modal */

.modal-dialog{

  margin: 0;
  width: 430px;
}

@media(max-width: 450px){

  .modal-dialog{

    width: 82%;
  }
}

.modal-content{

  border-radius: 0;
  height: 100vh;
  overflow-y: scroll;
  background-color: #102447;
}

.modal-header{

  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 88%;
  margin: 0 auto;
  padding-bottom: 16px;
  border-bottom: 2px solid #fefefe;
}

.modal-header img{

  width: 140px;
  height: 66px;
  margin-top: 17.5px;
}

.modal-header .btn-close{

  background: transparent;
  opacity: 1;
}

.modal-header i{

  color: #fefefe;
  font-size: 30px;
}

.modal-body{

  width: 88%;
  margin: 0 auto;
  padding: 75px 0 0 0;
  flex: unset;
}

.modal-body .modal-line{

  width: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 7px 0;
  margin-bottom: 50px;
  cursor: pointer;
  transition: all .5s ease;
  color: #274d8a;
  border-bottom: 1px solid #274d8a;
}

.modal-body .modal-line:hover{

  color: #fefefe;
  border-bottom: 1px solid #fefefe;
}

.modal-line a{

  font-size: 17px;
  font-weight: 500;
  letter-spacing: 2.5px;
  color: #fefefe;
}

.modal-line i{

  color: currentColor;
  font-size: 30px;
  width: 35px;
  margin-right: 15px;
  padding: 0 0 3px 3px;
}

.navb-button{

  width: 100%;
  height: 47px;
  background-color: #fefefe;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 20px;
  font-weight: 700;
  color: #274d8a;
  letter-spacing: 2px;
  transition: all .5s ease;
}

.navb-button:hover{

  background-color: #274d8a;
  color: #fefefe;
}

.mobile-modal-footer{

  width: 87%;
  margin: 0 auto;
  padding: 20% 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 25px;
  color: #274d8a;
}

.mobile-modal-footer i:hover{

  color: #fefefe;
}



.section-1{

  width: 100vw;
  height: 95vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.section-1 p{

  font-size: 75px;
  font-weight: 700;
  color: #102447;
  width: 90%;
  text-align: center;
}

@media(max-width:767px){

  .section-1 p{

    font-size: 50px;
    text-align: start;
    width: 70%;
    margin: auto;
  }
}
</style>
