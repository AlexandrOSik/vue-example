<template>
  <div v-if="userAuthorized">
    {{ errorMessage }}
  </div>
  <div v-else>
    <header><h1>Подзравляем!</h1></header>
    <p>Вы смогли нажать кнопку "выйти".</p>
    <p>Вы можете снова <router-link to="/sign-in">войти в систему</router-link> 
       или <router-link to="/sign-in">зарегистрироваться</router-link>!</p>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {

  data() {
    return {
      errorMessage: 'Подождите'
    };
  },

  computed: mapGetters(['userAuthorized']),

  beforeRouteEnter(to, from, next) {
    // Внутри этого метода нет this
    // и чтобы его использовать нужно в next
    // передать функцию. В этой функции первый аргумент
    // это и есть this
    const logout = (self) => {
      fetch('/logout.php')
        .then(r => {
          self.$store.commit('setUser', undefined);
          self.errorMessage = 'Отлично!';
        }).catch(r => {
          console.log(r);
          self.errorMessage = 'Произошла ошибка. Не получилось выйти.';
        });
    };
    next(logout);
  },
};
</script>
