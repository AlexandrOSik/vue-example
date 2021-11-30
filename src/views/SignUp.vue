<template>
  <div class="modal-window-background">
    <form mathod="POST" 
          @submit="registrate"
          class="login-panel"
          ref="form">
      <header>Регистрация</header>
      <ul>
        <li>
          <label>Имя пользователя</label>
          <input name="usr" 
                v-model="login" 
                type="login"
                required>
        </li>
        <li>
          <label>Пароль</label>
          <input name="pwd" 
                v-model="password" 
                type="password" 
                required>
        </li>
        <li>
          <label>Повторите пароль</label>
          <input v-model="confirmPassword"
                type="password" 
                required>
        </li>
        <li>
          <input type="submit" value="Зарегистрироваться">
          <router-link to="/sign-in">Вход</router-link>
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

    registrate(e) {
      e.preventDefault();
      let error = undefined;
      if (this.password === this.confirmPassword) {
        fetch("/sign-up.php", {
          method: 'POST',
          body: new FormData(this.$refs.form)
        });
      } else {
        error = 'Пароли не совпадают';
      }
      this.error = error;
    }

  }
};
</script>
