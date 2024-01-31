<template>
  <div>
    <navbar v-if="isAuthenticated"></navbar>
    <dashboard v-if="isAuthenticated && isReferrer"></dashboard>
  </div>
</template>

<script>
import Navbar from './Navbar.vue';
import Dashboard from './Dashboard.vue';

export default {
  components: {
    Navbar,
    Dashboard,
  },
  data() {
    return {
      isAuthenticated: false,
      isReferrer: false,
    };
  },
  created() {
    this.isAuthenticated = this.$store.state.accessToken !== null;
    this.isReferrer = this.$store.state.role === 'Referrer';
  },
};
</script>

<style scoped>

</style>
