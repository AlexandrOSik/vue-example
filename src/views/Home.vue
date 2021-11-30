<template>
  
  <header>
    <h1>
      Поздравляем, <strong>{{name}}</strong> вы смогли войти в систему!
    </h1>
    <p><router-link to="/logout">Выйти из системы</router-link></p>
  </header>

  <ul ref="noteList" class="note-list" @scroll="onScroll" @wheel="onWheel">
    <li v-for="(note, i) in userNotes" :key="i">
      <p>{{ note.body }}</p>
      <span class="time">{{ note.time }}</span>
    </li>
  </ul>

  <form @submit="addNote">
    <header>Новая заметка</header>
    <textarea v-model="newNoteBody" name="body" placeholder="Текст заметки" required></textarea>
    <input type="submit" value="Добавить">
  </form>

</template>

<style lang="less" scoped>
input {
  display:block;
  max-width:400px;
  width:100%;
  margin:auto;
}
textarea {
  display:block;
  min-height:60px;
  max-width:400px;
  width:100%;
  resize:none;
  margin:auto;
}
ul.note-list {
  width:100%;
  height:400px;
  overflow:auto;  
  background:#eee;
  padding:0;
  border:1px solid #90e;
  border-radius:10px;
  li {
    background:#fff;
    border:1px solid #000;
    border-radius:20px;
    padding:0px;
    border:1px solid #000;
    margin:10px;
    &:nth-child(2n) {
      margin-left:60px;
      header {
        background-color:#226;
      }
    }
    &:nth-child(2n + 1) {
      margin-right:60px;
      header {
        background-color:#262;
      }
    }
  }

}

</style>

<script>
import { mapState, mapGetters } from 'vuex';

export default {

  data() {
    return {
      newNoteBody: ''
    };
  },

  // Вызывается после перерисовки страницы, например после добавления
  // новой заметки
  updated() {
    // Прокрутить в конец ленты
    this.$refs.noteList.scroll(0, this.$refs.noteList.scrollHeight);
  },

  computed: {
    ...mapState({
      info: state => state.user.info,
      name: state => state.user.name,
      token: state => state.user.token
    }),

    ...mapGetters([
      'userNotes'
    ])

  },

  methods: {
    addNote(e) {
      e.preventDefault();
      // Вызвать действие
      this.$store.dispatch('addUserNote', {
        body: this.newNoteBody
      });
    }
  },

  created() {
    this.$store.dispatch('loadUserNotes');
  }

};
</script>
