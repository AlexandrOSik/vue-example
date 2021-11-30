import { createStore } from 'vuex';
import router from './router';

// Сохранение имени пользователя и токена в браузере

let user = {    

    state: {
        user: 'user' in localStorage
              ? JSON.parse(localStorage.getItem('user'))
              : undefined
    },

    getters: {
        userAuthorized: (state) => state.user !== undefined,
        userNotes: (state) => state.user ? state.user.notes : [],
    },

    actions: {
        loadUserNotes(context) {
            console.log('action: loadUserNotes');
            fetch('/note.php')
                .then(r => r.json())
                .then(notes => {
                    context.commit('setUserNotes', notes);
                })
                .catch(e => {
                    router.push('/sign-in');
                });
        },

        addUserNote: (context, note) => {
            let index = context.state.user.notes.length;
            context.commit('addUserNote', {...note, commited: false});
            // Отправляем POST-запрос на создание новой заметки
            // Тело будет в формате JSON (Заголовок content-type)
            fetch('/note.php', {
                method: "POST",
                headers: { 
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(note)
            }).then(r => {
                context.commit('setUserNote', {index, note: { ...note, commited: true }});
            }).catch(e => {
                router.push('/sign-in');
            });
        }
    },

    mutations: {
        setUser(state, user) {
            // Какие-то данные
            localStorage.setItem('user', JSON.stringify(user));
            state.user = user;
        },

        setUserNotes(state, notes) {
            state.user.notes = notes;
        },

        addUserNote(state, note) {
            let date = new Date();
            state.user.notes.push({...note, date});
        },

        setUserNote(state, {index, note}) {
            state.user.notes[index] = note;
        }

    }
};


export default createStore({
    modules: {
        user
    }
});

