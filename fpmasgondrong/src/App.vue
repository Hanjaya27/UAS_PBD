<template>
  <div id="app">
    <AppHeader v-if="$route.meta.showHeader !== false" />
    <main class="main-content">
      <router-view />
    </main>
    <AppFooter />
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader.vue'
import AppFooter from '@/components/Footer.vue'

export default {
  components: {
    AppHeader,
    AppFooter
  }
}
</script>

<style>
#app {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
}


.main-content {
  flex: 1;
  width: 100%;
  margin: 0;
  padding: 0;
}


</style>