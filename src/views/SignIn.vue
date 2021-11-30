<template>
  <div class="modal-window-background">
    <form mathod="POST" 
          @submit="authenticate"
          class="login-panel"
          ref="form">
      <header>
        <span>Вход в систему</span>
      </header>
      <ul>
        <li>
          <label>Имя пользователя</label>
          <input name="usr" 
                v-model="login" 
                autocomplete="username"
                type="text"
                required>
        </li>
        <li>
          <label>Пароль</label>
          <input name="pwd" 
                v-model="password" 
                type="password" 
                autocomplete="new-password"
                required>
        </li>
        <li>
          <input type="submit" value="Войти">
          <router-link to="/sign-up">Регистрация</router-link>
        </li>
      </ul>
      <div class="error-box" v-show="error">{{ error }}</div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      login: '',
      password: '',
      confirmPassword: '',
      error: ''
    };
  },
  methods: {
    authenticate(e) {
      e.preventDefault();
      // AJAX запрос
      fetch("/sign-in.php", {
        method: 'POST',
        body: new FormData(this.$refs.form)
      }).then(
          r => r.json()
        ).then(r => {
          if (r.success) {
            console.log(this.$store);
            console.log(this.$store.user);
            document.router = this.$router;
            document.store = this.$store;
            this.$store.commit('setUser', { 
              name: this.login, 
              token: r.token, 
              info: { logined: new Date() } 
            });
            this.$router.push('/');
          } else {
            this.error = 'Неверные имя пользователя или пароль';
          }
        });
    }
  }
};
</script>
